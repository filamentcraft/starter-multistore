<?php

declare(strict_types=1);

namespace App\Blueprints\SecondSteep;

use App\Blueprints\Pages\Page;
use FilamentCraft\Sections\Builtin\FaqSection;
use FilamentCraft\Sections\Builtin\ImageTextSection;

final class BrewingPage extends Page
{
    public function name(): string
    {
        return 'Brewing guide';
    }

    public function slug(): string
    {
        return 'brewing';
    }

    public function description(): string
    {
        return 'Water temperature, steeping times and how many times each Second Steep tea will go again.';
    }

    public function sections(): array
    {
        return [
            $this->section(ImageTextSection::class, [
                'eyebrow' => '',
                'title' => 'Cooler water, shorter steeps, more pots.',
                'body' => 'Most bitter green tea is green tea brewed like black tea. Let the kettle sit for a few minutes after it boils, use a little more leaf than feels right and pour it off early. Then do it again. Good leaf opens up over three or four steeps.',
                'url' => '',
                'label' => '',
                'image' => $this->image('sencha-set'),
                'media_placement' => 'start',
                'align' => 'start',
            ]),

            $this->section(FaqSection::class, [
                'eyebrow' => '',
                'title' => 'By the tin',
                'intro' => 'Amounts are for a 250 ml pot. Add 30 seconds for every steep after the first.',
                'align' => 'start',
            ], $this->blocks('item', [
                ['question' => 'Long Jing and Mao Feng', 'answer' => '3 g of leaf, water at 80 °C, 2 minutes. Good for three steeps.'],
                ['question' => 'Jasmine Pearl', 'answer' => '8 to 10 pearls, water at 85 °C, 2 minutes. Watch them unroll. Four steeps.'],
                ['question' => 'Hedgerow and Rose & Hibiscus', 'answer' => 'A heaped teaspoon, water straight off the boil, 5 to 7 minutes. These do not mind being forgotten.'],
                ['question' => 'Caring for a cast-iron pot', 'answer' => 'Rinse with hot water only, never soap, and dry it over a low heat or upside down. Empty it after every pot so the enamel lining lasts.'],
                ['question' => 'How long does loose tea keep?', 'answer' => 'Greens are at their best within six months of opening, herbal blends within a year. Keep the tin closed and away from the stove.'],
            ])),
        ];
    }
}
