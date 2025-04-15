<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('entregables', function (Blueprint $table) {
            $table->foreignId('evento_id')->nullable()->constrained('eventos_calendario')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('entregables', function (Blueprint $table) {
            $table->dropConstrainedForeignId('evento_id');
        });
    }
};
