<?php

declare(strict_types=1);

namespace App\Blueprints;

use App\Blueprints\Pages\Page;
use App\Blueprints\Starter\DeliveryPage;
use App\Blueprints\Starter\HomePage;

final class StarterStoreSite extends StoreBlueprint
{
    public function scheme(): string
    {
        return 'store';
    }

    protected function home(): Page
    {
        return new HomePage($this);
    }

    protected function morePages(): array
    {
        return [new DeliveryPage($this)];
    }

    protected function navigation(): array
    {
        return [
            ['label' => 'Shop all', 'path' => 'shop'],
            ['label' => 'Delivery & returns', 'path' => 'delivery'],
        ];
    }

    protected function footerLinks(): array
    {
        return [
            ['column' => 'Shop', 'label' => 'Everything', 'path' => 'shop'],
            ['column' => 'Shop', 'label' => 'Your basket', 'path' => 'cart'],
            ['column' => 'Help', 'label' => 'Delivery & returns', 'path' => 'delivery'],
        ];
    }

    protected function footerText(): string
    {
        return 'Write a line here about what you sell and where it comes from.';
    }

    protected function look(): array
    {
        return [
            'heading_font' => 'hanken-grotesk',
            'default_font' => 'hanken-grotesk',
            'button_radius' => 8,
        ];
    }

    protected function schemes(): array
    {
        return [
            $this->scheme() => [
                'background' => '#f7f7f7',
                'on-background' => '#18181b',
                'surface' => '#ffffff',
                'on-surface' => '#18181b',
                'surface-alt' => '#ececee',
                'on-surface-alt' => '#3f3f46',
                'primary' => '#18181b',
                'on-primary' => '#ffffff',
                'secondary' => '#3f3f46',
                'on-secondary' => '#ffffff',
                'accent' => '#c43d2a',
                'on-accent' => '#ffffff',
                'neutral' => '#5f5f68',
            ],
            $this->accent() => [
                'background' => '#18181b',
                'on-background' => '#fafafa',
                'surface' => '#222226',
                'on-surface' => '#fafafa',
                'surface-alt' => '#2c2c31',
                'on-surface-alt' => '#d4d4d8',
                'primary' => '#fafafa',
                'on-primary' => '#18181b',
                'secondary' => '#d4d4d8',
                'on-secondary' => '#18181b',
                'accent' => '#f08a78',
                'on-accent' => '#18181b',
                'neutral' => '#a1a1aa',
            ],
            $this->ink() => [
                'background' => '#18181b',
                'on-background' => '#fafafa',
                'surface' => '#222226',
                'on-surface' => '#fafafa',
                'surface-alt' => '#2c2c31',
                'on-surface-alt' => '#d4d4d8',
                'primary' => '#fafafa',
                'on-primary' => '#18181b',
                'secondary' => '#d4d4d8',
                'on-secondary' => '#18181b',
                'accent' => '#f08a78',
                'on-accent' => '#18181b',
                'neutral' => '#a1a1aa',
            ],
        ];
    }
}
