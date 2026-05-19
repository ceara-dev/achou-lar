<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imovels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('tipo_negocio_id')->constrained('tipo_negocios');
            $table->string('titulo');
            $table->text('descricao');
            $table->decimal('preco', 12, 2);
            $table->decimal('area', 10, 2)->nullable();
            $table->integer('quartos')->nullable();
            $table->integer('banheiros')->nullable();
            $table->integer('vagas')->nullable();
            $table->string('endereco');
            $table->string('bairro')->nullable();
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('cep', 9)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('destaque')->default(false);
            $table->boolean('aprovado')->default(false);
            $table->enum('status', ['active', 'sold', 'rented', 'inactive'])->default('active');
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['cidade', 'estado', 'status']);
            $table->index(['preco']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imovels');
    }
};
