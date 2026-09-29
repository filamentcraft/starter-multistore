<?php

declare(strict_types=1);

namespace App\Actions;

use App\Blueprints\StarterStoreSite;
use App\Blueprints\StoreBlueprint;
use App\Models\Store;
use App\Models\User;
use FilamentCraft\Blueprints\SiteProvisioner;
use FilamentCraft\Models\Site;
use FilamentCraft\Models\Template;
use FilamentCraft\Seo\TemplateSeo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final readonly class OpenStore
{
    public function __construct(private SiteProvisioner $provisioner) {}

    /**
     * @param  array{name: string, slug: string, email: string, currency: mixed}  $attributes
     * @param  class-string<StoreBlueprint>  $blueprint
     */
    public function handle(User $owner, array $attributes, string $blueprint = StarterStoreSite::class): Store
    {
        return DB::transaction(function () use ($owner, $attributes, $blueprint): Store {
            $store = Store::query()->create([
                ...$attributes,
                'order_prefix' => $this->orderPrefix($attributes['name']),
            ]);

            $store->users()->attach($owner);

            $site = new $blueprint($store);

            $this->describePages($site, $this->provisioner->provision($site, $store, $store->name, $store->slug));

            return $store;
        });
    }

    private function describePages(StoreBlueprint $blueprint, Site $site): void
    {
        foreach ($blueprint->pages() as $page) {
            $template = Template::query()
                ->forSite($site->getKey())
                ->where('blueprint_slug', $page->slug())
                ->first();

            if ($template instanceof Template) {
                TemplateSeo::write($template, $site->default_locale, ['description' => $page->description()]);
            }
        }
    }

    private function orderPrefix(string $name): string
    {
        $words = Str::of($name)->ascii()->upper()->replaceMatches('/[^A-Z0-9 ]/', '')->explode(' ')->filter()->values();

        $prefix = $words->count() > 1
            ? $words->take(3)->map(fn (string $word): string => $word[0])->implode('')
            : Str::substr((string) $words->first(), 0, 3);

        return $prefix === '' ? 'ORD' : $prefix;
    }
}
