<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('institucion_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institucion_id')->constrained('instituciones')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('planes')->cascadeOnDelete();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['activo', 'cancelado', 'pendiente_pago']);
            $table->boolean('renovacion_automatica')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('institucion_plan', function (Blueprint $table) {
            $table->dropForeign(['institucion_id']);
            $table->dropForeign(['plan_id']);
        });

        Schema::dropIfExists('institucion_plan');
    }
};
