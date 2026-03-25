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
            $table->string('agencia_agente_nombre_cache')->nullable()->after('agente_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('garantias', function (Blueprint $table) {
            $table->dropColumn('agencia_agente_nombre_cache');
        });
    }
};
