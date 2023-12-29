<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'Item' => Item::class,
            'Category' => Category::class,
            'Menu' => Menu::class
        ]);
    }
}
