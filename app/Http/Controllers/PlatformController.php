<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Store;
use FilamentCraft\Models\Site;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

final class PlatformController
{
    public function __invoke(): View
    {
        $stores = Store::query()
            ->with(['sites' => fn ($sites) => $sites->live()])
            ->orderBy('name')
            ->get()
            ->map(fn (Store $store): ?array => $this->card($store))
            ->filter()
            ->values();

        return view('platform', ['stores' => $stores]);
    }

    /**
     * @return array{name: string, url: string, description: string, image: ?string}|null
     */
    private function card(Store $store): ?array
    {
        $site = $store->sites->first();

        if (! $site instanceof Site) {
            return null;
        }

        $seo = $site->settings_json['seo'] ?? [];
        $image = $seo['og_image'] ?? null;

        return [
            'name' => $store->name,
            'url' => url($store->slug),
            'description' => (string) ($seo['description'] ?? ''),
            'image' => is_string($image) && $image !== '' ? Storage::disk('public')->url($image) : null,
        ];
    }
}
