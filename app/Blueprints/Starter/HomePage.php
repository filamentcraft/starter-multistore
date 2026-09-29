<?php

declare(strict_types=1);

namespace App\Blueprints\Starter;

use App\Blueprints\Pages\Page;
use FilamentCraft\Sections\Builtin\CategoryGridSection;
use FilamentCraft\Sections\Builtin\HeroSection;
use FilamentCraft\Sections\Builtin\ProductCarouselSection;

final class HomePage extends Page
{
    public function name(): string
    {
        return 'Home';
    }

    public function slug(): string
    {
        return 'home';
    }

    public function isHomepage(): bool
    {
        return true;
    }

    public function description(): string
    {
        return "Shop {$this->site->store->name} online.";
    }

    public function sections(): array
    {
        return [
            $this->section(HeroSection::class, [
                'eyebrow' => '',
                'heading' => $this->site->store->name,
                'subheading' => 'Say what you sell and who it is for, in a sentence or two. Every word and picture on this page can be changed in the website builder.',
                'cta_enabled' => true,
                'cta_label' => 'Shop now',
                'cta_url' => $this->link('shop'),
                'cta_secondary_label' => '',
                'cta_secondary_url' => '',
                'supporting_text' => '',
                'media_mode' => 'none',
                'layout' => 'editorial',
                'content_align' => 'start',
            ]),
            $this->section(ProductCarouselSection::class, [
                'eyebrow' => '',
                'heading' => 'New in',
                'intro' => '',
                'view_all_label' => 'Shop everything',
                'collection' => 'all',
                'limit' => 8,
            ]),
            $this->section(CategoryGridSection::class, [
                'eyebrow' => '',
                'heading' => 'Browse the shop',
                'intro' => '',
                'columns' => '3',
                'limit' => 6,
            ]),
        ];
    }
}
