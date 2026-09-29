<?php

declare(strict_types=1);

namespace Database\Seeders\Stores;

use App\Blueprints\UnderstorySite;
use App\Enums\Currency;
use App\Enums\OrderStatus;

class UnderstorySeeder extends StoreSeeder
{
    protected function store(): array
    {
        return [
            'name' => 'Understory',
            'slug' => 'understory',
            'email' => 'hallo@understory.example',
            'currency' => Currency::EUR,
        ];
    }

    protected function blueprint(): string
    {
        return UnderstorySite::class;
    }

    protected function categories(): array
    {
        return [
            'easy-going' => ['name' => 'Easy-going', 'description' => 'Low light, missed waterings, first-time owners. All fine.', 'photo' => 'spider-plant'],
            'statement' => ['name' => 'Statement plants', 'description' => 'Big leaves for a bright corner.', 'photo' => 'alocasia'],
            'succulents' => ['name' => 'Succulents & cacti', 'description' => 'For the sunniest windowsill in the house.', 'photo' => 'echeveria'],
        ];
    }

    protected function products(): array
    {
        return [
            [
                'category' => 'easy-going', 'name' => 'Golden pothos', 'slug' => 'pothos', 'price' => 1800, 'stock' => 20,
                'description' => 'Trails from a shelf or climbs a moss pole. Grows in almost any light and tells you it is thirsty by drooping, then perks up within the hour.',
                'images' => ['pothos'], 'details' => ['Light' => 'Low to bright, indirect', 'Water' => 'When the top 3 cm are dry', 'Pot' => '12 cm', 'Pet safe' => 'No'],
                'is_featured' => true,
            ],
            [
                'category' => 'easy-going', 'name' => 'Spider plant', 'slug' => 'spider-plant', 'price' => 1600, 'stock' => 16,
                'description' => 'Arching striped leaves and, once it is settled, baby plants on long runners that you can pot up and give away.',
                'images' => ['spider-plant'], 'details' => ['Light' => 'Medium, indirect', 'Water' => 'Weekly in summer', 'Pot' => '14 cm, fabric cover included', 'Pet safe' => 'Yes'],
                'is_featured' => true,
            ],
            [
                'category' => 'easy-going', 'name' => 'Peperomia', 'slug' => 'peperomia', 'price' => 1400, 'stock' => 14,
                'description' => 'A compact plant with soft, fleshy leaves that store water. Good on a desk or a narrow sill.',
                'images' => ['peperomia'], 'details' => ['Light' => 'Medium, indirect', 'Water' => 'Every 10 to 14 days', 'Pot' => '10 cm coir pot', 'Pet safe' => 'Yes'],
                'is_new' => true,
            ],
            [
                'category' => 'easy-going', 'name' => 'Bird’s nest fern', 'slug' => 'birds-nest-fern', 'price' => 2800, 'stock' => 8,
                'description' => 'Rippled, glossy fronds that unfurl from the centre. Loves a steamy bathroom and forgives a north-facing one.',
                'images' => ['birds-nest-fern'], 'details' => ['Light' => 'Low to medium', 'Water' => 'Keep lightly moist', 'Pot' => '15 cm', 'Pet safe' => 'Yes'],
                'is_new' => true,
            ],
            [
                'category' => 'statement', 'name' => 'Monstera deliciosa', 'slug' => 'monstera', 'price' => 5500, 'stock' => 6,
                'description' => 'The one everybody wants. Ours are grown on a moss pole and already splitting their leaves, about 80 cm tall on arrival.',
                'images' => ['monstera'], 'details' => ['Light' => 'Bright, indirect', 'Water' => 'When the top 5 cm are dry', 'Pot' => '21 cm', 'Height' => 'About 80 cm', 'Pet safe' => 'No'],
                'is_featured' => true,
            ],
            [
                'category' => 'statement', 'name' => 'Alocasia Jacklyn', 'slug' => 'alocasia', 'price' => 4200, 'compare_at_price' => 4800, 'stock' => 4,
                'description' => 'Deeply cut, dark-veined leaves on tall stems. Dramatic and a little demanding: warm, bright and never cold feet.',
                'images' => ['alocasia'], 'details' => ['Light' => 'Bright, indirect', 'Water' => 'Keep lightly moist', 'Pot' => '17 cm', 'Pet safe' => 'No'],
            ],
            [
                'category' => 'succulents', 'name' => 'Tiger aloe', 'slug' => 'aloe', 'price' => 1900, 'stock' => 12,
                'description' => 'Thick, speckled leaves in a tight rosette, in a cast concrete pot. Give it your sunniest window and ignore it.',
                'images' => ['aloe'], 'details' => ['Light' => 'Full sun', 'Water' => 'Every 2 to 3 weeks', 'Pot' => '12 cm concrete', 'Pet safe' => 'No'],
            ],
            [
                'category' => 'succulents', 'name' => 'Zebra haworthia', 'slug' => 'haworthia', 'price' => 1200, 'stock' => 25,
                'description' => 'White-striped spikes in a mint pot. Happy with less light than most succulents, so it suits a bookshelf.',
                'images' => ['haworthia'], 'details' => ['Light' => 'Bright, some direct sun', 'Water' => 'Every 3 weeks', 'Pot' => '9 cm ceramic', 'Pet safe' => 'Yes'],
                'is_featured' => true,
            ],
            [
                'category' => 'succulents', 'name' => 'Echeveria', 'slug' => 'echeveria', 'price' => 1100, 'stock' => 0,
                'description' => 'A blue-grey rosette with a powdery coating. Handle it by the pot, not the leaves, or the bloom rubs off.',
                'images' => ['echeveria'], 'details' => ['Light' => 'Full sun', 'Water' => 'Every 2 to 3 weeks', 'Pot' => '10 cm rope-textured', 'Pet safe' => 'Yes'],
            ],
            [
                'category' => 'succulents', 'name' => 'Flowering cactus', 'slug' => 'flowering-cactus', 'price' => 1500, 'stock' => 9,
                'description' => 'A small grafted cactus topped with bright pink blooms that last for weeks.',
                'images' => ['cactus-trio'], 'details' => ['Light' => 'Full sun', 'Water' => 'Monthly', 'Pot' => '8 cm', 'Pet safe' => 'Yes'],
                'is_new' => true,
            ],
            [
                'category' => 'succulents', 'name' => 'Gasteria', 'slug' => 'gasteria', 'price' => 1300, 'stock' => 11,
                'description' => 'Tongue-shaped, speckled leaves that grow in a fan. One of the few succulents that does well away from the window.',
                'images' => ['gasteria'], 'details' => ['Light' => 'Medium to bright', 'Water' => 'Every 3 weeks', 'Pot' => '12 cm with pebbles', 'Pet safe' => 'Yes'],
                'is_new' => true,
            ],
        ];
    }

