<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('imovels', function (Blueprint $table) {
            $table->decimal('valor_condominio', 10, 2)->nullable()->after('preco');
            $table->decimal('iptu', 10, 2)->nullable()->after('valor_condominio');
            $table->boolean('inclui_agua')->default(false)->after('iptu');
            $table->boolean('inclui_energia')->default(false)->after('inclui_agua');
            $table->boolean('inclui_internet')->default(false)->after('inclui_energia');
            $table->text('regras')->nullable()->after('descricao');
        });
    }

    public function down(): void
    {
        Schema::table('imovels', function (Blueprint $table) {
            $table->dropColumn([
                'valor_condominio',
                'iptu',
                'inclui_agua',
                'inclui_energia',
                'inclui_internet',
                'regras',
            ]);
        });
    }
};
