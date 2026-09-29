<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\Currency;
use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Storefront\CurrentStore;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestOrders extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Latest orders')
            ->query(fn () => Order::query()->forStore(app(CurrentStore::class)->sole())->latest('placed_at')->limit(6))
            ->columns([
                TextColumn::make('number')->weight('medium'),
                TextColumn::make('customer_name')->label('Customer'),
                TextColumn::make('status')->badge(),
                TextColumn::make('total')->money(fn (): Currency => app(CurrentStore::class)->sole()->currency, divideBy: 100),
                TextColumn::make('placed_at')->label('Placed')->since(),
            ])
            ->recordUrl(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
            ->headerActions([
                Action::make('all')->label('All orders')->link()->url(OrderResource::getUrl()),
            ])
            ->paginated(false);
    }
}
