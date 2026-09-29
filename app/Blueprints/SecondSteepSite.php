<?php

declare(strict_types=1);

namespace App\Blueprints;

use App\Blueprints\Pages\Page;
use App\Blueprints\SecondSteep\BrewingPage;
use App\Blueprints\SecondSteep\HomePage;
use App\Support\StoreImages;

final class SecondSteepSite extends StoreBlueprint
{
    public function scheme(): string
    {
        return 'steep';
    }

    public function shopHeading(): string
    {
        return 'All teas and teaware';
    }

    public function previewProduct(): string
    {
        return 'long-jing';
    }

    protected function home(): Page
    {
        return new HomePage($this);
    }

    protected function morePages(): array
    {
        return [new BrewingPage($this)];
    }

    protected function navigation(): array
    {
        return [
            ['label' => 'Green tea', 'path' => 'shop?category=green-tea'],
            ['label' => 'Herbal', 'path' => 'shop?category=herbal'],
            ['label' => 'Teaware', 'path' => 'shop?category=teaware'],
            ['label' => 'Brewing guide', 'path' => 'brewing'],
        ];
    }

    protected function footerLinks(): array
    {
        return [
            ['column' => 'Shop', 'label' => 'Green tea', 'path' => 'shop?category=green-tea'],
            ['column' => 'Shop', 'label' => 'Herbal', 'path' => 'shop?category=herbal'],
            ['column' => 'Shop', 'label' => 'Teaware', 'path' => 'shop?category=teaware'],
            ['column' => 'Help', 'label' => 'Brewing guide', 'path' => 'brewing'],
            ['column' => 'Help', 'label' => 'Your basket', 'path' => 'cart'],
        ];
    }

    protected function footerText(): string
    {
        return 'Loose-leaf tea and cast-iron teaware from a tasting counter in Glasgow’s West End.';
    }

    protected function look(): array
    {
        return [
            'heading_font' => 'petrona',
            'default_font' => 'figtree',
            'button_radius' => 4,
            'seo' => [
                'description' => 'Single-garden green teas, whole-flower tisanes and cast-iron teapots, tasted and packed in Glasgow.',
                'og_image' => StoreImages::path($this->store->slug, 'tasting-bowls'),
            ],
        ];
    }

    protected function schemes(): array
    {
        return [
            $this->scheme() => [
                'background' => '#f6f6f5',
                'on-background' => '#1f1a19',
                'surface' => '#ffffff',
                'on-surface' => '#1f1a19',
                'surface-alt' => '#ebe8e7',
                'on-surface-alt' => '#453d3b',
                'primary' => '#7a2e1f',
                'on-primary' => '#ffffff',
                'secondary' => '#1f1a19',
                'on-secondary' => '#ffffff',
                'accent' => '#b5791a',
                'on-accent' => '#1f1a19',
                'neutral' => '#625a58',
            ],
            $this->accent() => [
                'background' => '#7a2e1f',
                'on-background' => '#ffffff',
                'surface' => '#6c281b',
                'on-surface' => '#ffffff',
                'surface-alt' => '#5f2317',
                'on-surface-alt' => '#f3dcd4',
                'primary' => '#ffffff',
                'on-primary' => '#7a2e1f',
                'secondary' => '#1f1a19',
                'on-secondary' => '#ffffff',
                'accent' => '#f2c46b',
                'on-accent' => '#1f1a19',
                'neutral' => '#e3b9ad',
            ],
            $this->ink() => [
                'background' => '#1f1a19',
                'on-background' => '#f4f1f0',
                'surface' => '#292321',
                'on-surface' => '#f4f1f0',
                'surface-alt' => '#332c2a',
                'on-surface-alt' => '#d9d1ce',
                'primary' => '#f0a58f',
                'on-primary' => '#1f1a19',
                'secondary' => '#f4f1f0',
                'on-secondary' => '#1f1a19',
                'accent' => '#f2c46b',
                'on-accent' => '#1f1a19',
                'neutral' => '#a89f9c',
            ],
        ];
    }
}
