<?php

declare(strict_types=1);

namespace App\Storefront;

use App\Models\Store;
use Filament\Facades\Filament;
use FilamentCraft\Models\Region;
use FilamentCraft\Models\Site;
use FilamentCraft\Models\Template;

/**
 * FilamentCraft's Storefront is one shared service, so each call works out
 * which store it is serving from the request it is part of.
 */
final class CurrentStore
{
    public function get(): ?Store
    {
        $site = $this->boundSite() ?? $this->cartSite() ?? $this->previewSite();

        if ($site instanceof Site) {
            return $site->owner instanceof Store ? $site->owner : null;
        }

        $tenant = Filament::getTenant();

        return $tenant instanceof Store ? $tenant : null;
    }

    public function sole(): Store
    {
        return $this->get() ?? abort(404);
    }

    private function boundSite(): ?Site
    {
        return app()->bound(Site::class) ? app(Site::class) : null;
    }

    private function cartSite(): ?Site
    {
        $slug = request()->input('store');

        return is_string($slug) && $slug !== ''
            ? Site::query()->live()->where('slug', $slug)->first()
            : null;
    }

    private function previewSite(): ?Site
    {
        $route = request()->route();
        $model = $route?->parameter('template') ?? $route?->parameter('region');

        return $model instanceof Template || $model instanceof Region ? $model->site : null;
    }
}
