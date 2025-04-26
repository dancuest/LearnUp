<?php

namespace Database\Factories;

use App\Models\Institucion;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstitucionFactory extends Factory
{
    protected $model = Institucion::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->company(),
            'tipo' => $this->faker->randomElement(['privado', 'publico']),
            'capacidad' => $this->faker->numberBetween(50, 500),
            'user_id' => \App\Models\User::factory(), // Relación con User
        ];
    }
}
