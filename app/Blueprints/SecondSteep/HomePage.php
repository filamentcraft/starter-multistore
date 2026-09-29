<?php

declare(strict_types=1);

namespace App\Blueprints\SecondSteep;

use App\Blueprints\Pages\Page;
use FilamentCraft\Sections\Builtin\CategoryGridSection;
use FilamentCraft\Sections\Builtin\ImageTextSection;
use FilamentCraft\Sections\Builtin\NewsletterSection;
use FilamentCraft\Sections\Builtin\ProductCarouselSection;
use FilamentCraft\Sections\Builtin\StoreHeroSection;
use FilamentCraft\Sections\Builtin\TestimonialsSection;

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
        return 'Loose-leaf green tea, herbal blends and cast-iron teapots from a tasting counter in Glasgow.';
    }

    public function sections(): array
    {
        return [
            $this->section(StoreHeroSection::class, [
                'eyebrow' => 'Loose-leaf tea, Glasgow',
                'heading' => 'Tea worth a second pour.',
                'subheading' => 'Single-garden greens, whole-flower tisanes and the cast-iron pots to brew them in. Every lot is tasted at our counter before it goes in a tin.',
                'primary_label' => 'Shop the teas',
                'secondary_label' => 'How to brew it',
                'secondary_url' => $this->link('brewing'),
                'layout' => 'collage',
                'image' => $this->image('tasting-bowls'),
                'image_2' => $this->image('long-jing'),
                'image_3' => $this->image('iron-kettle-black'),
            ], $this->blocks('perk', [
                ['icon' => 'heroicon-o-truck', 'label' => 'Free UK delivery over '.$this->site->price($this->site->freeOver())],
                ['icon' => 'heroicon-o-banknotes', 'label' => 'Pay when it arrives'],
                ['icon' => 'heroicon-o-beaker', 'label' => 'Brewing notes on every tin'],
            ])),

            $this->section(CategoryGridSection::class, [
                'eyebrow' => '',
                'heading' => 'Start with what you drink',
                'intro' => '',
                'columns' => '3',
                'limit' => 3,
            ]),

            $this->section(ProductCarouselSection::class, [
                'eyebrow' => '',
                'heading' => 'What the counter is pouring',
                'intro' => 'The teas we open for anyone who walks in. Each one steeps at least three times.',
                'view_all_label' => 'Shop everything',
                'collection' => 'featured',
                'limit' => 8,
            ]),

            $this->section(ImageTextSection::class, [
                'eyebrow' => '',
                'title' => 'We buy small, and twice a year.',
                'body' => 'A spring picking and an autumn one, a few kilos at a time, from gardens we have bought from before. Once a tea is gone it is gone until the next harvest, which is why the shop changes every few months.',
                'url' => $this->link('brewing'),
                'label' => 'Read the brewing guide',
                'image' => $this->image('tea-bins'),
                'media_placement' => 'end',
                'align' => 'start',
            ], scheme: $this->site->accent()),

            $this->section(ProductCarouselSection::class, [
                'eyebrow' => '',
                'heading' => 'Just in',
                'intro' => '',
                'view_all_label' => 'See what is new',
                'collection' => 'new',
                'limit' => 8,
            ]),

            $this->section(TestimonialsSection::class, [
                'eyebrow' => '',
                'title' => 'Regulars at the counter',
                'intro' => '',
                'layout' => 'cards',
                'align' => 'start',
            ], $this->blocks('quote', [
                ['quote' => 'I came in for a teabag replacement and left with a Long Jing I now plan my mornings around.', 'name' => 'Iain Fraser', 'role' => 'Partick'],
                ['quote' => 'The brewing notes are the useful kind. Temperature, time and how many times it will go again.', 'name' => 'Priya Nair', 'role' => 'Dennistoun'],
                ['quote' => 'Our teapot has been going for four years. They told us never to scrub it, and they were right.', 'name' => 'Tom Gallacher', 'role' => 'Shawlands'],
            ])),

            $this->section(NewsletterSection::class, [
                'heading' => 'One email per harvest.',
                'subheading' => 'Twice a year, when the new teas land. Subscribers get first pick before the tins go on the shop.',
                'placeholder' => 'you@example.com',
                'button_label' => 'Sign me up',
                'success_message' => 'Thank you. You will hear from us when the next harvest arrives.',
            ]),
        ];
    }
}
