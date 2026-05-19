<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nome');
            $table->string('email');
            $table->string('telefone', 20);
            $table->text('mensagem')->nullable();
            $table->boolean('lido')->default(false);
            $table->timestamps();

            $table->index(['imovel_id', 'lido']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
