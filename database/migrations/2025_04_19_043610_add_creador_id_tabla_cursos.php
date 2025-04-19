<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->foreignId('creador_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropForeign(['creador_id']);
            $table->dropColumn('creador_id');
        });
    }
};
