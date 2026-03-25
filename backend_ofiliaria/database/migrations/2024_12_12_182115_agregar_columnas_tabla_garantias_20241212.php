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
            $table->string('estatus_garantia_adicional', length: 255)->after('estatus_garantia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('garantias', function (Blueprint $table) {
            $table->dropColumn('estatus_garantia_adicional');
        });
    }
};
