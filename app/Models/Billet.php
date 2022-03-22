<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billet extends Model
{
    use HasFactory;
    protected $primaryKey = "id_billet";
    protected $with = ["demandeur","operateur", "probleme"];

    public function demandeur() {
        return $this->hasOne(Demandeur::class, 'id_demandeur', 'id_demandeur');
    }

    public function operateur() {
        return $this->belongsTo(Operateur::class,'id_operateur');
    }

    public function probleme() {
        return $this->hasOne(Probleme::class, 'id_probleme', 'id_probleme');
    }

    public function interventions() {
        return $this->hasMany(Intervention::class, 'id_billet', 'id_billet');
    }

    public static function withoutOperateur() {
        return Billet::whereNull('id_operateur')->where('redirection','<',3)->get();
    }

    public static function findTicket($id_demandeur){
       return Billet::where('id_demandeur', $id_demandeur)->get();
    }
    public static function findCurrentTicket($id_demandeur){
        return Billet::where('id_demandeur',$id_demandeur)->where('isclose',false)->get();
    }
    public static function findClosedTicket($id_demandeur){
        return Billet::where('id_demandeur',$id_demandeur)->where('isclose',true)->get();
    }
}
