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
        Schema::create('ubicacions', function (Blueprint $table) {
            $table->id();
            $table->string('pais', length: 255)->nullable();
            $table->string('provincia', length: 255)->nullable();
            $table->string('ciudad', length: 255)->nullable();
            $table->string('barrio', length: 255)->nullable();
            $table->string('sub_barrio', length: 255)->nullable();
            $table->string('nombre_ubicacion', length: 255)->nullable();
            $table->string('identificador_meli', length: 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicacions');
    }
};
