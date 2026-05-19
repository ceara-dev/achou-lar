<?php

namespace Database\Factories;

use App\Models\Imovel;
use App\Models\User;
use App\Models\Categoria;
use App\Models\TipoNegocio;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImovelFactory extends Factory
{
    protected $model = Imovel::class;

    public function definition(): array
    {
        $cidades = [
            'Teresina' => 'PI',
            'Parnaíba' => 'PI',
            'Picos' => 'PI',
            'Floriano' => 'PI',
            'Campo Maior' => 'PI',
        ];

        $cidade = $this->faker->randomElement(array_keys($cidades));
        $estado = $cidades[$cidade];

        $bairros = [
            'Centro', 'Jóquei', 'Fátima', 'Ilhotas', 'Horto',
            'Mocambinho', 'Dirceu', 'Socopo', 'Vermelha', 'Noivos',
        ];

        return [
            'user_id' => User::factory(),
            'categoria_id' => Categoria::inRandomOrder()->first()?->id ?? 1,
            'tipo_negocio_id' => TipoNegocio::inRandomOrder()->first()?->id ?? 1,
            'titulo' => $this->faker->sentence(4),
            'descricao' => $this->faker->paragraphs(3, true),
            'preco' => $this->faker->randomFloat(2, 50000, 1500000),
            'area' => $this->faker->randomFloat(2, 30, 500),
            'quartos' => $this->faker->numberBetween(1, 5),
            'banheiros' => $this->faker->numberBetween(1, 4),
            'cozinhas' => $this->faker->numberBetween(1, 2),
            'vagas' => $this->faker->numberBetween(0, 3),
            'tipo_residencia' => $this->faker->randomElement(['residencial', 'comercial', null]),
            'endereco' => $this->faker->streetAddress(),
            'bairro' => $this->faker->randomElement($bairros),
            'cidade' => $cidade,
            'estado' => $estado,
            'cep' => $this->faker->numerify('64###-###'),
            'latitude' => $this->faker->latitude(-5.1, -2.8),
            'longitude' => $this->faker->longitude(-42.8, -41.0),
            'data_inicio' => null,
            'data_fim' => null,
            'destaque' => $this->faker->boolean(20),
            'aprovado' => $this->faker->boolean(80),
            'status' => 'active',
        ];
    }

    public function aprovado(): static
    {
        return $this->state(fn() => ['aprovado' => true]);
    }

    public function emDestaque(): static
    {
        return $this->state(fn() => ['destaque' => true]);
    }
}
