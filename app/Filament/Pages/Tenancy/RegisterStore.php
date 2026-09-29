<?php

declare(strict_types=1);

namespace App\Filament\Pages\Tenancy;

use App\Actions\OpenStore;
use App\Models\Store;
use App\Models\User;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class RegisterStore extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Open a store';
    }

    public function form(Schema $schema): Schema
    {
        return StoreForm::configure($schema, opening: true);
    }

    /**
     * @param  array{name: string, slug: string, email: string, currency: mixed}  $data
     */
    protected function handleRegistration(array $data): Store
    {
        $user = Auth::user();

        abort_unless($user instanceof User, 403);

        return app(OpenStore::class)->handle($user, $data);
    }
}
