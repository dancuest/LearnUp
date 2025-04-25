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
        if (Schema::hasTable('ensena_curso_user')) {
            Schema::table('ensena_curso_user', function (Blueprint $table) {
                $table->dropForeign(['curso_id']);
                $table->dropForeign(['user_id']);
                $table->dropColumn(['curso_id', 'user_id']);
            });
            Schema::dropIfExists('ensena_curso_user');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('ensena_curso_user')) {
            Schema::create('ensena_curso_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('curso_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
            });
        }
    }
};
