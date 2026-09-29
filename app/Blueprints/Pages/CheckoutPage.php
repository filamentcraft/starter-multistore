<?php

declare(strict_types=1);

namespace App\Blueprints\Pages;

use FilamentCraft\Sections\Builtin\CheckoutSection;

final class CheckoutPage extends Page
{
    public function name(): string
    {
        return 'Checkout';
    }

    public function slug(): string
    {
        return 'checkout';
    }

    public function description(): string
    {
        return "Checkout at {$this->site->store->name}.";
    }

    public function sections(): array
    {
        return [
            $this->section(CheckoutSection::class, [
                'heading' => 'Checkout',
                'subheading' => 'Tell us where to send it. You pay the courier when it arrives, so there is no card to enter.',
                'place_label' => 'Place order',
                'cod_label' => 'Pay on delivery',
                'cod_help' => 'Cash or card to the courier at your door.',
                'success_title' => 'Thank you. Your order is in.',
                'success_body' => 'A confirmation is on its way to your inbox. We will email again when it ships.',
                'shipping_flat' => $this->site->shipping(),
                'free_threshold' => $this->site->freeOver(),
            ]),
        ];
    }
}
