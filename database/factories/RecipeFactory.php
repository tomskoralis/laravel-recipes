<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(mt_rand(2, 6), true),
            'description' => fake()->paragraphs(1, true),
            'instructions' => fake()->paragraphs(2, true),
        ];
    }
}
