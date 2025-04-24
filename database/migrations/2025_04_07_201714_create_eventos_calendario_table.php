<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('eventos_calendario')) {
            Schema::create('eventos_calendario', function (Blueprint $table) {
                $table->id();
                $table->string('titulo');
                $table->text('descripcion')->nullable();
                $table->dateTime('inicio');
                $table->dateTime('fin');
                $table->enum('tipo', ['clase', 'entrega', 'formulario']);
                $table->foreignId('tipo_evento_id')->nullable()->constrained('tipos_evento')->nullOnDelete();
                $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
                $table->foreignId('creado_por')->constrained('users')->cascadeOnDelete();
                $table->foreignId('entregable_id')->nullable()->constrained('entregables')->nullOnDelete();
                $table->foreignId('formulario_id')->nullable()->constrained('formularios')->nullOnDelete();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('eventos_calendario');
    }
};
