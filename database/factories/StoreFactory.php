<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Currency;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Store>
 */
class StoreFactory extends Factory
{
    public function definition(): array
    {
        $name = Str::title($this->faker->unique()->words(2, true));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'email' => $this->faker->safeEmail(),
            'currency' => Currency::GBP,
            'order_prefix' => Str::upper(Str::substr(Str::slug($name, ''), 0, 3)),
        ];
    }
}
