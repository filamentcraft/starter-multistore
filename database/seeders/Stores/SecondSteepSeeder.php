<?php

declare(strict_types=1);

namespace Database\Seeders\Stores;

use App\Blueprints\SecondSteepSite;
use App\Enums\Currency;
use App\Enums\OrderStatus;

class SecondSteepSeeder extends StoreSeeder
{
    protected function store(): array
    {
        return [
            'name' => 'Second Steep',
            'slug' => 'second-steep',
            'email' => 'hello@secondsteep.example',
            'currency' => Currency::GBP,
        ];
    }

    protected function blueprint(): string
    {
        return SecondSteepSite::class;
    }

    protected function categories(): array
    {
        return [
            'green-tea' => ['name' => 'Green tea', 'description' => 'Pan-fired and steamed greens from single gardens.', 'photo' => 'long-jing'],
            'herbal' => ['name' => 'Herbal', 'description' => 'Whole flowers, fruit and leaves. Caffeine-free.', 'photo' => 'rose-hibiscus'],
            'teaware' => ['name' => 'Teaware', 'description' => 'Cast-iron pots and cups that hold their heat.', 'photo' => 'iron-kettle-teal'],
        ];
    }

    protected function products(): array
    {
        $green = ['Caffeine' => 'Medium', 'Tin' => '50 g'];
        $iron = ['Material' => 'Cast iron, enamel lined', 'Infuser' => 'Stainless steel, included'];

        return [
            [
                'category' => 'green-tea', 'name' => 'Long Jing', 'slug' => 'long-jing', 'price' => 1450, 'stock' => 24,
                'description' => 'Flat, pan-fired leaves from the hills west of Hangzhou. Toasted chestnut on the first steep, sweet and grassy on the second.',
                'images' => ['long-jing'], 'details' => ['Origin' => 'Zhejiang, China', 'Harvest' => 'Spring 2026', 'Brew' => '80 °C, 2 min', ...$green],
                'is_featured' => true,
            ],
            [
                'category' => 'green-tea', 'name' => 'Huangshan Mao Feng', 'slug' => 'mao-feng', 'price' => 1200, 'stock' => 18,
                'description' => 'Twisted, downy leaves picked as a bud and one leaf. Soft and floral, with none of the bite people expect from green tea.',
                'images' => ['mao-feng'], 'details' => ['Origin' => 'Anhui, China', 'Harvest' => 'Spring 2026', 'Brew' => '80 °C, 2 min', ...$green],
                'is_new' => true,
            ],
            [
                'category' => 'green-tea', 'name' => 'Jasmine Pearl', 'slug' => 'jasmine-pearl', 'price' => 1600, 'stock' => 15,
                'description' => 'Green tea scented with fresh jasmine blossom over six nights, then rolled by hand. The petals are removed before it is packed; the smell is not.',
                'images' => ['jasmine-pearl'], 'details' => ['Origin' => 'Fujian, China', 'Harvest' => 'Summer 2026', 'Brew' => '85 °C, 2 min', ...$green],
                'is_featured' => true,
            ],
            [
                'category' => 'herbal', 'name' => 'Hedgerow blend', 'slug' => 'hedgerow-blend', 'price' => 900, 'stock' => 30,
                'description' => 'Apple, rosehip, elderberry and blackcurrant leaf, with a little green tea for body. Tart, fruity and good iced.',
                'images' => ['berry-blend'], 'details' => ['Caffeine' => 'Low', 'Brew' => '100 °C, 5 min', 'Tin' => '75 g'],
                'is_new' => true,
            ],
            [
                'category' => 'herbal', 'name' => 'Rose & hibiscus', 'slug' => 'rose-hibiscus', 'price' => 950, 'stock' => 26,
                'description' => 'Whole rosebuds, hibiscus and a few marigold petals. It brews a deep red and tastes of sour cherries.',
                'images' => ['rose-hibiscus'], 'details' => ['Caffeine' => 'None', 'Brew' => '100 °C, 6 min', 'Tin' => '60 g'],
            ],
            [
                'category' => 'teaware', 'name' => 'Hobnail teapot, black', 'slug' => 'hobnail-teapot-black', 'price' => 6800, 'stock' => 7,
                'description' => 'A classic tetsubin pattern in matt black, with its own trivet. Holds enough for two cups and keeps them hot through a second pour.',
                'images' => ['iron-kettle-black'], 'details' => ['Capacity' => '600 ml', ...$iron],
                'is_featured' => true,
            ],
            [
                'category' => 'teaware', 'name' => 'Hobnail teapot, leaf green', 'slug' => 'hobnail-teapot-green', 'price' => 7200, 'stock' => 0,
                'description' => 'The same pot in a bright leaf-green enamel. We get six a season and they go quickly.',
                'images' => ['iron-kettle-green'], 'details' => ['Capacity' => '600 ml', ...$iron],
            ],
            [
                'category' => 'teaware', 'name' => 'Round teapot, deep teal', 'slug' => 'round-teapot-teal', 'price' => 7200, 'stock' => 5,
                'description' => 'A smaller, rounder pot with a cord-wrapped handle that stays cool enough to hold.',
                'images' => ['iron-kettle-teal'], 'details' => ['Capacity' => '450 ml', ...$iron],
                'is_new' => true,
            ],
            [
                'category' => 'teaware', 'name' => 'Willow cups, pair', 'slug' => 'willow-cups', 'price' => 2200, 'stock' => 12,
                'description' => 'Two porcelain cups in a hand-painted willow pattern. Small enough for strong tea, big enough for a proper mug of it.',
                'images' => ['willow-cups'], 'details' => ['Capacity' => '180 ml each', 'Material' => 'Porcelain', 'Dishwasher' => 'Top shelf'],
                'compare_at_price' => 2600,
                'is_featured' => true,
            ],
            [
                'category' => 'teaware', 'name' => 'Celadon pot and cup', 'slug' => 'celadon-set', 'price' => 3800, 'stock' => 9,
                'description' => 'A side-handled pot in a pale celadon glaze, with a matching cup and a cork coaster. Made for one person and a slow morning.',
                'images' => ['sencha-set'], 'details' => ['Capacity' => '350 ml pot, 120 ml cup', 'Material' => 'Stoneware'],
                'is_new' => true,
            ],
        ];
    }

