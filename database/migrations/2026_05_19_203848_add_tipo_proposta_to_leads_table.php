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
        Schema::table('leads', function (Blueprint $table) {
            $table->string('tipo_proposta', 20)->nullable()->after('mensagem');
            $table->decimal('valor_proposta', 12, 2)->nullable()->after('tipo_proposta');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['tipo_proposta', 'valor_proposta']);
        });
    }

};
