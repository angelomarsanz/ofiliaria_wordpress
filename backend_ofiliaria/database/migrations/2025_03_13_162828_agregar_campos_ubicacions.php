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
        Schema::table('ubicacions', function (Blueprint $table) {
            $table->integer('id_departamento_infocasas')->after('identificador_meli')->nullable();
            $table->integer('id_zona_infocasas')->after('id_departamento_infocasas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ubicacions', function (Blueprint $table) {
            $table->dropColumn('id_departamento_infocasas');
            $table->dropColumn('id_zona_infocasas');
        });
    }
};
