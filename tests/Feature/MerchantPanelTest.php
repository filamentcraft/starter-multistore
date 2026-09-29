<?php

declare(strict_types=1);

use App\Actions\ChangeOrderStatus;
use App\Enums\Currency;
use App\Enums\OrderStatus;
use App\Filament\Pages\Tenancy\RegisterStore;
use App\Filament\Resources\Orders\Pages\ViewOrder;
use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Widgets\StoreStats;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Filament\Facades\Filament;
use FilamentCraft\Models\Site;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function (): void {
    Storage::fake('public');

    $this->seed();
    $this->merchant = User::query()->where('email', 'admin@example.com')->sole();
    $this->tea = Store::query()->where('slug', 'second-steep')->sole();
    $this->plants = Store::query()->where('slug', 'understory')->sole();
});

function actingInStore(User $user, Store $store): void
{
    test()->actingAs($user);
    Filament::setCurrentPanel('app');
    Filament::setTenant($store);
    Filament::bootCurrentPanel();
}

it('sends guests to the sign-in page', function (): void {
    $this->get('/app')->assertRedirect('/app/login');
});

it('opens a store with a live storefront for a new merchant', function (): void {
    $newcomer = User::factory()->create();
    $this->actingAs($newcomer);
    Filament::setCurrentPanel('app');

    Livewire::test(RegisterStore::class)
        ->fillForm([
            'name' => 'Fold & Press',
            'slug' => 'fold-and-press',
            'email' => 'shop@foldandpress.example',
            'currency' => Currency::EUR,
        ])
        ->call('register')
        ->assertHasNoFormErrors();

    $store = Store::query()->where('slug', 'fold-and-press')->sole();

    expect($store->users->pluck('id')->all())->toBe([$newcomer->id])
        ->and($store->order_prefix)->toBe('FP')
        ->and($store->primarySite())->toBeInstanceOf(Site::class);

    $this->get('/fold-and-press')->assertOk()->assertSee('Fold &amp; Press', escape: false);
    $this->get('/fold-and-press/delivery')->assertOk()->assertSee('€4');
});

it('refuses store addresses the app already uses', function (string $slug): void {
    actingInStore($this->merchant, $this->tea);

    Livewire::test(RegisterStore::class)
        ->fillForm(['name' => 'Taken', 'slug' => $slug, 'email' => 'a@example.com', 'currency' => Currency::GBP])
        ->call('register')
        ->assertHasFormErrors(['slug']);
})->with(['app', 'second-steep', 'Not A Slug']);

it('shows a merchant only the products of the store they are in', function (): void {
    actingInStore($this->merchant, $this->plants);

    Livewire::test(ListProducts::class)
        ->assertCanSeeTableRecords(Product::query()->forStore($this->plants)->get())
        ->assertCanNotSeeTableRecords(Product::query()->forStore($this->tea)->get());

    Livewire::test(StoreStats::class)->assertSee('€');
});

it('keeps merchants out of stores they do not belong to', function (): void {
    $stranger = User::factory()->create();

    $this->actingAs($stranger)->get("/app/{$this->tea->slug}")->assertNotFound();
});

it('lets two stores sell a product with the same address', function (): void {
    actingInStore($this->merchant, $this->plants);

    Livewire::test(CreateProduct::class)
        ->fillForm(['name' => 'Long Jing', 'slug' => 'long-jing', 'price' => '9.00', 'stock' => 3])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Product::query()->forStore($this->plants)->where('slug', 'long-jing')->value('price'))->toBe(900);
});

it('moves an order along and restocks it when cancelled', function (): void {
    actingInStore($this->merchant, $this->plants);

    $order = Order::query()->forStore($this->plants)->inStatus(OrderStatus::Pending)->with('items.product')->firstOrFail();
    $item = $order->items->first();
    $before = $item->product->stock;

    Livewire::test(ViewOrder::class, ['record' => $order->getRouteKey()])
        ->callAction('confirmed')
        ->assertHasNoActionErrors();

    expect($order->refresh()->status)->toBe(OrderStatus::Confirmed);

    app(ChangeOrderStatus::class)->handle($order, OrderStatus::Cancelled);

    expect($item->product->refresh()->stock)->toBe($before + $item->quantity);
});
