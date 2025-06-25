<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'purchase_price' => $purchasePrice = $this->faker->randomFloat(2, 1, 100),
            'sell_price' => $this->faker->randomFloat(2, $purchasePrice + 0.01, 200),
            'stock' => 50,
        ];
    }
}
