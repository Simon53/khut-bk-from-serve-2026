<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // ✅ Import View
use App\Models\SiteMenu;             // ✅ Import SiteMenu model
use App\Models\MainMenu;

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
    View::composer('*', function ($view) {
        // Footer menus
        $view->with('footerMenus', SiteMenu::where('status', 1)->get());

        // Main menus (category list)
        $view->with('mainMenus', \App\Models\MainMenu::with('subMenus.childMenus')->get());
         $view->with('mainMenus', MainMenu::all());
    });
}
}



