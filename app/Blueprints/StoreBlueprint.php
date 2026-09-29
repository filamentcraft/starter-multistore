<?php

declare(strict_types=1);

namespace App\Blueprints;

use App\Blueprints\Concerns\BuildsSections;
use App\Blueprints\Pages\CartPage;
use App\Blueprints\Pages\CheckoutPage;
use App\Blueprints\Pages\Page;
use App\Blueprints\Pages\ProductPage;
use App\Blueprints\Pages\ShopPage;
use App\Models\Store;
use FilamentCraft\Blueprints\BlueprintRegion;
use FilamentCraft\Blueprints\SiteBlueprint;
use FilamentCraft\Enums\RegionName;
use FilamentCraft\Sections\Builtin\FooterSection;
use FilamentCraft\Sections\Builtin\HeaderSection;

abstract class StoreBlueprint extends SiteBlueprint
{
    use BuildsSections;

    public function __construct(public readonly Store $store) {}

    abstract public function scheme(): string;

    public function name(): string
    {
        return $this->store->name;
    }

    /**
     * @return list<Page>
     */
    public function pages(): array
    {
        return [
            $this->home(),
            new ShopPage($this),
            new ProductPage($this),
            new CartPage($this),
            new CheckoutPage($this),
            ...$this->morePages(),
        ];
    }

    public function regions(): array
    {
        return [
            BlueprintRegion::make(RegionName::Header)->sections([
                $this->section(HeaderSection::class, [
                    'brand_text' => $this->store->name,
                    'cta_enabled' => true,
                    'cta_label' => 'Basket',
                    'cta_url' => $this->link('cart'),
                    'show_locale_switcher' => false,
                    'sticky' => true,
                    'show_border' => true,
                ], $this->blocks('nav-link', array_map(
                    fn (array $item): array => ['label' => $item['label'], 'url' => $this->link($item['path'])],
                    $this->navigation(),
                ))),
            ]),
            BlueprintRegion::make(RegionName::Footer)->sections([
                $this->section(FooterSection::class, [
                    'brand' => $this->store->name,
                    'description' => $this->footerText(),
                    'copyright' => '© '.now()->year.' '.$this->store->name.'. A store on Stallhouse.',
                ], $this->blocks('link', array_map(
                    fn (array $item): array => ['column' => $item['column'], 'label' => $item['label'], 'url' => $this->link($item['path'])],
                    $this->footerLinks(),
                )), scheme: $this->ink()),
            ]),
        ];
    }

    public function siteSettings(): array
    {
        return [
            ...$this->look(),
            'color_scheme' => $this->scheme(),
            'schemes' => array_map($this->withStatusColors(...), $this->schemes()),
        ];
    }

    public function link(string $path = ''): string
    {
        return '/'.$this->store->slug.($path === '' ? '' : '/'.ltrim($path, '/'));
    }

    public function price(int|string $major): string
    {
        return $this->store->currency->symbol().$major;
    }

    public function shopHeading(): string
    {
        return 'Shop all';
    }

    public function previewProduct(): string
    {
        return '';
    }

    public function shipping(): string
    {
        return '4';
    }

    public function freeOver(): string
    {
        return '40';
    }

    public function accent(): string
    {
        return $this->scheme().'-accent';
    }

    public function ink(): string
    {
        return $this->scheme().'-ink';
    }

    abstract protected function home(): Page;

    /**
     * @return list<array{label: string, path: string}>
     */
    abstract protected function navigation(): array;

    /**
     * @return list<array{column: string, label: string, path: string}>
     */
    abstract protected function footerLinks(): array;

    abstract protected function footerText(): string;

    /**
     * @return array<string, array<string, string>>
     */
    abstract protected function schemes(): array;

    /**
     * @return array<string, mixed>
     */
    abstract protected function look(): array;

    /**
     * @return list<Page>
     */
    protected function morePages(): array
    {
        return [];
    }

    protected function storefront(): StoreBlueprint
    {
        return $this;
    }

    /**
     * @param  array<string, string>  $colors
     * @return array<string, string>
     */
    private function withStatusColors(array $colors): array
    {
        return [
            'on-neutral' => '#ffffff',
            'info' => '#2d5f8a',
            'on-info' => '#ffffff',
            'success' => '#2f6b3f',
            'on-success' => '#ffffff',
            'warning' => '#9a5a00',
            'on-warning' => '#ffffff',
            'danger' => '#b42318',
            'on-danger' => '#ffffff',
            ...$colors,
        ];
    }
}
