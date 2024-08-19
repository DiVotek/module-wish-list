<?php

namespace Modules\Wishlist\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class WishlistServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Wishlist';

    public function boot(): void
    {
        $this->loadMigrations();
    }

    public function register(): void
    {
    }

    private function loadMigrations(): void
    {
            $this->loadMigrationsFrom(module_path($this->moduleName, 'Migrations'));
    }
}
