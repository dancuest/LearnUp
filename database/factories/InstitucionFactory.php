<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Institucion>
 */
class InstitucionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'nombre' => fake()->company(),
        'tipo' => fake()->randomElement(['Publico', 'Privado']),
        'capacidad' => fake()->numberBetween(100, 500),
        'imagen_perfil' => fake()->imageUrl(200, 200, 'people', true, 'perfil'),
        'descripcion' => fake()->text(),
        'user_id' => \App\Models\User::factory(),
        ];
    }
}
