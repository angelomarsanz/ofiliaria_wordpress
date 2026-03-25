<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'pais',
        'provincia',
        'ciudad',
        'barrio',
        'sub_barrio',
        'nombre_ubicacion',
        'identificador_meli',
        'id_departamento_infocasas',
        'id_zona_infocasas'
    ];

    public function Ubicacion()
    {
        return;
    }
}
