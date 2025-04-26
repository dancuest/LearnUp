<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('formularios')) {
            Schema::table('formularios', function (Blueprint $table) {
                if (!Schema::hasColumn('formularios', 'evento_id')) {
                    $table->foreignId('evento_id')->nullable()->constrained('eventos_calendario')->nullOnDelete();
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('formularios')) {
            Schema::table('formularios', function (Blueprint $table) {
                if (Schema::hasColumn('formularios', 'evento_id')) {
                    $table->dropConstrainedForeignId('evento_id');
                }
            });
        }
    }
};
