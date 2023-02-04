<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(mt_rand(2, 8), true),
            'description' => fake()->words(mt_rand(10, 30), true),
            'instructions' => fake()->words(mt_rand(40, 80), true),
        ];
    }
}
