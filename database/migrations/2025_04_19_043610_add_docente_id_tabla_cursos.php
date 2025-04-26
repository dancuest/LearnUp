<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->foreignId('docente_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->after('institucion_id');
        });
    }

    public function down()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('docente_id');
        });
    }
};
