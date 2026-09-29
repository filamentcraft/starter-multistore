<?php

declare(strict_types=1);

namespace Database\Seeders\Stores;

use App\Actions\OpenStore;
use App\Blueprints\StoreBlueprint;
use App\Enums\Currency;
use App\Enums\OrderStatus;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Support\StoreImages;
use FilamentCraft\Models\Site;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class StoreSeeder extends Seeder
{
    public function run(User $owner): void
    {
        $existing = Store::query()->where('slug', $this->store()['slug'])->first();

        if ($existing instanceof Store) {
            $owner->stores()->syncWithoutDetaching([$existing->getKey()]);

            return;
        }

        $store = app(OpenStore::class)->handle($owner, $this->store(), $this->blueprint());
        $site = $store->primarySite();

        StoreImages::publish($store->slug);

        if ($site instanceof Site) {
            StoreImages::register($site, $store->slug);
        }

        $products = $this->seedCatalog($store);

        $this->seedOrders($store, $products);
    }

    /**
     * @return array{name: string, slug: string, email: string, currency: Currency}
     */
    abstract protected function store(): array;

    /**
     * @return class-string<StoreBlueprint>
     */
    abstract protected function blueprint(): string;

    /**
     * @return array<string, array{name: string, description: string, photo: string}>
     */
    abstract protected function categories(): array;

    /**
     * @return list<array<string, mixed>>
     */
    abstract protected function products(): array;

    /**
     * @return list<array{status: OrderStatus, days_ago: int, lines: array<string, int>, customer: array{string, string, string, string, string, string, string}}>
     */
    abstract protected function orders(): array;

    /**
     * @return Collection<string, Product>
     */
    private function seedCatalog(Store $store): Collection
    {
        $categories = collect($this->categories())->map(fn (array $category, string $slug): Category => $store->categories()->create([
            'name' => $category['name'],
            'slug' => $slug,
            'description' => $category['description'],
            'image' => StoreImages::path($store->slug, $category['photo']),
            'position' => array_search($slug, array_keys($this->categories()), true),
        ]));

        return collect($this->products())->mapWithKeys(fn (array $product, int $position): array => [
            $product['slug'] => $store->products()->create([
                ...collect($product)->except('category')->all(),
                'category_id' => $categories[$product['category']]->getKey(),
                'images' => array_map(fn (string $photo): string => StoreImages::path($store->slug, $photo), $product['images']),
                'sku' => $store->order_prefix.'-'.str_pad((string) ($position + 1), 3, '0', STR_PAD_LEFT),
                'position' => $position,
            ]),
        ]);
    }

    /**
     * @param  Collection<string, Product>  $products
     */
    private function seedOrders(Store $store, Collection $products): void
    {
        $blueprint = new ($this->blueprint())($store);
        $freeOver = (int) $blueprint->freeOver() * 100;
        $flat = (int) $blueprint->shipping() * 100;

        foreach ($this->orders() as $order) {
            $items = collect($order['lines'])->map(fn (int $quantity, string $slug): array => [
                'product_id' => $products[$slug]->getKey(),
                'name' => $products[$slug]->name,
                'unit_price' => $products[$slug]->price,
                'quantity' => $quantity,
                'line_total' => $products[$slug]->price * $quantity,
            ])->values();

            $subtotal = (int) $items->sum('line_total');
            $shipping = $subtotal >= $freeOver ? 0 : $flat;
            [$name, $email, $phone, $address, $city, $postal, $country] = $order['customer'];

            Order::factory()
                ->for($store)
                ->status($order['status'])
                ->create([
                    'number' => $store->order_prefix.'-'.Str::upper(Str::random(6)),
                    'customer_name' => $name,
                    'customer_email' => $email,
                    'customer_phone' => $phone,
                    'address' => $address,
                    'city' => $city,
                    'postal' => $postal,
                    'country' => $country,
                    'subtotal' => $subtotal,
                    'shipping' => $shipping,
                    'total' => $subtotal + $shipping,
                    'placed_at' => now()->subDays($order['days_ago'])->subHours(2),
                ])
                ->items()
                ->createMany($items->all());
        }
    }
}
