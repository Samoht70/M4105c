<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;
    protected $primaryKey = "id_intervention";

    public function typeIntervention() {
        return $this->hasOne(TypeIntervention::class, 'id_type_intervention', 'id_type_intervention');
    }
}
