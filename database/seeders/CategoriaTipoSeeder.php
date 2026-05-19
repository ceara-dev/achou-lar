<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\TipoNegocio;
use Illuminate\Database\Seeder;

class CategoriaTipoSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nome' => 'Casa', 'slug' => 'casa', 'descricao' => 'Casas residenciais'],
            ['nome' => 'Apartamento', 'slug' => 'apartamento', 'descricao' => 'Apartamentos residenciais'],
            ['nome' => 'Terreno', 'slug' => 'terreno', 'descricao' => 'Terrenos e lotes'],
            ['nome' => 'Comercial', 'slug' => 'comercial', 'descricao' => 'Salas e pontos comerciais'],
            ['nome' => 'Condomínio', 'slug' => 'condominio', 'descricao' => 'Casas em condomínio'],
            ['nome' => 'Chácara/Sítio', 'slug' => 'chacara-sitio', 'descricao' => 'Chácaras e sítios'],
            ['nome' => 'Galpão', 'slug' => 'galao', 'descricao' => 'Galpões industriais'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }

        $tipos = [
            ['nome' => 'Venda', 'slug' => 'venda', 'descricao' => 'Imóveis à venda'],
            ['nome' => 'Aluguel', 'slug' => 'aluguel', 'descricao' => 'Imóveis para alugar'],
            ['nome' => 'Temporada', 'slug' => 'temporada', 'descricao' => 'Aluguel por temporada'],
        ];

        foreach ($tipos as $tipo) {
            TipoNegocio::create($tipo);
        }
    }
}
