<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productNames = [
            'MacBook Pro 16" M3 Max',
            'iPhone 15 Pro Max',
            'iPad Pro 12.9"',
            'AirPods Pro (2nd generation)',
            'Apple Watch Series 9',
            'Sony WH-1000XM5',
            'Dell XPS 13',
            'Samsung Galaxy S24 Ultra',
            'Google Pixel 8 Pro',
            'Microsoft Surface Pro 9'
        ];

        $productName = fake()->randomElement($productNames);
        $currentPrice = fake()->numberBetween(50000, 300000); // ₦50,000 - ₦300,000
        $oldPrice = $currentPrice + fake()->numberBetween(20000, 100000); // Add 20k-100k to current price

        return [
            'id' => $this->generateObjectId(),
            'product_name' => $productName,
            'category_id' => null, // Will be set when seeding
            'price' => $currentPrice,
            'old_price' => $oldPrice,
            'overview' => fake()->sentence(10),
            'description' => fake()->paragraph(3),
            'about' => fake()->paragraph(2),
            'reviews' => [
                [
                    'user' => fake()->name(),
                    'rating' => fake()->numberBetween(4, 5),
                    'comment' => fake()->sentence(15),
                    'date' => fake()->dateTimeBetween('-6 months')->format('Y-m-d')
                ]
            ],
            'images_url' => [
                'https://www.notebookcheck.net/fileadmin/Notebooks/Apple/MacBook_Pro_14_2024_M4/IMG_7747.JPG',
                'https://www.hoxtonmacs.co.uk/cdn/shop/products/apple-macbook-pro-14-inch-macbook-pro-14-inch-m1-max-10-core-space-grey-2021-good-40450384625980.jpg?v=1680270111',
                'https://i.rtings.com/assets/products/achdBcky/apple-macbook-pro-16-m3-2023/design-medium.jpg?format=auto'
            ],
            'colors' => [
                ['name' => 'Space Gray', 'hex' => '#8E8E93'],
                ['name' => 'Silver', 'hex' => '#F5F5F7'],
            ],
            'what_is_included' => [
                'Product box',
                'Charging cable',
                'User manual',
                'Warranty card'
            ],
            'specification' => [
                'productcondition' => fake()->randomElement(['New', 'Refurbished', 'Used - Like New']),
                'basefeature' => [
                    'brand' => 'Apple',
                    'model' => substr($productName, 0, 20),
                    'warranty' => '1 Year'
                ]
            ],
            'in_stock' => fake()->boolean(80), // 80% chance of being in stock
        ];
    }

    private function generateObjectId()
    {
        return sprintf('%08x%08x%08x',
            time(),
            mt_rand(0, 0xffffff),
            mt_rand(0, 0xffffff)
        );
    }
}
