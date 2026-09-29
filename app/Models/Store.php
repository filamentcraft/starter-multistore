<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Currency;
use App\Support\Money;
use Database\Factories\StoreFactory;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use FilamentCraft\Concerns\HasSite;
use FilamentCraft\Contracts\SiteOwner;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'email', 'currency', 'order_prefix'])]
class Store extends Model implements HasCurrentTenantLabel, SiteOwner
{
    /** @use HasFactory<StoreFactory> */
    use HasFactory, HasSite;

    public const RESERVED_SLUGS = ['app', 'admin', 'filamentcraft', 'livewire', 'storage', 'up', 'css', 'js', 'fonts', 'images', 'build', 'vendor'];

    public static function slugPattern(): string
    {
        return '(?!(?:'.implode('|', self::RESERVED_SLUGS).')(?:/|$))[a-z0-9-]+';
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * @return HasMany<Category, $this>
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * @return HasMany<Product, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return HasMany<Order, $this>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getCurrentTenantLabel(): string
    {
        return 'Your store';
    }

    public function formatMoney(int $minor): string
    {
        return Money::format($minor, $this->currency);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'currency' => Currency::class,
        ];
    }
}
