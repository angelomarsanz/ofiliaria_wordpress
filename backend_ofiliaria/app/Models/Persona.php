<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'garantia_id',
        'tipo_arrendatario',
        'tipo_persona', 
        'tipo_documento_identidad',
        'numero_identidad_arrendatario',
        'nombres_arrendatario', 
        'apellidos_arrendatario', 
        'numero_identidad_empresa',
        'empresa',
        'cargo_empresa',
        'email_arrendatario', 
        'telefono_arrendatario', 
        'moneda_ingreso',
        'monto_ingreso', 
        'ingreso', 
        'sueldo', 

        'identidad',
        'etiqueta_identidad',
        'ubicacion_identidad',
        'contador_identidad',
        
        'rec_sueldo',
        'etiqueta_rec_sueldo',
        'ubicaciones_rec_sueldo',
        'contador_rec_sueldo',
        
        'cert_ing_mod',
        'etiqueta_cert_ing_mod',
        'ubicaciones_cert_ing_mod',
        'contador_cert_ing_mod',

        'dgi',
        'etiqueta_dgi',
        'ubicaciones_dgi',
        'contador_dgi',

        'cert_dgi_caja',
        'etiqueta_cert_dgi_caja',
        'ubicaciones_cert_dgi_caja',
        'contador_cert_dgi_caja',

        'balance',
        'etiqueta_balance',
        'ubicaciones_balance',
        'contador_balance',

        'rut',
        'etiqueta_rut',
        'ubicaciones_rut',
        'contador_rut',

        'contrato_social',
        'etiqueta_contrato_social',
        'ubicaciones_contrato_social',
        'contador_contrato_social',

        'cert_uni',
        'etiqueta_cert_uni',
        'ubicaciones_cert_uni',
        'contador_cert_uni',

        'domicilio_persona',
        'departamento_domicilio',
        'ciudad_domicilio',
        'clasificacion_persona_fisica',
        'clasificacion_persona_juridica',
        'notas_persona',

        'estatus_registro'
    ];

    public function garantia()
    {
        return $this->belongsTo(Garantia::class);
    }
}
