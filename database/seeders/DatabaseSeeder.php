<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Stores\SecondSteepSeeder;
use Database\Seeders\Stores\UnderstorySeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('filamentcraft:sync-themes');

        $owner = User::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Rafael Costa', 'password' => 'password'],
        );

        $this->call([SecondSteepSeeder::class, UnderstorySeeder::class], parameters: ['owner' => $owner]);
    }
}
