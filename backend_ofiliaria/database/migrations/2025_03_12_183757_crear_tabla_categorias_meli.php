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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nivel_1', length: 255)->nullable();
            $table->string('nivel_2', length: 255)->nullable();
            $table->string('nivel_3', length: 255)->nullable();
            $table->string('nivel_4', length: 255)->nullable();
            $table->string('nivel_5', length: 255)->nullable();
            $table->string('nombre_categoria', length: 255)->nullable();
            $table->string('identificador_meli', length: 255)->nullable();
            $table->text('atributos')->nullable();
            $table->text('atributos_especificos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
