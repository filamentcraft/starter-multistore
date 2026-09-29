<?php

declare(strict_types=1);

namespace App\Blueprints\Starter;

use App\Blueprints\Pages\Page;
use FilamentCraft\Sections\Builtin\FaqSection;

final class DeliveryPage extends Page
{
    public function name(): string
    {
        return 'Delivery & returns';
    }

    public function slug(): string
    {
        return 'delivery';
    }

    public function description(): string
    {
        return "How delivery and returns work at {$this->site->store->name}.";
    }

    public function sections(): array
    {
        return [
            $this->section(FaqSection::class, [
                'eyebrow' => '',
                'title' => 'Delivery & returns',
                'intro' => 'Replace these answers with your own before you take your first order.',
                'align' => 'start',
            ], $this->blocks('item', [
                ['question' => 'How much is delivery?', 'answer' => 'Delivery is '.$this->site->price($this->site->shipping()).', and free on orders over '.$this->site->price($this->site->freeOver()).'.'],
                ['question' => 'How do I pay?', 'answer' => 'You pay the courier when your order arrives, in cash or by card.'],
                ['question' => 'When will it arrive?', 'answer' => 'Orders placed before noon on a weekday are sent the same day.'],
                ['question' => 'Can I send something back?', 'answer' => 'Yes, within 30 days if it is unused. Email us and we will arrange the return.'],
            ])),
        ];
    }
}
