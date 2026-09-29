<?php

declare(strict_types=1);

namespace App\Filament\Pages\Tenancy;

use App\Enums\Currency;
use App\Models\Store;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class StoreForm
{
    public static function configure(Schema $schema, bool $opening): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Store name')
                ->required()
                ->maxLength(60)
                ->live(onBlur: true)
                ->afterStateUpdated(function (?string $state, Get $get, Set $set) use ($opening): void {
                    if ($opening && blank($get('slug'))) {
                        $set('slug', Str::slug((string) $state));
                    }
                }),
            TextInput::make('slug')
                ->label('Web address')
                ->prefix(url('/').'/')
                ->required()
                ->maxLength(40)
                ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                ->notIn(Store::RESERVED_SLUGS)
                ->unique(Store::class, ignoreRecord: true)
                ->validationMessages(['regex' => 'Use lowercase letters, numbers and single dashes.'])
                ->disabled(! $opening)
                ->dehydrated($opening)
                ->helperText($opening ? 'This cannot be changed once the store is open.' : null),
            TextInput::make('email')
                ->label('Contact email')
                ->email()
                ->required()
                ->helperText('Customers reply to this address from their order emails.'),
            Select::make('currency')
                ->options(Currency::class)
                ->default(Currency::GBP)
                ->required()
                ->disabled(! $opening)
                ->dehydrated($opening),
        ]);
    }
}
