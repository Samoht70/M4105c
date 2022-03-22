<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Operateur extends Authenticatable
{

    public $user_type = "operateur";
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = "id_operateur";
    protected $with = ["competences"];

    protected $fillable = [
        'prenom',
        'nom',
        'id_responsable',
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

    public function competences(){
        return $this->hasManyThrough(Competence::class,Est_qualifiee::class,'id_operateur','id_competence','id_operateur','id_competence');
    }

    public function billets(){
        return $this->hasMany(Billet::class,"id_operateur","id_operateur");
    }

    public static function findByTypeProbleme($idProbleme){
        return Operateur::join("est_qualifiees",'operateurs.id_operateur','=','est_qualifiees.id_operateur')
                        ->where('est_qualifiees.id_competence',$idProbleme)->get();
    }

}
