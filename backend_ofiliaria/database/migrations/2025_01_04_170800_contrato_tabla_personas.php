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
        Schema::table('personas', function (Blueprint $table) {
            $table->string('tipo_documento_identidad', length: 255)->after('tipo_persona')->nullable();
            $table->string('domicilio_persona', length: 255)->after('contador_cert_uni')->nullable();
            $table->string('departamento_domicilio', length: 255)->after('domicilio_persona')->nullable();
            $table->string('ciudad_domicilio', length: 255)->after('departamento_domicilio')->nullable();
            $table->string('clasificacion_persona_fisica', length: 255)->after('ciudad_domicilio')->nullable();
            $table->string('clasificacion_persona_juridica', length: 255)->after('clasificacion_persona_fisica')->nullable();
            $table->string('notas_persona', length: 255)->after('clasificacion_persona_juridica')->nullable();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn('tipo_documento_identidad');
            $table->dropColumn('domicilio_persona');
            $table->dropColumn('departamento_domicilio');
            $table->dropColumn('ciudad_domicilio');
            $table->dropColumn('clasificacion_persona_fisica');
            $table->dropColumn('clasificacion_persona_juridica');
            $table->dropColumn('notas_persona');
        });
    }
};
