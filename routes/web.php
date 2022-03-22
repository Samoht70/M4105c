<?php

use App\Http\Controllers\AttenteBilletController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepotbilletController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get("/", [
    LoginController::class,
    "displayLogin"
])->name("login.view");
Route::get("/deconnexion", [
    LoginController::class,
    "logOut"
])->name("login.view");


Route::get('login', [LoginController::class, "displayLogin"])->name("login.view");
Route::post('login', [LoginController::class,"login"])->name("login");

Route::middleware("auth")->group(function(){
    
    Route::get('/home', function () {
        return Inertia::render("index");
    })->name("index");
    
    Route::get("/depotbillet", [
        DepotbilletController::class,
        "depotbillet"
    ])->name("depotbillet.view");
    
    Route::get("/attentebillet", [
        AttenteBilletController::class,
        "attenteBillet"
    ])->name("billet_attente"); 
    
    Route::get("/notification", [
        NotificationController::class,
        "notification"
    ])->name("notification_attente");
    
    
    Route::get("/infosbillet/{billet}", [AttenteBilletController::class, "infosBillet"])->name("infos_billet");
    Route::post("/modifBillet/{billet}",[
        AttenteBilletController::class,
        "modificationBillet"
    ])->name("ModificationBillet");
    
    Route::post("/depotbillet",[
        DepotbilletController::class,
        "ValidationBillet"
    ])->name("ValidationBillet");

    Route::get('/effaceNotif/{notif}',[NotificationController::class,"lis_notif"])->name('effaceNotif');
});





Route::middleware("staff:operateur")->group(function(){

    Route::get('/staff/home',[StaffController::class,"display_home_staff"])->name("staffHome.view");
    Route::get('/staff/mesBillets',[StaffController::class,"display_billets_staff"])->name("billetsStaff.view");
    Route::get('/staff/mesBillets/details/{billet}',[StaffController::class,"display_info_billet_staff"])->name("infoBilletStaff.view");
    Route::get('/staff/mesBillets/tranfer/{billet}', [StaffController::class, "transferTicket"])->name("transfert");
    Route::post("/staff/changeBillet/{billet}", [StaffController::class, "changeBilletStaff"])->name("changeBilletStaff");
    Route::post('/staff/mesBillets/treatment/{billet}',[StaffController::class,"treatment_ticket"])->name("treatmentTicket");

    Route::get('staff/fermerBillet/{billet}', [StaffController::class, "close_ticket"])->name('closeTicket');


});

Route::middleware("staff:responsable")->group(function(){
    Route::get("/staff/billetsSansOperateur", [StaffController::class, "billetSansOperateur"])->name("billet_sans_operateur.view");
    //Route::get("/staff/billetsSansOperateur/details/{billet}", [StaffController::class, "display_info_billet_staff"])->name("infoBilletStaff.view");
    Route::post('/staff/billetsSansOperateur/allocate/{billet}',[StaffController::class,"allocate_ticket"])->name("allocateTicket");
    Route::get('/staff/statistiques', [StaffController::class, 'display_statistiques'])->name('stats.view');
});


