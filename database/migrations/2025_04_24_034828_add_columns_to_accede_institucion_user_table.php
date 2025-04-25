<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('accede_institucion_user', function (Blueprint $table) {
            $table->string('rol')->nullable()->comment('Rol del usuario en la institución');
            $table->string('estado')->default('activo')->comment('Estado del acceso (activo/inactivo)');
            $table->string('estado_pago')->nullable()->comment('Estado del pago (pendiente/completado/rechazado)');
            $table->date('fecha_pago')->nullable()->comment('Fecha del último pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('accede_institucion_user', function (Blueprint $table) {
            $table->dropColumn(['rol', 'estado', 'estado_pago', 'fecha_pago']);
        });
    }
};
