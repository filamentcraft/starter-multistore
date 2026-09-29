<?php

declare(strict_types=1);

use App\Models\Store;
use FilamentCraft\Models\Site;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('public');

    $this->seed();
});

it('lists every live store on the platform page', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSee('Second Steep')
        ->assertSee(url('second-steep'))
        ->assertSee('Understory')
        ->assertSee(url('understory'));
});

it('serves each store at its own address', function (string $path, string $text): void {
    $this->get($path)->assertOk()->assertSee($text);
})->with([
    'tea home' => ['/second-steep', 'Tea worth a second pour.'],
    'tea shop' => ['/second-steep/shop', 'Huangshan Mao Feng'],
    'tea product' => ['/second-steep/products/long-jing', 'Flat, pan-fired leaves'],
    'tea brewing' => ['/second-steep/brewing', 'Cooler water, shorter steeps, more pots.'],
    'plant home' => ['/understory', 'Plants that suit the light you have.'],
    'plant shop' => ['/understory/shop', 'Golden pothos'],
    'plant product' => ['/understory/products/monstera', 'grown on a moss pole'],
    'plant care' => ['/understory/care', 'Most plants die from too much care.'],
]);

it('keeps each store to its own catalog', function (): void {
    $this->get('/understory/shop')->assertDontSee('Long Jing');
    $this->get('/second-steep/shop')->assertDontSee('Golden pothos');

    $this->get('/understory/products/long-jing')->assertNotFound();
    $this->get('/second-steep/products/monstera')->assertNotFound();
});

it('prices each store in its own currency', function (): void {
    $this->get('/second-steep/products/long-jing')->assertSee('£14.50');
    $this->get('/understory/products/monstera')->assertSee('€55');
});

it('links store navigation inside the store', function (): void {
    $this->get('/understory')
        ->assertSee('href="/understory/care"', escape: false)
        ->assertSee('href="/understory/cart"', escape: false);
});

it('returns 404 for an address no store owns', function (): void {
    $this->get('/no-such-store')->assertNotFound();
});

it('seeds both stores once', function (): void {
    $this->seed();

    expect(Store::query()->count())->toBe(2)
        ->and(Site::query()->count())->toBe(2);
});
