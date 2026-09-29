<?php

declare(strict_types=1);

namespace App\Blueprints\Pages;

use FilamentCraft\Sections\Builtin\CartSection;

final class CartPage extends Page
{
    public function name(): string
    {
        return 'Basket';
    }

    public function slug(): string
    {
        return 'cart';
    }

    public function description(): string
    {
        return "Your {$this->site->store->name} basket.";
    }

    public function sections(): array
    {
        return [
            $this->section(CartSection::class, [
                'heading' => 'Your basket',
                'continue_label' => 'Keep shopping',
                'checkout_label' => 'Checkout',
                'empty_title' => 'Nothing in here yet',
                'empty_body' => 'Have a look around the shop.',
                'shipping_flat' => $this->site->shipping(),
                'free_threshold' => $this->site->freeOver(),
            ]),
        ];
    }
}
