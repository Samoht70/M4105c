<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Demandeur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = "id_demandeur";
    protected $with = ["notifications"];

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword() {
        return $this->password;
    }

    public function billets() {
        return $this->hasMany(Billet::class, 'id_billet', 'id_billet');
    }

    public function getDemandeurName($id){
        return Demandeur::find($id)->nom." ".Demandeur::find($id)->prenom;
    }

    public function notifications(){
        return $this->hasmany(Notif::class,'id_demandeur','id_demandeur')->orderBy('created_at');
    }
}
