<?php

declare(strict_types=1);

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Notifications\OrderReceived;
use Filament\Notifications\DatabaseNotification;
use FilamentCraft\Commerce\ShippingSignature;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('public');
    Notification::fake();

    $this->seed();
});

function checkoutAt(string $store, int $flat, int $threshold): array
{
    return [
        'name' => 'Owen Pritchard',
        'email' => 'owen@example.com',
        'phone' => '07700 900123',
        'address' => '12 Clive Street',
        'city' => 'Cardiff',
        'postal' => 'CF11 7JA',
        'country' => 'United Kingdom',
        'shipping_flat' => $flat,
        'free_threshold' => $threshold,
        'shipping_sig' => ShippingSignature::sign($flat, $threshold, $store),
        'store' => $store,
        'return' => "/{$store}/checkout",
    ];
}

it('places an order with the store it was made in', function (): void {
    $this->post(route('filamentcraft.cart.add'), ['slug' => 'monstera', 'store' => 'understory']);

    $this->get('/understory/checkout')->assertOk()->assertSee('Monstera deliciosa');

    $this->post(route('filamentcraft.cart.checkout'), checkoutAt('understory', 600, 5000))
        ->assertRedirectContains('/understory/checkout?placed=');

    $order = Order::query()->with('store')->latest('id')->firstOrFail();

    expect($order->store->slug)->toBe('understory')
        ->and($order->number)->toStartWith('UND-')
        ->and($order->status)->toBe(OrderStatus::Pending)
        ->and($order->total)->toBe(5500)
        ->and(Product::query()->where('slug', 'monstera')->value('stock'))->toBe(5);

    Notification::assertSentTo($order, OrderReceived::class);
    Notification::assertSentTo(User::query()->where('email', 'admin@example.com')->sole(), DatabaseNotification::class);
});

it('only notifies the people who run that store', function (): void {
    $outsider = User::factory()->create();
    $outsider->stores()->attach(Store::factory()->create());

    $this->post(route('filamentcraft.cart.add'), ['slug' => 'long-jing', 'store' => 'second-steep']);
    $this->post(route('filamentcraft.cart.checkout'), checkoutAt('second-steep', 400, 4000));

    Notification::assertNotSentTo($outsider, DatabaseNotification::class);
});

it('keeps a separate basket for each store', function (): void {
    $this->post(route('filamentcraft.cart.add'), ['slug' => 'long-jing', 'store' => 'second-steep']);

    $this->get('/second-steep/cart')->assertSee('Long Jing');
    $this->get('/understory/cart')->assertDontSee('Long Jing');
});

it('will not add another store’s product to the basket', function (): void {
    $this->post(route('filamentcraft.cart.add'), ['slug' => 'long-jing', 'store' => 'understory'])
        ->assertSessionHas('fc_cart_error');
});

it('charges the store’s delivery below its free threshold', function (): void {
    $this->post(route('filamentcraft.cart.add'), ['slug' => 'haworthia', 'store' => 'understory']);
    $this->post(route('filamentcraft.cart.checkout'), checkoutAt('understory', 600, 5000));

    expect(Order::query()->latest('id')->firstOrFail()->total)->toBe(1800);
});
