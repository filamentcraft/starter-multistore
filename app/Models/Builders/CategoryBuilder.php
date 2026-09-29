<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Category>
 */
final class CategoryBuilder extends Builder
{
    public function forStore(Store $store): static
    {
        return $this->whereBelongsTo($store);
    }

    public function ordered(): static
    {
        return $this->orderBy('position')->orderBy('id');
    }
}
