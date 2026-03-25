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
        Schema::create('garantias', function (Blueprint $table) {
            $table->id();
            $table->integer('agencia_id')->nullable();
            $table->integer('agente_id')->nullable();
            $table->string('aseguradora', length: 255)->nullable();
            $table->integer('propiedad_id')->nullable();
            $table->string('numero_identidad_propiedad', length: 255)->nullable();
            $table->string('nombre_propiedad', length: 255)->nullable();
            $table->string('direccion_propiedad', length: 255)->nullable();
            $table->string('tipo_propiedad', length: 255)->nullable();
            $table->decimal('tasa_cambio', total: 16, places: 2)->nullable();
            $table->string('moneda_propiedad', length: 255)->nullable();
            $table->decimal('costo_alquiler', total: 16, places: 2)->nullable();
            $table->string('estatus_garantia', length: 255)->nullable();
            $table->string('estatus_registro', length: 255)->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garantias');
    }
};
