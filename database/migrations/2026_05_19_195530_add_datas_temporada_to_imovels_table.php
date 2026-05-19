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
        Schema::table('imovels', function (Blueprint $table) {
            $table->date('data_inicio')->nullable()->after('longitude');
            $table->date('data_fim')->nullable()->after('data_inicio');
        });
    }

    public function down(): void
    {
        Schema::table('imovels', function (Blueprint $table) {
            $table->dropColumn(['data_inicio', 'data_fim']);
        });
    }
};
