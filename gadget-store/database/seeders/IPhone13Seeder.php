<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class IPhone13Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the Smartphones category
        $smartphoneCategory = Category::where('name', 'Smartphones')->first();

        if ($smartphoneCategory) {
            // Generate a proper ObjectId-style ID (24 characters)
            $objectId = str_pad(dechex(time()), 8, '0', STR_PAD_LEFT) . bin2hex(random_bytes(8));

            // Create iPhone 13 with the specified image
            $iphone13 = Product::create([
                'id' => $objectId,
                'product_name' => 'iPhone 13',
                'category_id' => $smartphoneCategory->id,
                'price' => 799.99,
                'description' => 'iPhone 13. The most advanced dual-camera system ever on iPhone. Lightning-fast A15 Bionic chip. A big leap in battery life.',
                'overview' => 'iPhone 13 features a 6.1-inch Super Retina XDR display, A15 Bionic chip, and advanced dual-camera system.',
                'about' => 'The iPhone 13 delivers incredible performance with the A15 Bionic chip, featuring a new 6-core CPU and 4-core GPU. The advanced dual-camera system captures stunning photos and videos in any light.',
                'images_url' => ['https://fdn2.gsmarena.com/vv/pics/apple/apple-iphone-13-01.jpg'],
                'specification' => [
                    'display' => '6.1-inch Super Retina XDR',
                    'chip' => 'A15 Bionic',
                    'camera' => 'Dual 12MP system',
                    'battery' => 'All-day battery life',
                    'storage' => ['128GB', '256GB', '512GB'],
                    'colors' => ['Pink', 'Blue', 'Midnight', 'Starlight', 'Red']
                ],
                'what_is_included' => [
                    'iPhone 13',
                    'USB-C to Lightning Cable',
                    'Documentation'
                ],
                'reviews' => [
                    'Amazing camera quality and performance!',
                    'Battery life is excellent, lasts all day.',
                    'Love the new colors, especially the pink one.',
                    'A15 chip makes everything super smooth.',
                    'Great value for money compared to Pro models.'
                ],
                'in_stock' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            echo "Successfully created iPhone 13!\n";
            echo "Product ID: " . $iphone13->id . "\n";
            echo "Product Name: " . $iphone13->product_name . "\n";
            echo "Price: $" . $iphone13->price . "\n";
            echo "Category: " . $smartphoneCategory->name . "\n";
            echo "Images: " . json_encode($iphone13->images_url) . "\n";
            echo "In Stock: " . ($iphone13->in_stock ? 'Yes' : 'No') . "\n";
        } else {
            echo "Error: Smartphones category not found!\n";
        }
    }
}
