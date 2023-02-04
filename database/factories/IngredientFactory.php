<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(mt_rand(1, 3), true),
            'amount' => fake()->randomDigit() + 1 . ' ' . fake()->word(),
        ];
    }
}
