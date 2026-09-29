<?php

declare(strict_types=1);

use App\Http\Controllers\PlatformController;
use App\Models\Store;
use Illuminate\Support\Facades\Route;

Route::get('/', PlatformController::class)->name('platform');

Route::filamentCraftTenant(Store::class, tenantPattern: Store::slugPattern());