    protected function orders(): array
    {
        return [
            ['status' => OrderStatus::Pending, 'days_ago' => 0, 'lines' => ['long-jing' => 2, 'willow-cups' => 1], 'customer' => ['Ewan Murray', 'ewan.murray@example.com', '07700 900312', '18 Hyndland Road', 'Glasgow', 'G12 9UP', 'United Kingdom']],
            ['status' => OrderStatus::Pending, 'days_ago' => 1, 'lines' => ['hobnail-teapot-black' => 1], 'customer' => ['Leila Haddad', 'leila.haddad@example.com', '07700 900548', '7 Marchmont Road', 'Edinburgh', 'EH9 1HY', 'United Kingdom']],
            ['status' => OrderStatus::Confirmed, 'days_ago' => 2, 'lines' => ['jasmine-pearl' => 1, 'mao-feng' => 1], 'customer' => ['Callum Reid', 'callum.reid@example.com', '07700 900233', '3 Ashton Lane', 'Glasgow', 'G12 8SJ', 'United Kingdom']],
            ['status' => OrderStatus::Shipped, 'days_ago' => 5, 'lines' => ['hedgerow-blend' => 2, 'rose-hibiscus' => 1], 'customer' => ['Grace Adeyemi', 'grace.adeyemi@example.com', '07700 900871', '52 Albert Road', 'Aberdeen', 'AB25 1XS', 'United Kingdom']],
            ['status' => OrderStatus::Delivered, 'days_ago' => 12, 'lines' => ['celadon-set' => 1, 'long-jing' => 1], 'customer' => ['Martin Kerr', 'martin.kerr@example.com', '07700 900154', '11 Perth Road', 'Dundee', 'DD1 4LN', 'United Kingdom']],
            ['status' => OrderStatus::Delivered, 'days_ago' => 20, 'lines' => ['round-teapot-teal' => 1, 'jasmine-pearl' => 2], 'customer' => ['Hannah Doyle', 'hannah.doyle@example.com', '07700 900642', '17 Pontcanna Street', 'Cardiff', 'CF11 9HQ', 'United Kingdom']],
        ];
    }
}
