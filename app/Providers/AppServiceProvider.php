<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;


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
        Schema::defaultStringLength(191);
        // ...
        Gate::define('index home', function ($user) {
            // contoh kondisi izin
            // return $user->isAdmin();$user = User::find(1);
            $user->givePermissionTo('index home');
            Config::set('constants', require app_path() . '/config/constants.php');
        });
    }
}
