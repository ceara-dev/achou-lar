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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained()->cascadeOnDelete();
            $table->string('tipo', 50);
            $table->decimal('valor', 12, 2);
            $table->date('data');
            $table->date('inicio');
            $table->integer('prazo')->comment('duração em meses');
            $table->string('arquivo')->nullable();
            $table->timestamps();

            $table->index('imovel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
