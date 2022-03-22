<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function displayLogin(Request $request){
        return Inertia::render("login");
    }


    public function login(Request $request) {
        

        $credentials = $request->validate([  
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);
        
        if(Auth::guard('web')->attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/home');
        }

        if(Auth::guard('operateur')->attempt($credentials) || Auth::guard('responsable')->attempt($credentials)){
            $request->session()->regenerate();
            
            return redirect()->intended('/staff/home');
        }

        return back()->withErrors([
            "email" => "Compte et/ou mot de passe incorrect"
        ]);
    
    }

    public function logOut(Request $request) {
        $guards = array_keys(config('auth.guards'));
        $guards= array_filter($guards, function($e){ return $e!="sanctum";});
        foreach($guards as $guard){
            if(Auth::guard($guard)->check())
            {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
