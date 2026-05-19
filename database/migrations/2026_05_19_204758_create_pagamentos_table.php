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
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained()->cascadeOnDelete();
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->decimal('valor', 10, 2);
            $table->boolean('atrasado')->default(false);
            $table->decimal('agua', 10, 2)->nullable();
            $table->decimal('energia', 10, 2)->nullable();
            $table->decimal('internet', 10, 2)->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();

            $table->index('contrato_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
