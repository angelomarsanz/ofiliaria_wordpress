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
        Schema::create('comodidads', function (Blueprint $table) {
            $table->id();
            $table->integer('id_infocasas')->nullable();
            $table->string('descripcion', length: 255)->nullable();
            $table->string('tipo_propiedad_aplica', length: 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comodidads');
    }
};
