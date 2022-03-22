<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Probleme extends Model
{
    use HasFactory;
    protected $primaryKey = "id_probleme";

    public function billet() {
        return $this->hasMany(Billet::class, 'id_probleme', 'id_probleme');
    }
}
