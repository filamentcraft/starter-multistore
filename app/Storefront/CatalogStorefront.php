<?php

declare(strict_types=1);

namespace App\Storefront;

use App\Actions\PlaceOrder;
use App\Models\Builders\CategoryBuilder;
use App\Models\Builders\ProductBuilder;
use App\Models\Category;
use App\Models\Product;
use FilamentCraft\Commerce\Contracts\Storefront;
use FilamentCraft\Commerce\Data\CatalogQuery;
use FilamentCraft\Commerce\Data\CategoryData;
use FilamentCraft\Commerce\Data\CustomerDetails;
use FilamentCraft\Commerce\Data\OrderResult;
use FilamentCraft\Commerce\Data\ProductData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

final readonly class CatalogStorefront implements Storefront
{
    public function __construct(
        private PlaceOrder $placeOrder,
        private CurrentStore $store,
    ) {}

    public function products(CatalogQuery $query): Collection
    {
        return Product::query()
            ->forStore($this->store->sole())
            ->published()
            ->with('category')
            ->when($query->collection === 'featured', fn (ProductBuilder $products): ProductBuilder => $products->featured())
            ->when($query->collection === 'new', fn (ProductBuilder $products): ProductBuilder => $products->newArrivals())
            ->when(filled($query->categorySlug), fn (ProductBuilder $products): ProductBuilder => $products->inCategory((string) $query->categorySlug))
            ->when(filled($query->search), fn (ProductBuilder $products): ProductBuilder => $products->search((string) $query->search))
            ->when($query->minMinor !== null, fn (ProductBuilder $products): ProductBuilder => $products->where('price', '>=', $query->minMinor))
            ->when($query->maxMinor !== null, fn (ProductBuilder $products): ProductBuilder => $products->where('price', '<=', $query->maxMinor))
            ->when(
                $query->sort,
                fn (ProductBuilder $products, string $sort): ProductBuilder => match ($sort) {
                    'price-asc' => $products->orderBy('price'),
                    'price-desc' => $products->orderByDesc('price'),
                    default => $products->ordered(),
                },
            )
            ->when($query->limit, fn (ProductBuilder $products, int $limit): ProductBuilder => $products->limit($limit))
            ->get()
            ->map(fn (Product $product): ProductData => $this->toData($product))
            ->values();
    }

    public function product(string $slug): ?ProductData
    {
        $product = Product::query()
            ->forStore($this->store->sole())
            ->published()
            ->with('category')
            ->where('slug', $slug)
            ->first();

        return $product instanceof Product ? $this->toData($product) : null;
    }

    public function categories(?int $limit = null): Collection
    {
        return Category::query()
            ->forStore($this->store->sole())
            ->ordered()
            ->withCount(['products' => fn (ProductBuilder $products): ProductBuilder => $products->published()])
            ->when($limit, fn (CategoryBuilder $categories, int $limit): CategoryBuilder => $categories->limit($limit))
            ->get()
            ->map(fn (Category $category): CategoryData => new CategoryData(
                slug: $category->slug,
                name: $category->name,
                image: $this->imageUrl($category->image),
                count: (int) $category->products_count,
                url: $this->url('category', ['slug' => $category->slug]),
            ))
            ->values();
    }

    public function category(string $slug): ?CategoryData
    {
        return $this->categories()->firstWhere('slug', $slug);
    }

    /**
     * @param  array<string, string>  $params
     */
    public function url(string $name, array $params = []): string
    {
        $base = url($this->store->sole()->slug);

        return match ($name) {
            'home' => $base,
            'shop' => "{$base}/shop",
            'cart' => "{$base}/cart",
            'checkout' => "{$base}/checkout",
            'product' => "{$base}/products/".($params['slug'] ?? ''),
            'category' => "{$base}/shop?".http_build_query(['category' => $params['slug'] ?? '']),
            default => '#',
        };
    }

    public function placeOrder(array $lines, CustomerDetails $customer): OrderResult
    {
        $order = $this->placeOrder->handle($this->store->sole(), $lines, $customer);

        if ($order === null) {
            return OrderResult::failed();
        }

        return new OrderResult(
            number: $order->number,
            totalMinor: $order->total,
            itemCount: (int) $order->items->sum('quantity'),
        );
    }

    private function toData(Product $product): ProductData
    {
        $currency = $this->store->sole()->currency;

        return new ProductData(
            slug: $product->slug,
            title: $product->name,
            priceMinor: $product->price,
            compareMinor: $product->compare_at_price ?? 0,
            currencySymbol: $currency->symbol(),
            symbolPosition: 'before',
            images: array_values(array_filter(array_map($this->imageUrl(...), $product->images ?? []))),
            categoryName: $product->category->name ?? '',
            categorySlug: $product->category->slug ?? '',
            description: (string) $product->description,
            variants: array_values($product->variants ?? []),
            attributes: $product->details ?? [],
            inStock: $product->in_stock,
            isNew: $product->is_new,
            isFeatured: $product->is_featured,
            url: $this->url('product', ['slug' => $product->slug]),
            currencyCode: $currency->value,
        );
    }

    private function imageUrl(?string $path): string
    {
        return blank($path) ? '' : Storage::disk('public')->url($path);
    }
}
