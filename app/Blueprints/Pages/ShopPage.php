<?php

declare(strict_types=1);

namespace App\Blueprints\Pages;

use FilamentCraft\Sections\Builtin\ProductListingSection;

final class ShopPage extends Page
{
    public function name(): string
    {
        return 'Shop';
    }

    public function slug(): string
    {
        return 'shop';
    }

    public function description(): string
    {
        return "Everything {$this->site->store->name} has in stock, with prices.";
    }

    public function sections(): array
    {
        return [
            $this->section(ProductListingSection::class, [
                'eyebrow' => '',
                'heading' => $this->site->shopHeading(),
                'show_filters' => true,
                'show_price_filter' => true,
                'columns' => '3',
            ]),
        ];
    }
}
