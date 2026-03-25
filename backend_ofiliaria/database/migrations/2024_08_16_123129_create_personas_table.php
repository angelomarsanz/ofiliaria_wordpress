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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('garantia_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('tipo_arrendatario', length: 255)->nullable();
            $table->string('tipo_persona', length: 255)->nullable();
            $table->string('numero_identidad_arrendatario', length: 255)->nullable();
            $table->string('nombres_arrendatario', length: 255)->nullable();
            $table->string('apellidos_arrendatario', length: 255)->nullable();
            $table->string('numero_identidad_empresa', length: 255)->nullable();
            $table->string('empresa', length: 255)->nullable();
            $table->string('cargo_empresa', length: 255)->nullable();
            $table->string('email_arrendatario', length: 255)->nullable();
            $table->string('telefono_arrendatario', length: 255)->nullable();
            $table->string('moneda_ingreso', length: 255)->nullable();
            $table->decimal('monto_ingreso', total: 16, places: 2)->nullable();
            $table->string('ingreso', length: 255)->nullable();
            $table->string('sueldo', length: 255)->nullable();

            $table->text('identidad')->nullable();
            $table->text('ubicacion_identidad')->nullable();
            
            $table->text('rec_sueldo')->nullable();
            $table->text('ubicaciones_rec_sueldo')->nullable();
            $table->integer('contador_rec_sueldo')->nullable();
            
            $table->text('cert_ing_mod')->nullable();
            $table->text('ubicaciones_cert_ing_mod')->nullable();
            $table->integer('contador_cert_ing_mod')->nullable();
            
            $table->text('dgi')->nullable();
            $table->text('ubicaciones_dgi')->nullable();
            $table->integer('contador_dgi')->nullable();
            
            $table->text('cert_dgi_caja')->nullable();
            $table->text('ubicaciones_cert_dgi_caja')->nullable();
            $table->integer('contador_cert_dgi_caja')->nullable();
            
            $table->text('balance')->nullable();
            $table->text('ubicaciones_balance')->nullable();
            $table->integer('contador_balance')->nullable();
            
            $table->text('rut')->nullable();
            $table->text('ubicaciones_rut')->nullable();
            $table->integer('contador_rut')->nullable();
            
            $table->text('contrato_social')->nullable();
            $table->text('ubicaciones_contrato_social')->nullable();
            $table->integer('contador_contrato_social')->nullable();

            $table->text('cert_uni')->nullable();
            $table->text('ubicaciones_cert_uni')->nullable();
            $table->integer('contador_cert_uni')->nullable();

            $table->string('estatus_registro', length: 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