    protected function orders(): array
    {
        return [
            ['status' => OrderStatus::Pending, 'days_ago' => 0, 'lines' => ['monstera' => 1], 'customer' => ['Daan Visser', 'daan.visser@example.com', '06 12345678', 'Van Woustraat 112', 'Amsterdam', '1073 LS', 'Netherlands']],
            ['status' => OrderStatus::Confirmed, 'days_ago' => 1, 'lines' => ['pothos' => 2, 'peperomia' => 1], 'customer' => ['Noor Bakker', 'noor.bakker@example.com', '06 23456789', 'Oudegracht 64', 'Utrecht', '3511 AS', 'Netherlands']],
            ['status' => OrderStatus::Shipped, 'days_ago' => 3, 'lines' => ['haworthia' => 3, 'aloe' => 1], 'customer' => ['Youssef El Amrani', 'youssef.elamrani@example.com', '06 34567890', 'Witte de Withstraat 20', 'Rotterdam', '3012 BP', 'Netherlands']],
            ['status' => OrderStatus::Delivered, 'days_ago' => 9, 'lines' => ['alocasia' => 1, 'birds-nest-fern' => 1], 'customer' => ['Pieter de Jong', 'pieter.dejong@example.com', '06 45678901', 'Lange Voorhout 8', 'Den Haag', '2514 ED', 'Netherlands']],
            ['status' => OrderStatus::Cancelled, 'days_ago' => 15, 'lines' => ['spider-plant' => 1], 'customer' => ['Sanne de Boer', 'sanne.deboer@example.com', '06 56789012', 'Javastraat 41', 'Amsterdam', '1094 HB', 'Netherlands']],
        ];
    }
}
