<?php

declare(strict_types=1);

namespace App\Blueprints\Understory;

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
        return 'Houseplants chosen for the light you have, repotted in Amsterdam and delivered across the Netherlands.';
    }

    public function sections(): array
    {
        return [
            $this->section(StoreHeroSection::class, [
                'eyebrow' => 'Plant shop, Amsterdam',
                'heading' => 'Plants that suit the light you have.',
                'subheading' => 'Tell us which way your window faces and we will tell you what will do well there. Every plant leaves the shop repotted, watered and labelled.',
                'primary_label' => 'Shop plants',
                'secondary_label' => 'Plant care',
                'secondary_url' => $this->link('care'),
                'layout' => 'collage',
                'image' => $this->image('shop-window'),
                'image_2' => $this->image('monstera'),
                'image_3' => $this->image('pothos'),
            ], $this->blocks('perk', [
                ['icon' => 'heroicon-o-truck', 'label' => 'Free delivery over '.$this->site->price($this->site->freeOver())],
                ['icon' => 'heroicon-o-banknotes', 'label' => 'Pay on delivery'],
                ['icon' => 'heroicon-o-sun', 'label' => 'A care card with every plant'],
            ])),

            $this->section(CategoryGridSection::class, [
                'eyebrow' => '',
                'heading' => 'Find your plant',
                'intro' => '',
                'columns' => '3',
                'limit' => 3,
            ]),

            $this->section(ProductCarouselSection::class, [
                'eyebrow' => '',
                'heading' => 'Hard to kill, easy to love',
                'intro' => 'The plants we send home with first-time owners. They forgive a missed watering.',
                'view_all_label' => 'Shop all plants',
                'collection' => 'featured',
                'limit' => 8,
            ]),

            $this->section(ImageTextSection::class, [
                'eyebrow' => '',
                'title' => 'Bring us your sad plant.',
                'body' => 'Every Saturday morning the repotting bench is open. Bring in anything that is drooping, yellowing or has outgrown its pot, and we will look at the roots, repot it in fresh soil and tell you what went wrong. You pay for the pot and nothing else.',
                'url' => $this->link('care'),
                'label' => 'Read the care guide',
                'image' => $this->image('shop-floor'),
                'media_placement' => 'start',
                'align' => 'start',
            ], scheme: $this->site->accent()),

            $this->section(ProductCarouselSection::class, [
                'eyebrow' => '',
                'heading' => 'New on the shelves',
                'intro' => '',
                'view_all_label' => 'See what is new',
                'collection' => 'new',
                'limit' => 8,
            ]),

            $this->section(TestimonialsSection::class, [
                'eyebrow' => '',
                'title' => 'Still alive, and growing',
                'intro' => '',
                'layout' => 'cards',
                'align' => 'start',
            ], $this->blocks('quote', [
                ['quote' => 'Our flat faces north and I had given up. They sold me a pothos and a bird’s nest fern, and both have doubled in a year.', 'name' => 'Daan Visser', 'role' => 'De Pijp'],
                ['quote' => 'The monstera arrived by bike, in the rain, completely unharmed. The care card is still on the fridge.', 'name' => 'Sanne de Boer', 'role' => 'Oost'],
                ['quote' => 'I brought in a dying fiddle-leaf fig. They were honest that it would not make it and sold me something that would.', 'name' => 'Youssef El Amrani', 'role' => 'Utrecht'],
            ])),

            $this->section(NewsletterSection::class, [
                'heading' => 'A reminder when it is time to repot.',
                'subheading' => 'Four emails a year, one per season, on what your plants need right now.',
                'placeholder' => 'you@example.com',
                'button_label' => 'Remind me',
                'success_message' => 'Thank you. The next one goes out at the start of the season.',
            ]),
        ];
    }
}
