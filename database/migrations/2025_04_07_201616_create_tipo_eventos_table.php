<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipos_evento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('color');
            $table->string('icono');
            $table->timestamps();
        });

        // Datos iniciales
        DB::table('tipos_evento')->insert([
            ['nombre' => 'Clase', 'color' => '#3b82f6', 'icono' => 'fa-chalkboard'],
            ['nombre' => 'Entrega', 'color' => '#10b981', 'icono' => 'fa-file-upload'],
            ['nombre' => 'Examen', 'color' => '#ef4444', 'icono' => 'fa-file-alt'],
            ['nombre' => 'Recordatorio', 'color' => '#f59e0b', 'icono' => 'fa-bell']
        ]);
    }

    public function down()
    {
        if (Schema::hasTable('eventos_calendario')) {
            Schema::table('eventos_calendario', function (Blueprint $table) {
                $table->dropForeign(['tipo_evento_id']);
            });
        }

        Schema::dropIfExists('tipos_evento');
    }
};
