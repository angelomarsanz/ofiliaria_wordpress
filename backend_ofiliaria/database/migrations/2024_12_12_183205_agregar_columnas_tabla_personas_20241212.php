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
            $table->string('etiqueta_identidad', length: 255)->after('identidad')->nullable();
            $table->string('etiqueta_rec_sueldo', length: 255)->after('rec_sueldo')->nullable();
            $table->string('etiqueta_cert_ing_mod', length: 255)->after('cert_ing_mod')->nullable();
            $table->string('etiqueta_dgi', length: 255)->after('dgi')->nullable();
            $table->string('etiqueta_cert_dgi_caja', length: 255)->after('cert_dgi_caja')->nullable();
            $table->string('etiqueta_balance', length: 255)->after('balance')->nullable();
            $table->string('etiqueta_rut', length: 255)->after('rut')->nullable();
            $table->string('etiqueta_contrato_social', length: 255)->after('contrato_social')->nullable();
            $table->string('etiqueta_cert_uni', length: 255)->after('cert_uni')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn('etiqueta_identidad');
            $table->dropColumn('etiqueta_rec_sueldo');
            $table->dropColumn('etiqueta_cert_ing_mod');
            $table->dropColumn('etiqueta_dgi');
            $table->dropColumn('etiqueta_cert_dgi_caja');
            $table->dropColumn('etiqueta_balance');
            $table->dropColumn('etiqueta_rut');
            $table->dropColumn('etiqueta_contrato_social');
            $table->dropColumn('etiqueta_cert_uni');
        });
    }
};
