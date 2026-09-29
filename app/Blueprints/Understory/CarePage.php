<?php

declare(strict_types=1);

namespace App\Blueprints\Understory;

use App\Blueprints\Pages\Page;
use FilamentCraft\Sections\Builtin\FaqSection;
use FilamentCraft\Sections\Builtin\ImageTextSection;

final class CarePage extends Page
{
    public function name(): string
    {
        return 'Plant care';
    }

    public function slug(): string
    {
        return 'care';
    }

    public function description(): string
    {
        return 'How to water, place and repot the plants you buy from Understory, and how delivery works.';
    }

    public function sections(): array
    {
        return [
            $this->section(ImageTextSection::class, [
                'eyebrow' => '',
                'title' => 'Most plants die from too much care.',
                'body' => 'Overwatering kills far more houseplants than neglect. Push a finger into the soil before you water: if the top few centimetres are still damp, leave it. Water thoroughly when you do, and empty the saucer after half an hour.',
                'url' => '',
                'label' => '',
                'image' => $this->image('birds-nest-fern'),
                'media_placement' => 'end',
                'align' => 'start',
            ]),

            $this->section(FaqSection::class, [
                'eyebrow' => '',
                'title' => 'Questions we get at the counter',
                'intro' => '',
                'align' => 'start',
            ], $this->blocks('item', [
                ['question' => 'My window faces north. What will grow?', 'answer' => 'Pothos, spider plants, peperomia and bird’s nest ferns all manage in low light. Keep them within two metres of the glass.'],
                ['question' => 'How often should I water a succulent?', 'answer' => 'Every two to three weeks in summer and about once a month in winter. When in doubt, wait another week.'],
                ['question' => 'When should I repot?', 'answer' => 'In spring, when roots start coming out of the drainage holes. Go up one pot size, no more.'],
                ['question' => 'How does delivery work?', 'answer' => 'Inside Amsterdam we deliver by bike on Tuesdays and Fridays. Everywhere else in the Netherlands goes by courier in a padded box and arrives within two working days. Delivery is '.$this->site->price($this->site->shipping()).', free over '.$this->site->price($this->site->freeOver()).'.'],
                ['question' => 'What if it arrives damaged?', 'answer' => 'Send us a photo the day it arrives and we will replace it. Plants are living things and occasionally lose a leaf in transit; that is normal and they recover.'],
            ])),
        ];
    }
}
