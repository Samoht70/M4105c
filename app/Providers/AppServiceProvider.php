<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;

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
        Inertia::share('connectedUser', function () {

            $connectedUser = null;
            $guards = array_keys(config('auth.guards'));
            $guards= array_filter($guards, function($e){ return $e!="sanctum";});
            foreach($guards as $guard){
                if(Auth::guard($guard)->check())
                {
                    $connectedUser = $guard;
                    
                }
            }

            return $connectedUser;

        });
    }
}
