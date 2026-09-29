<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Pages\Tenancy\EditStore;
use App\Filament\Pages\Tenancy\RegisterStore;
use App\Models\Product;
use App\Models\Store;
use App\Storefront\CurrentStore;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use FilamentCraft\FilamentCraftPlugin;
use FilamentCraft\Models\Site;
use FilamentCraft\Routing\DynamicTemplateDefinition;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class MerchantPanelProvider extends PanelProvider
{
    private const VERMILION = [
        50 => 'oklch(0.971 0.013 33)',
        100 => 'oklch(0.936 0.032 33)',
        200 => 'oklch(0.885 0.062 33)',
        300 => 'oklch(0.808 0.11 33)',
        400 => 'oklch(0.704 0.17 33)',
        500 => 'oklch(0.63 0.19 33)',
        600 => 'oklch(0.56 0.19 33)',
        700 => 'oklch(0.49 0.17 33)',
        800 => 'oklch(0.43 0.15 33)',
        900 => 'oklch(0.38 0.12 33)',
        950 => 'oklch(0.26 0.08 33)',
    ];

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('app')
            ->login()
            ->registration()
            ->tenantRegistration(RegisterStore::class)
            ->tenantProfile(EditStore::class)
            ->databaseNotifications()
            ->navigationGroups(['Shop', 'Website'])
            ->brandName('Stallhouse')
            ->colors([
                'primary' => self::VERMILION,
                'indigo' => Color::Indigo,
                'gray' => Color::Stone,
            ])
            ->plugin(
                FilamentCraftPlugin::make()
                    ->tenantSites(Store::class)
                    ->allowSiteCreation(false)
                    ->navigationGroup('Website')
                    ->dynamicTemplates([
                        DynamicTemplateDefinition::make('product')
                            ->path('products/{product}')
                            ->templateSlug('product')
                            ->bind('product', fn (Site $site, string $slug): ?Stringable => $site->owner instanceof Store
                                && Product::query()->forStore($site->owner)->published()->where('slug', $slug)->exists()
                                    ? Str::of($slug)
                                    : null),
                    ])
            )
            ->navigationItems([
                NavigationItem::make('View store')
                    ->url(fn (): string => url(app(CurrentStore::class)->sole()->slug), shouldOpenInNewTab: true)
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->group('Website')
                    ->sort(99),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
