<?php

declare(strict_types=1);

namespace App\Support;

use FilamentCraft\Media\MediaLibrary;
use FilamentCraft\Models\Site;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class StoreImages
{
    /** @var array<string, array<string, string>> */
    public const ALT = [
        'second-steep' => [
            'tasting-bowls' => 'A row of white tasting bowls, each with a different green tea',
            'tea-bins' => 'Open trays of loose-leaf tea at a market stall',
            'long-jing' => 'Flat, pan-fired Long Jing leaves up close',
            'mao-feng' => 'Twisted Mao Feng leaves in a steel scoop',
            'jasmine-pearl' => 'Green tea scattered with jasmine petals',
            'berry-blend' => 'A bowl of hedgerow fruit blend with two wooden scoops',
            'rose-hibiscus' => 'A steel infuser of rose and hibiscus on a white table',
            'iron-kettle-black' => 'A black hobnail cast-iron teapot on its trivet',
            'iron-kettle-green' => 'A leaf-green cast-iron teapot seen from above',
            'iron-kettle-teal' => 'A deep teal cast-iron teapot with a wrapped handle',
            'willow-cups' => 'Two stacked blue-and-white willow pattern cups',
            'sencha-set' => 'A pale celadon teapot beside a cup of sencha',
        ],
        'understory' => [
            'shop-floor' => 'The Understory shop floor, crowded with plants on shelves and stands',
            'shop-window' => 'Plants on stools and tables in the Understory window',
            'monstera' => 'A monstera throwing long shadows on a terracotta wall',
            'alocasia' => 'The arrow-shaped leaves of an alocasia',
            'birds-nest-fern' => 'A bird’s nest fern with rippled leaves in a white pot',
            'pothos' => 'A trailing pothos on an old white step stool',
            'spider-plant' => 'A spider plant in a spotted fabric pot',
            'peperomia' => 'A young peperomia in a coir pot',
            'aloe' => 'A spotted aloe in a concrete pot',
            'haworthia' => 'A zebra haworthia in a mint-green pot',
            'echeveria' => 'A grey-blue echeveria rosette in a rope-textured pot',
            'cactus-trio' => 'A pink-flowering cactus in a small white pot',
            'gasteria' => 'A speckled gasteria in a white pot of pebbles',
        ],
    ];

    public static function path(string $store, string $name): string
    {
        return trim((string) config('filamentcraft.uploads.directory'), '/')."/{$store}/{$name}.jpg";
    }

    public static function publish(string $store): void
    {
        $disk = Storage::disk(MediaLibrary::uploadsDisk());

        foreach (array_keys(self::ALT[$store]) as $name) {
            if (! $disk->exists(self::path($store, $name))) {
                $disk->put(self::path($store, $name), File::get(resource_path("images/{$store}/{$name}.jpg")));
            }
        }
    }

    public static function register(Site $site, string $store): void
    {
        $library = app(MediaLibrary::class);

        foreach (self::ALT[$store] as $name => $alt) {
            $library->register($site, self::path($store, $name), name: "{$name}.jpg", mime: 'image/jpeg')
                ?->update(['title' => Str::headline($name), 'alt' => $alt]);
        }
    }
}
