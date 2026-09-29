<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Store;
use Filament\Facades\Filament;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('starter:ready')]
#[Description('Print where the platform, its stores and the merchant panel live after setup')]
class StarterReadyCommand extends Command
{
    public function handle(): int
    {
        $url = rtrim((string) config('app.url'), '/');

        $this->newLine();
        $this->components->info('Stallhouse is ready.');
        $this->components->twoColumnDetail('Platform', $url);

        Store::query()->orderBy('name')->each(
            fn (Store $store) => $this->components->twoColumnDetail($store->name, "{$url}/{$store->slug}"),
        );

        $this->components->twoColumnDetail('Merchant panel', $url.'/'.Filament::getDefaultPanel()->getPath());
        $this->components->twoColumnDetail('Sign in', 'admin@example.com / password');
        $this->components->twoColumnDetail('Start the server', 'composer dev');
        $this->newLine();

        return self::SUCCESS;
    }
}
