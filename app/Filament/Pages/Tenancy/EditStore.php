<?php

declare(strict_types=1);

namespace App\Filament\Pages\Tenancy;

use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Schema;

class EditStore extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Store settings';
    }

    public function form(Schema $schema): Schema
    {
        return StoreForm::configure($schema, opening: false);
    }
}
