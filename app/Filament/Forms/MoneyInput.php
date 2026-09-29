<?php

declare(strict_types=1);

namespace App\Filament\Forms;

use App\Storefront\CurrentStore;
use Filament\Forms\Components\TextInput;

class MoneyInput extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->numeric()
            ->minValue(0)
            ->step(0.01)
            ->prefix(fn (): string => app(CurrentStore::class)->sole()->currency->symbol())
            ->formatStateUsing(fn (?int $state): ?string => $state === null ? null : number_format($state / 100, 2, '.', ''))
            ->dehydrateStateUsing(fn (string|int|float|null $state): ?int => blank($state) ? null : (int) round((float) $state * 100));
    }
}
