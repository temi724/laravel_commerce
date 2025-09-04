<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class AdditionalSmartphonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the Smartphones category
        $smartphoneCategory = Category::where('name', 'Smartphones')->first();

        if ($smartphoneCategory) {
            $smartphones = [
                [
                    'name' => 'iPhone 14',
                    'price' => 899.99,
                    'image' => 'https://fdn2.gsmarena.com/vv/pics/apple/apple-iphone-14-01.jpg',
                    'description' => 'iPhone 14. All-new Action mode for smoother, steadier video. Crash Detection for emergency help.',
                    'colors' => ['Blue', 'Purple', 'Midnight', 'Starlight', 'Red']
                ],
                [
                    'name' => 'Samsung Galaxy S23',
                    'price' => 799.99,
                    'image' => 'https://fdn2.gsmarena.com/vv/pics/samsung/samsung-galaxy-s23-5g-01.jpg',
                    'description' => 'Galaxy S23. Epic photos and videos in any light with enhanced cameras.',
                    'colors' => ['Phantom Black', 'Cream', 'Green', 'Lavender']
                ],
                [
                    'name' => 'Google Pixel 8',
                    'price' => 699.99,
                    'image' => 'https://fdn2.gsmarena.com/vv/pics/google/google-pixel-8-01.jpg',
                    'description' => 'Pixel 8. The most helpful phone powered by Google AI.',
                    'colors' => ['Obsidian', 'Hazel', 'Rose']
                ]
            ];

            foreach ($smartphones as $phone) {
                // Generate a proper ObjectId-style ID (24 characters)
                $objectId = str_pad(dechex(time() + rand(1, 1000)), 8, '0', STR_PAD_LEFT) . bin2hex(random_bytes(8));

                Product::create([
                    'id' => $objectId,
                    'product_name' => $phone['name'],
                    'category_id' => $smartphoneCategory->id,
                    'price' => $phone['price'],
                    'description' => $phone['description'],
                    'overview' => 'Premium smartphone with advanced features and high-quality camera system.',
                    'about' => 'Latest technology smartphone with excellent performance and innovative features.',
                    'images_url' => [$phone['image']],
                    'specification' => [
                        'display' => '6.1-inch Display',
                        'camera' => 'Advanced camera system',
                        'battery' => 'All-day battery life',
                        'storage' => ['128GB', '256GB', '512GB'],
                        'colors' => $phone['colors']
                    ],
                    'what_is_included' => [
                        $phone['name'],
                        'USB-C Cable',
                        'Documentation'
                    ],
                    'reviews' => [
                        'Excellent camera quality!',
                        'Great performance and battery life.',
                        'Love the design and build quality.',
                        'Fast and responsive interface.',
                        'Highly recommended smartphone.'
                    ],
                    'in_stock' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                echo "Added: " . $phone['name'] . " - $" . $phone['price'] . "\n";
            }

            $totalSmartphones = Product::where('category_id', $smartphoneCategory->id)->count();
            echo "\nTotal smartphones in category: " . $totalSmartphones . "\n";
        } else {
            echo "Error: Smartphones category not found!\n";
        }
    }
}
