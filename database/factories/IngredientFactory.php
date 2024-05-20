<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'stock' => $this->faker->numberBetween(1, 1000),
            'harga_bahan' => $this->faker->numberBetween(100, 10000),
            'unit' => $this->faker->randomElement(['Gram', 'Kilogram', 'Liter']),
            'priceunit' => $this->faker->numberBetween(1, 100),
        ];
    }
}
