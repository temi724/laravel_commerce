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
        $storageOptions = [
            ['size' => '64GB', 'price' => 699],
            ['size' => '128GB', 'price' => 799],
            ['size' => '256GB', 'price' => 899],
        ];

        $phoneModels = [
            'iPhone 15 Pro', 'Samsung Galaxy S24', 'Google Pixel 8',
            'OnePlus 12', 'Xiaomi 14', 'Sony Xperia 1 V'
        ];

        return [
            'product_name' => $this->faker->randomElement($phoneModels) . ' ' . $this->faker->word(),
            'reviews' => [
                $this->faker->sentence(10),
                $this->faker->sentence(8),
                $this->faker->sentence(12),
            ],
            'price' => $this->faker->randomFloat(2, 299, 1299),
            'overview' => $this->faker->paragraph(3),
            'description' => $this->faker->paragraph(5),
            'about' => $this->faker->paragraph(4),
            'images_url' => [
                $this->faker->imageUrl(400, 400, 'technics'),
                $this->faker->imageUrl(400, 400, 'technics'),
                $this->faker->imageUrl(400, 400, 'technics'),
            ],
            'what_is_included' => [
                'Device',
                'USB-C Cable',
                'Documentation',
                'SIM Ejection Tool',
            ],
            'specification' => [
                'productcondition' => $this->faker->randomElement(['New', 'Refurbished', 'Used - Like New']),
                'model' => $this->faker->randomElement($phoneModels),
                'basefeature' => [
                    'bluetooth' => $this->faker->randomElement(['5.0', '5.1', '5.2', '5.3']),
                    'dualsim' => $this->faker->boolean(),
                    'storage' => $this->faker->randomElements($storageOptions, $this->faker->numberBetween(1, 3)),
                    'ram' => $this->faker->randomElement(['6GB', '8GB', '12GB', '16GB']),
                    'operatingsystem' => $this->faker->randomElement(['iOS 17', 'Android 14', 'Android 13']),
                    'simcard' => $this->faker->randomElement(['Nano-SIM', 'eSIM', 'Nano-SIM + eSIM']),
                    'batterytype' => 'Li-Ion',
                    'connectivity' => $this->faker->randomElement(['4G LTE', '5G', '5G mmWave']),
                ],
            ],
            'in_stock' => $this->faker->boolean(80), // 80% chance of being in stock
        ];
    }
}
