<?php

namespace App\Providers;

use App\Models\SidebarModel;
use App\Services\MenuService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        
        view()->composer('layouts.navbar', function($view) {
            $roles = \Illuminate\Support\Facades\Auth::user()->roles->pluck('id')->toArray();
            
            $menus = MenuService::getMenus(0, $roles);
            
            $view->with('menus', $menus);
        });
    }
}
