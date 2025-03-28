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
        // Crear primero las tablas sin dependencias
        Schema::create('instituciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo', ['privado', 'publico']);
            $table->integer('capacidad');
            $table->string('imagen_perfil');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->float('costo');
            $table->integer('cantidad_alumnos');
            $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('entregables', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_asignacion');
            $table->dateTime('fecha_limite_entrega');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('formularios', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_asignacion');
            $table->dateTime('fecha_limite_entrega');
            $table->integer('intentos_posibles');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->float('nota');
            $table->dateTime('fecha_entrega');
            $table->boolean('estado_calificacion');
            $table->foreignId('user_envia_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_califica_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('intentos', function (Blueprint $table) {
            $table->id();
            $table->float('nota');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('formulario_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->longText('descripcion');
            $table->foreignId('formulario_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('opciones', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->foreignId('pregunta_id')->constrained()->onDelete('cascade'); // Corregido
            $table->timestamps();
        });

        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->longText('descripcion');
            $table->boolean('esCorrecto');
            $table->foreignId('pregunta_id')->constrained()->onDelete('cascade');
            $table->foreignId('opcion_id')->constrained('opciones')->onDelete('cascade');
            $table->foreignId('intento_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->float('monto');
            $table->dateTime('fecha');
            $table->string('metodo');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('institucion_id')->nullable()->constrained('instituciones')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('accede_institucion_user', function (Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('ensena_curso_user', function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('estudia_curso_user', function (Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
        Schema::dropIfExists('opciones');
        Schema::dropIfExists('preguntas');
        Schema::dropIfExists('intentos');
        Schema::dropIfExists('formularios');
        Schema::dropIfExists('entregas');
        Schema::dropIfExists('entregables');
        Schema::dropIfExists('pagos');
        Schema::dropIfExists('cursos');
        Schema::dropIfExists('instituciones');
        Schema::dropIfExists('assets');
        Schema::dropIfExists('accede_institucion_user');
        Schema::dropIfExists('ensena_institucion_user');
        Schema::dropIfExists('estudia_curso_user');
    }
};
