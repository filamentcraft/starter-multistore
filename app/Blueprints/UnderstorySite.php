<?php

declare(strict_types=1);

namespace App\Blueprints;

use App\Blueprints\Pages\Page;
use App\Blueprints\Understory\CarePage;
use App\Blueprints\Understory\HomePage;
use App\Support\StoreImages;

final class UnderstorySite extends StoreBlueprint
{
    public function scheme(): string
    {
        return 'understory';
    }

    public function shopHeading(): string
    {
        return 'All plants';
    }

    public function previewProduct(): string
    {
        return 'monstera';
    }

    public function shipping(): string
    {
        return '6';
    }

    public function freeOver(): string
    {
        return '50';
    }

    protected function home(): Page
    {
        return new HomePage($this);
    }

    protected function morePages(): array
    {
        return [new CarePage($this)];
    }

    protected function navigation(): array
    {
        return [
            ['label' => 'Easy-going', 'path' => 'shop?category=easy-going'],
            ['label' => 'Statement plants', 'path' => 'shop?category=statement'],
            ['label' => 'Succulents', 'path' => 'shop?category=succulents'],
            ['label' => 'Plant care', 'path' => 'care'],
        ];
    }

    protected function footerLinks(): array
    {
        return [
            ['column' => 'Plants', 'label' => 'Easy-going', 'path' => 'shop?category=easy-going'],
            ['column' => 'Plants', 'label' => 'Statement plants', 'path' => 'shop?category=statement'],
            ['column' => 'Plants', 'label' => 'Succulents & cacti', 'path' => 'shop?category=succulents'],
            ['column' => 'Help', 'label' => 'Plant care', 'path' => 'care'],
            ['column' => 'Help', 'label' => 'Your basket', 'path' => 'cart'],
        ];
    }

    protected function footerText(): string
    {
        return 'A plant shop on the Lindengracht in Amsterdam. Delivered by bike in the city, by courier everywhere else in the Netherlands.';
    }

    protected function look(): array
    {
        return [
            'heading_font' => 'gloock',
            'default_font' => 'hanken-grotesk',
            'button_radius' => 20,
            'seo' => [
                'description' => 'Houseplants for the light you actually have, repotted and delivered across the Netherlands from Amsterdam.',
                'og_image' => StoreImages::path($this->store->slug, 'shop-window'),
            ],
        ];
    }

    protected function schemes(): array
    {
        return [
            $this->scheme() => [
                'background' => '#f3f5f4',
                'on-background' => '#16201b',
                'surface' => '#ffffff',
                'on-surface' => '#16201b',
                'surface-alt' => '#e4e9e6',
                'on-surface-alt' => '#35423b',
                'primary' => '#a8471f',
                'on-primary' => '#ffffff',
                'secondary' => '#16201b',
                'on-secondary' => '#ffffff',
                'accent' => '#2f5b43',
                'on-accent' => '#ffffff',
                'neutral' => '#56635c',
            ],
            $this->accent() => [
                'background' => '#a8471f',
                'on-background' => '#ffffff',
                'surface' => '#963f1b',
                'on-surface' => '#ffffff',
                'surface-alt' => '#843717',
                'on-surface-alt' => '#fbe1d5',
                'primary' => '#ffffff',
                'on-primary' => '#a8471f',
                'secondary' => '#16201b',
                'on-secondary' => '#ffffff',
                'accent' => '#cfe5d6',
                'on-accent' => '#16201b',
                'neutral' => '#f1c3ae',
            ],
            $this->ink() => [
                'background' => '#16201b',
                'on-background' => '#eef2ef',
                'surface' => '#1e2a24',
                'on-surface' => '#eef2ef',
                'surface-alt' => '#27352e',
                'on-surface-alt' => '#cdd8d1',
                'primary' => '#f0a07c',
                'on-primary' => '#16201b',
                'secondary' => '#eef2ef',
                'on-secondary' => '#16201b',
                'accent' => '#9fd0b0',
                'on-accent' => '#16201b',
                'neutral' => '#98a69e',
            ],
        ];
    }
}
