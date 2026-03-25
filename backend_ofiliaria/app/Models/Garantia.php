<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    use HasFactory;

    protected $fillable = [
        'agencia_id',
        'agente_id',
        'aseguradora',
        'propiedad_id',
        'numero_identidad_propiedad',
        'nombre_propiedad',
        'direccion_propiedad',
        'tipo_propiedad', 
        'tasa_cambio',
        'moneda_propiedad', 
        'costo_alquiler', 
        'tipo_contrato',
        'fecha_inicio_alquiler',
        'plazo_alquiler',
        'tipo_plazo_alquiler',
        'tipo_pago_alquiler',
        'regimen_ajuste_alquiler',
        'departamento_firma',
        'ciudad_firma',
        'terminos_condiciones',
        'banco',
        'numero_sucursal_banco',
        'nombres_titular_cuenta',
        'apellidos_titular_cuenta',
        'moneda',
        'numero_cuenta',
        'tipo_cuenta',
        'texto_contrato',
        'notas_garantia',
        'tipo_inventario',
        'descripcion_inventario',
        'observaciones_inventario',
        'archivos_inventario', 
        'etiqueta_inventario', 
        'ubicaciones_inventario', 
        'contador_inventario',
        
        'contrato',
        'ubicaciones_contrato',
        
        'foto_inventario',
        'ubicaciones_foto_inventario',
        
        'contrato_firmado',
        'etiqueta_contrato_firmado',
        'ubicaciones_contrato_firmado',
        'contador_contrato_firmado',
        
        'inventario_firmado',
        'etiqueta_inventario_firmado',
        'ubicaciones_inventario_firmado',
        'contador_inventario_firmado',
        
        'formulario_firmado',
        'etiqueta_formulario_firmado',
        'ubicaciones_formulario_firmado',
        'contador_formulario_firmado',
        
        'comprobante_pago',
        'etiqueta_comprobante_pago',
        'ubicaciones_comprobante_pago',
        'contador_comprobante_pago',

        'estatus_garantia',
        'estatus_garantia_adicional',
        'estatus_registro'
    ];

    public function personas()
    {
        return $this->hasMany(Persona::class);
    }
}
