<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOperateur
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$permission)
    {
        $permissions = array("web"=>5,"operateur"=>10,"responsable"=>20);

        $guards = array_keys(config('auth.guards'));
        $guards= array_filter($guards, function($e){ return $e!="sanctum";});
        foreach($guards as $guard){
            if(Auth::guard($guard)->check() && $permissions[$guard] >= $permissions[$permission])
            {
                return $next($request);
            }
        }
        return back()->withErrors(["status"=>"Vous n'avez pas la permission d'accéder à cette page !"]);
    }
}
