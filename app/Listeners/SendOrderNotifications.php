<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Filament\Resources\Orders\OrderResource;
use App\Notifications\OrderReceived;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

final class SendOrderNotifications
{
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;
        $store = $order->store;

        $order->notify(new OrderReceived($order));

        Notification::make()
            ->title("New order {$order->number}")
            ->body("{$order->customer_name} · ".$store->formatMoney($order->total))
            ->icon('heroicon-o-shopping-bag')
            ->actions([
                Action::make('view')->url(OrderResource::getUrl('view', ['record' => $order], panel: 'app', tenant: $store)),
            ])
            ->sendToDatabase($store->users);
    }
}
