<?php

namespace App\Providers;

use App\Models\SidebarModel;
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
            
            $sidebar_model = new SidebarModel();
            $menus = $sidebar_model->getMenu();
            
            $view
                ->with('stmtMenu', $menus['stmtMenu'])
                ->with('stmtSubMenu', $menus['stmtSubMenu'])
            ;
        });
    }
}
