<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Models\Notif;

class NotificationController extends Controller
{
    function notification(){
        if(Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
        }
        $tailleTableau = count($user->notifications);
        return Inertia::render('notification_attente',["user"=>$user,"tailleTableau"=>$tailleTableau]);
    }

    function lis_notif(Notif $notif){
        $notif->is_read = true;
        $notif->save();
        return back();
    }


    
}
