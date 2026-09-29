<?php

declare(strict_types=1);

namespace App\Blueprints\Pages;

use FilamentCraft\Sections\Builtin\ProductDetailSection;

final class ProductPage extends Page
{
    public function name(): string
    {
        return 'Product';
    }

    public function slug(): string
    {
        return 'product';
    }

    public function description(): string
    {
        return "From {$this->site->store->name}.";
    }

    public function sections(): array
    {
        return [
            $this->section(ProductDetailSection::class, [
                'back_label' => 'Back to the shop',
                'add_label' => 'Add to basket',
                'show_related' => true,
                'related_heading' => 'You might also like',
                'preview_slug' => $this->site->previewProduct(),
            ]),
        ];
    }
}
