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
            $table->integer('cozinhas')->nullable()->after('banheiros');
            $table->string('tipo_residencia', 20)->nullable()->after('vagas');
        });
    }

    public function down(): void
    {
        Schema::table('imovels', function (Blueprint $table) {
            $table->dropColumn(['cozinhas', 'tipo_residencia']);
        });
    }
};
