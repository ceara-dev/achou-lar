<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained()->cascadeOnDelete();
            $table->string('caminho');
            $table->integer('ordem')->default(0);
            $table->boolean('is_capa')->default(false);
            $table->timestamps();

            $table->index(['imovel_id', 'ordem']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fotos');
    }
};
