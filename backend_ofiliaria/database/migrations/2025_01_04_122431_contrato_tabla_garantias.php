<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('garantias', function (Blueprint $table) {
            $table->string('tipo_contrato', length: 255)->after('costo_alquiler')->nullable();
            $table->string('fecha_inicio_alquiler', length: 255)->after('tipo_contrato')->nullable();
            $table->string('plazo_alquiler', length: 255)->after('fecha_inicio_alquiler')->nullable();
            $table->string('tipo_plazo_alquiler', length: 255)->after('plazo_alquiler')->nullable();
            $table->string('tipo_pago_alquiler', length: 255)->after('tipo_plazo_alquiler')->nullable();
            $table->string('regimen_ajuste_alquiler', length: 255)->after('tipo_pago_alquiler')->nullable();
            $table->string('departamento_firma', length: 255)->after('regimen_ajuste_alquiler')->nullable();
            $table->string('ciudad_firma', length: 255)->after('departamento_firma')->nullable();
            $table->string('terminos_condiciones', length: 255)->after('ciudad_firma')->nullable();
            $table->string('banco', length: 255)->after('terminos_condiciones')->nullable();
            $table->string('numero_sucursal_banco', length: 255)->after('banco')->nullable();
            $table->string('nombres_titular_cuenta', length: 255)->after('numero_sucursal_banco')->nullable();
            $table->string('apellidos_titular_cuenta', length: 255)->after('nombres_titular_cuenta')->nullable();
            $table->string('moneda', length: 255)->after('apellidos_titular_cuenta')->nullable();
            $table->string('numero_cuenta', length: 255)->after('moneda')->nullable();
            $table->string('tipo_cuenta', length: 255)->after('numero_cuenta')->nullable();
            $table->text('texto_contrato')->after('tipo_cuenta')->nullable();
            $table->string('tipo_inventario', length: 255)->after('texto_contrato')->nullable();
            $table->string('descripcion_inventario', length: 255)->after('tipo_inventario')->nullable();
            $table->string('observaciones_inventario', length: 255)->after('descripcion_inventario')->nullable();
            $table->string('archivos_inventario', length: 255)->after('observaciones_inventario')->nullable();
            $table->string('etiqueta_inventario', length: 255)->after('archivos_inventario')->nullable();
            $table->text('ubicaciones_inventario')->after('etiqueta_inventario')->nullable();
            $table->integer('contador_inventario')->after('ubicaciones_inventario')->nullable();

            $table->string('contrato', length: 255)->after('contador_inventario')->nullable();
            $table->text('ubicaciones_contrato')->after('contrato')->nullable();
            $table->string('foto_inventario', length: 255)->after('ubicaciones_contrato')->nullable();
            $table->text('ubicaciones_foto_inventario')->after('foto_inventario')->nullable();
            $table->string('contrato_firmado', length: 255)->after('ubicaciones_foto_inventario')->nullable();
            $table->string('etiqueta_contrato_firmado', length: 255)->after('contrato_firmado')->nullable();
            $table->text('ubicaciones_contrato_firmado')->after('etiqueta_contrato_firmado')->nullable();
            $table->integer('contador_contrato_firmado')->after('ubicaciones_contrato_firmado')->nullable();
            $table->string('inventario_firmado', length: 255)->after('contador_contrato_firmado')->nullable();
            $table->string('etiqueta_inventario_firmado', length: 255)->after('inventario_firmado')->nullable();
            $table->text('ubicaciones_inventario_firmado')->after('etiqueta_inventario_firmado')->nullable();
            $table->integer('contador_inventario_firmado')->after('ubicaciones_inventario_firmado')->nullable();
            $table->string('formulario_firmado', length: 255)->after('contador_inventario_firmado')->nullable();
            $table->string('etiqueta_formulario_firmado', length: 255)->after('formulario_firmado')->nullable();
            $table->text('ubicaciones_formulario_firmado')->after('etiqueta_formulario_firmado')->nullable();
            $table->integer('contador_formulario_firmado')->after('ubicaciones_formulario_firmado')->nullable();
            $table->string('comprobante_pago', length: 255)->after('contador_formulario_firmado')->nullable();
            $table->string('etiqueta_comprobante_pago', length: 255)->after('comprobante_pago')->nullable();
            $table->text('ubicaciones_comprobante_pago')->after('etiqueta_comprobante_pago')->nullable();
            $table->integer('contador_comprobante_pago')->after('ubicaciones_comprobante_pago')->nullable();

            $table->string('notas_garantia', length: 255)->after('contador_comprobante_pago')->nullable();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('garantias', function (Blueprint $table) {
            
            $table->dropColumn('tipo_contrato');
            $table->dropColumn('fecha_inicio_alquiler');
            $table->dropColumn('plazo_alquiler');
            $table->dropColumn('tipo_plazo_alquiler');
            $table->dropColumn('tipo_pago_alquiler');
            $table->dropColumn('regimen_ajuste_alquiler');
            $table->dropColumn('departamento_firma');
            $table->dropColumn('ciudad_firma');
            $table->dropColumn('terminos_condiciones');
            $table->dropColumn('banco');
            $table->dropColumn('numero_sucursal_banco');
            $table->dropColumn('nombres_titular_cuenta');
            $table->dropColumn('apellidos_titular_cuenta');
            $table->dropColumn('moneda');
            $table->dropColumn('numero_cuenta');
            $table->dropColumn('tipo_cuenta');
            $table->dropColumn('texto_contrato');
            $table->dropColumn('tipo_inventario');
            $table->dropColumn('descripcion_inventario');
            $table->dropColumn('observaciones_inventario');
            $table->dropColumn('archivos_inventario');
            $table->dropColumn('etiqueta_inventario');
            $table->dropColumn('ubicaciones_inventario');
            $table->dropColumn('contador_inventario');
            
            $table->dropColumn('contrato');
            $table->dropColumn('ubicaciones_contrato');
            
            $table->dropColumn('foto_inventario');
            $table->dropColumn('ubicaciones_foto_inventario');
            
            $table->dropColumn('contrato_firmado');
            $table->dropColumn('etiqueta_contrato_firmado');
            $table->dropColumn('ubicaciones_contrato_firmado');
            $table->dropColumn('contador_contrato_firmado');
            
            $table->dropColumn('inventario_firmado');
            $table->dropColumn('etiqueta_inventario_firmado');
            $table->dropColumn('ubicaciones_inventario_firmado');
            $table->dropColumn('contador_inventario_firmado');
            
            $table->dropColumn('formulario_firmado');
            $table->dropColumn('etiqueta_formulario_firmado');
            $table->dropColumn('ubicaciones_formulario_firmado');
            $table->dropColumn('contador_formulario_firmado');
            
            $table->dropColumn('comprobante_pago');
            $table->dropColumn('etiqueta_comprobante_pago');
            $table->dropColumn('ubicaciones_comprobante_pago');
            $table->dropColumn('contador_comprobante_pago');
            
            $table->dropColumn('notas_garantia');
        });
    }
};
