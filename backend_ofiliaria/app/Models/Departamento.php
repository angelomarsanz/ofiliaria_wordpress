<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        "id_departamento_infocasas",
        "departamento",
    ];

    public function zonas()
    {
        return $this->hasMany(Zona::class);
    }

}
