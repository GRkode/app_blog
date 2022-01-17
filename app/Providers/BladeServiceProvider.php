<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('subscribed', function($user){
           return $user->subscribed('mensuel') || $user->subscribed('unique');
        });

        Blade::if('nosubscribed', function($user){
           return !($user->subscribed('mensuel') || $user->subscribed('unique'));
        });

        Blade::if('subscribeToProduct', function($user, $id, $name){
           return $user->subscribeToProduct($id, $name);
        });
    }
}
