# Working in this project

A Laravel 13 + Filament 5 platform where every merchant runs their own store. Storefronts are
built with FilamentCraft; the catalog, basket and orders are plain Laravel, scoped per store.

- `App\Models\Store` is the Filament tenant and the FilamentCraft site owner (`SiteOwner`,
  `HasSite`). Categories, products and orders belong to a store. Query them through their
  builders in `app/Models/Builders` and always scope with `forStore($store)`.
- `App\Storefront\CurrentStore` works out which store a request is for: the site bound by the
  tenant route, the `store` field on basket and checkout posts, the template or region being
  previewed in the editor, then the Filament tenant. Use it instead of guessing from the URL.
- `App\Storefront\CatalogStorefront` is the one Storefront FilamentCraft talks to; every method
  scopes to `CurrentStore`.
- New stores are created by `App\Actions\OpenStore`, which the panel's registration page and
  the seeders both call. It provisions the storefront from a `StoreBlueprint`.
- Storefront blueprints live in `app/Blueprints`. `StoreBlueprint` builds the shared shop,
  product, basket and checkout pages; each store class adds its home page, extra pages, colors
  and fonts. Links inside a store must go through `$this->link('path')` so they keep the
  `/{store}` prefix.
- Prices are integers in minor units. Format them with `$store->formatMoney()`.
- Store slugs share the URL root with the app, so new top-level routes must be added to
  `Store::RESERVED_SLUGS`.
- Before finishing a change, run `composer test` (Pint, PHPStan level 6, Pest).
