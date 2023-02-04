<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        collect(range(0, 149))
            ->each(function () {
                Recipe::factory()
                    ->has(Ingredient::factory(mt_rand(1, 10)))
                    ->create();
            });
    }
}
