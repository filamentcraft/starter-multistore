<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum Currency: string implements HasColor, HasIcon, HasLabel
{
    case GBP = 'GBP';
    case EUR = 'EUR';
    case USD = 'USD';

    public function getLabel(): string
    {
        return match ($this) {
            self::GBP => 'Pound sterling (£)',
            self::EUR => 'Euro (€)',
            self::USD => 'US dollar ($)',
        };
    }

    public function getColor(): string
    {
        return 'gray';
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::GBP => Heroicon::OutlinedCurrencyPound,
            self::EUR => Heroicon::OutlinedCurrencyEuro,
            self::USD => Heroicon::OutlinedCurrencyDollar,
        };
    }

    public function symbol(): string
    {
        return match ($this) {
            self::GBP => '£',
            self::EUR => '€',
            self::USD => '$',
        };
    }
}
