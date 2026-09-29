<?php

declare(strict_types=1);

namespace App\Blueprints\Pages;

use App\Blueprints\Concerns\BuildsSections;
use App\Blueprints\StoreBlueprint;
use FilamentCraft\Blueprints\AbstractBlueprint;

abstract class Page extends AbstractBlueprint
{
    use BuildsSections;

    public function __construct(protected StoreBlueprint $site) {}

    abstract public function description(): string;

    protected function storefront(): StoreBlueprint
    {
        return $this->site;
    }
}
