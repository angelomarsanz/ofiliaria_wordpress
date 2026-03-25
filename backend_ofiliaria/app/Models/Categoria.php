<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nivel_1',
        'nivel_2',
        'nivel_3',
        'nivel_4',
        'nivel_5',
        'nombre_categoria',
        'identificador_meli',
        'atributos',
        'atributos_especificos'
    ];

    public function categoria()
    {
        return;
    }
}
