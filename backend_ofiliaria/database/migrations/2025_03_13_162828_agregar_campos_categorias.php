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
        Schema::table('categorias', function (Blueprint $table) {
            $table->text('atributos_requeridos')->after('identificador_meli')->nullable();
            $table->text('atributos_especificos_requeridos')->after('atributos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropColumn('atributos_requeridos');
            $table->dropColumn('atributos_especificos_requeridos');
        });
    }
};
