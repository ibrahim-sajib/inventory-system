<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            [
                'customer_name' => fake()->name(),
                'subtotal' => 1000,
                'discount' => 50,
                'vat' => 100,
                'total' => 1050,
                'paid' => 800,
                'due' => 250,
            ],
            [
                'customer_name' => fake()->name(),
                'subtotal' => 2000,
                'discount' => 100,
                'vat' => 200,
                'total' => 2100,
                'paid' => 2100,
                'due' => 0,
            ],
            [
                'customer_name' => fake()->name(),
                'subtotal' => 1500,
                'discount' => 75,
                'vat' => 150,
                'total' => 1575,
                'paid' => 1000,
                'due' => 575,
            ],
        ];

        foreach ($sales as $sale) {
            Sale::create($sale);
        }
    }
}
