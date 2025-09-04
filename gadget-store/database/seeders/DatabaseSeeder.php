<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Sales;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Only create test user if it doesn't exist
        if (User::where('email', 'test@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Seed products - ensure distribution across all categories
        $this->seedProductsAcrossCategories();

        // Seed 20 sales
        Sales::factory(20)->create();
    }

    /**
     * Seed products ensuring distribution across all categories
     */
    private function seedProductsAcrossCategories(): void
    {
        // Get all categories
        $categories = \App\Models\Category::all();

        if ($categories->isEmpty()) {
            $this->command->info("No categories found. Please seed categories first.");
            return;
        }

        // Calculate products per category for even distribution
        $totalProducts = 100;
        $productsPerCategory = intval($totalProducts / $categories->count());
        $remainingProducts = $totalProducts % $categories->count();

        $this->command->info("Seeding {$totalProducts} products across {$categories->count()} categories...");

        foreach ($categories as $index => $category) {
            $categoryProductCount = $productsPerCategory;

            // Add remaining products to the first few categories
            if ($index < $remainingProducts) {
                $categoryProductCount++;
            }

            $this->command->info("Creating {$categoryProductCount} products for category: {$category->name}");

            // Create products specifically for this category
            for ($i = 0; $i < $categoryProductCount; $i++) {
                $this->createProductForCategory($category);
            }
        }

        $this->command->info("Successfully seeded {$totalProducts} products!");

        // Display category distribution
        foreach ($categories as $category) {
            $count = Product::where('category_id', $category->id)->count();
            $this->command->info("- {$category->name}: {$count} products");
        }
    }

    /**
     * Create a product for a specific category
     */
    private function createProductForCategory($category): void
    {
        $productData = $this->getCategorySpecificData($category->name);

        Product::create([
            'product_name' => $productData['name'],
            'category_id' => $category->id,
            'reviews' => $productData['reviews'],
            'price' => $productData['price'],
            'overview' => $productData['overview'],
            'description' => $productData['description'],
            'about' => $productData['about'],
            'images_url' => $productData['images_url'],
            'colors' => $productData['colors'],
            'what_is_included' => $productData['included'],
            'specification' => $productData['specification'],
            'in_stock' => $productData['in_stock'],
        ]);
    }

    /**
     * Get category-specific product data
     */
    private function getCategorySpecificData(string $categoryName): array
    {
        $faker = \Faker\Factory::create();

        switch ($categoryName) {
            case 'Tablets':
                return $this->getTabletData($faker);
            case 'Smart Watches':
                return $this->getSmartWatchData($faker);
            case 'Gaming Consoles':
                return $this->getGamingConsoleData($faker);
            case 'Laptops':
                return $this->getLaptopData($faker);
            case 'Smart Home':
                return $this->getSmartHomeData($faker);
            case 'Speakers':
                return $this->getSpeakerData($faker);
            default:
                return $this->getDefaultProductData($faker);
        }
    }

    private function getTabletData($faker): array
    {
        $models = ['iPad Pro', 'iPad Air', 'Samsung Galaxy Tab S9', 'Surface Pro', 'Lenovo Tab P11', 'Fire HD 10'];
        $model = $faker->randomElement($models);

        return [
            'name' => $model . ' ' . $faker->randomElement(['11"', '12.9"', '10.9"', '13"']) . ' ' . $faker->word(),
            'reviews' => [
                $faker->sentence(10),
                $faker->sentence(8),
                $faker->sentence(12),
            ],
            'price' => $faker->randomFloat(2, 299, 1599),
            'overview' => 'Professional tablet perfect for work, creativity, and entertainment with stunning display and powerful performance.',
            'description' => 'Experience next-level productivity with this premium tablet featuring advanced processors, all-day battery life, and versatile connectivity options.',
            'about' => 'Designed for professionals and creators who demand the best in portable computing power and versatility.',
            'images_url' => [
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
            ],
            'colors' => [
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Space Gray'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Silver'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Rose Gold']
            ],
            'included' => ['Tablet', 'USB-C Cable', 'Quick Start Guide', 'Warranty Card'],
            'specification' => [
                'productcondition' => $faker->randomElement(['New', 'Refurbished', 'Used - Like New']),
                'model' => $model,
                'basefeature' => [
                    'display' => $faker->randomElement(['Liquid Retina', 'AMOLED', 'IPS LCD']),
                    'storage' => $faker->randomElement(['64GB', '128GB', '256GB', '512GB', '1TB']),
                    'ram' => $faker->randomElement(['4GB', '6GB', '8GB', '16GB']),
                    'operatingsystem' => $faker->randomElement(['iPadOS 17', 'Android 14', 'Windows 11']),
                    'connectivity' => $faker->randomElement(['Wi-Fi', 'Wi-Fi + Cellular', '5G']),
                    'battery' => $faker->randomElement(['10 hours', '12 hours', '14 hours']),
                ]
            ],
            'in_stock' => $faker->boolean(80),
        ];
    }

    private function getSmartWatchData($faker): array
    {
        $models = ['Apple Watch Series 9', 'Samsung Galaxy Watch 6', 'Fitbit Versa 4', 'Garmin Venu 3', 'Amazfit GTR 4'];
        $model = $faker->randomElement($models);

        return [
            'name' => $model . ' ' . $faker->randomElement(['GPS', 'Cellular', 'Classic', 'Sport']) . ' ' . $faker->word(),
            'reviews' => [
                $faker->sentence(10),
                $faker->sentence(8),
                $faker->sentence(12),
            ],
            'price' => $faker->randomFloat(2, 199, 899),
            'overview' => 'Advanced smartwatch with health monitoring, fitness tracking, and smart connectivity features.',
            'description' => 'Stay connected and monitor your health with this feature-rich smartwatch offering comprehensive fitness tracking and smart notifications.',
            'about' => 'Perfect for fitness enthusiasts and tech-savvy users who want to stay connected on the go.',
            'images_url' => [
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
            ],
            'colors' => [
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Midnight'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Starlight'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Product Red']
            ],
            'included' => ['Smartwatch', 'Sport Band', 'Magnetic Charging Cable', 'Quick Start Guide'],
            'specification' => [
                'productcondition' => $faker->randomElement(['New', 'Refurbished', 'Used - Like New']),
                'model' => $model,
                'basefeature' => [
                    'display' => $faker->randomElement(['OLED', 'AMOLED', 'Always-On Retina']),
                    'waterresistance' => $faker->randomElement(['50m', '100m', 'IP68']),
                    'battery' => $faker->randomElement(['18 hours', '24 hours', '7 days']),
                    'sensors' => $faker->randomElement(['Heart Rate + GPS', 'ECG + SpO2', 'Full Health Suite']),
                    'connectivity' => $faker->randomElement(['Bluetooth + Wi-Fi', 'Cellular', 'GPS + GLONASS']),
                    'compatibility' => $faker->randomElement(['iOS', 'Android', 'Universal']),
                ]
            ],
            'in_stock' => $faker->boolean(80),
        ];
    }

    private function getGamingConsoleData($faker): array
    {
        $models = ['PlayStation 5', 'Xbox Series X', 'Nintendo Switch OLED', 'Steam Deck', 'Xbox Series S'];
        $model = $faker->randomElement($models);

        return [
            'name' => $model . ' ' . $faker->randomElement(['Console', 'Bundle', 'Digital Edition']) . ' ' . $faker->word(),
            'reviews' => [
                $faker->sentence(10),
                $faker->sentence(8),
                $faker->sentence(12),
            ],
            'price' => $faker->randomFloat(2, 299, 699),
            'overview' => 'Next-generation gaming console delivering immersive gaming experiences with cutting-edge graphics and performance.',
            'description' => 'Experience gaming like never before with lightning-fast loading, stunning visuals, and an extensive library of games.',
            'about' => 'Built for gamers who demand the ultimate gaming experience with premium performance and exclusive titles.',
            'images_url' => [
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
            ],
            'colors' => [
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'White'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Black']
            ],
            'included' => ['Console', 'Controller', 'HDMI Cable', 'Power Cable', 'Quick Setup Guide'],
            'specification' => [
                'productcondition' => $faker->randomElement(['New', 'Refurbished', 'Used - Like New']),
                'model' => $model,
                'basefeature' => [
                    'storage' => $faker->randomElement(['512GB SSD', '1TB SSD', '825GB SSD']),
                    'resolution' => $faker->randomElement(['4K', '4K HDR', '8K capable']),
                    'framerate' => $faker->randomElement(['60fps', '120fps', 'Up to 120fps']),
                    'raytracing' => $faker->boolean(),
                    'backwards_compatibility' => $faker->boolean(),
                    'online_services' => $faker->randomElement(['PlayStation Plus', 'Xbox Game Pass', 'Nintendo Online']),
                ]
            ],
            'in_stock' => $faker->boolean(80),
        ];
    }

    private function getLaptopData($faker): array
    {
        $models = ['MacBook Pro', 'Dell XPS 13', 'ThinkPad X1 Carbon', 'Surface Laptop', 'HP Spectre x360', 'ASUS ZenBook'];
        $model = $faker->randomElement($models);

        return [
            'name' => $model . ' ' . $faker->randomElement(['13"', '14"', '15"', '16"']) . ' ' . $faker->word(),
            'reviews' => [
                $faker->sentence(10),
                $faker->sentence(8),
                $faker->sentence(12),
            ],
            'price' => $faker->randomFloat(2, 699, 3499),
            'overview' => 'High-performance laptop designed for professionals, students, and power users demanding premium computing experience.',
            'description' => 'Powerful laptop featuring cutting-edge processors, stunning display, and all-day battery life for maximum productivity.',
            'about' => 'Perfect for professionals, creators, and students who need reliable performance and portability.',
            'images_url' => [
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
            ],
            'colors' => [
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Space Gray'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Silver'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Gold']
            ],
            'included' => ['Laptop', 'Power Adapter', 'USB-C Cable', 'Quick Start Guide', 'Warranty Information'],
            'specification' => [
                'productcondition' => $faker->randomElement(['New', 'Refurbished', 'Used - Like New']),
                'model' => $model,
                'basefeature' => [
                    'processor' => $faker->randomElement(['M3 Pro', 'Intel i7', 'AMD Ryzen 7', 'Intel i5']),
                    'ram' => $faker->randomElement(['8GB', '16GB', '32GB', '64GB']),
                    'storage' => $faker->randomElement(['256GB SSD', '512GB SSD', '1TB SSD', '2TB SSD']),
                    'display' => $faker->randomElement(['Retina', '4K OLED', 'QHD+', 'Full HD']),
                    'graphics' => $faker->randomElement(['Integrated', 'Dedicated GPU', 'RTX 4060']),
                    'battery' => $faker->randomElement(['10 hours', '15 hours', '18 hours']),
                ]
            ],
            'in_stock' => $faker->boolean(80),
        ];
    }

    private function getSmartHomeData($faker): array
    {
        $models = ['Echo Dot', 'Google Nest Hub', 'Philips Hue', 'Ring Video Doorbell', 'Nest Thermostat', 'Arlo Security Camera'];
        $model = $faker->randomElement($models);

        return [
            'name' => $model . ' ' . $faker->randomElement(['Gen 5', 'Pro', '2024', 'Max']) . ' ' . $faker->word(),
            'reviews' => [
                $faker->sentence(10),
                $faker->sentence(8),
                $faker->sentence(12),
            ],
            'price' => $faker->randomFloat(2, 49, 399),
            'overview' => 'Smart home device that enhances your living space with intelligent automation and voice control features.',
            'description' => 'Transform your home into a smart home with this innovative device offering convenience, security, and energy efficiency.',
            'about' => 'Designed for homeowners who want to embrace smart technology and create a more connected living environment.',
            'images_url' => [
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
            ],
            'colors' => [
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'White'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Black'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Charcoal']
            ],
            'included' => ['Smart Device', 'Power Adapter', 'Mounting Hardware', 'Quick Setup Guide', 'App Instructions'],
            'specification' => [
                'productcondition' => $faker->randomElement(['New', 'Refurbished', 'Used - Like New']),
                'model' => $model,
                'basefeature' => [
                    'connectivity' => $faker->randomElement(['Wi-Fi', 'Bluetooth', 'Zigbee', 'Z-Wave']),
                    'voice_control' => $faker->randomElement(['Alexa', 'Google Assistant', 'Siri', 'Built-in']),
                    'compatibility' => $faker->randomElement(['iOS + Android', 'Universal', 'Smart Home Platforms']),
                    'power' => $faker->randomElement(['Plug-in', 'Battery', 'Rechargeable']),
                    'installation' => $faker->randomElement(['DIY', 'Professional', 'Plug & Play']),
                    'features_extra' => $faker->randomElement(['Motion Detection', 'Night Vision', 'Energy Monitoring']),
                ]
            ],
            'in_stock' => $faker->boolean(80),
        ];
    }

    private function getSpeakerData($faker): array
    {
        $models = ['HomePod', 'Sonos One', 'JBL Charge 5', 'Bose SoundLink', 'Sony WH-1000XM5', 'Bang & Olufsen Beosound'];
        $model = $faker->randomElement($models);

        return [
            'name' => $model . ' ' . $faker->randomElement(['Wireless', 'Bluetooth', 'Smart', 'Portable']) . ' ' . $faker->word(),
            'reviews' => [
                $faker->sentence(10),
                $faker->sentence(8),
                $faker->sentence(12),
            ],
            'price' => $faker->randomFloat(2, 99, 799),
            'overview' => 'Premium audio speaker delivering exceptional sound quality and innovative features for music enthusiasts.',
            'description' => 'Experience rich, immersive audio with this high-quality speaker featuring advanced sound technology and smart connectivity.',
            'about' => 'Perfect for audiophiles and music lovers who appreciate superior sound quality and modern features.',
            'images_url' => [
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
            ],
            'colors' => [
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Black'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'White'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Blue']
            ],
            'included' => ['Speaker', 'Charging Cable', 'Audio Cable', 'Carrying Case', 'User Manual'],
            'specification' => [
                'productcondition' => $faker->randomElement(['New', 'Refurbished', 'Used - Like New']),
                'model' => $model,
                'basefeature' => [
                    'audio_quality' => $faker->randomElement(['Hi-Fi', 'Studio Quality', '360° Sound']),
                    'connectivity' => $faker->randomElement(['Bluetooth 5.0', 'Wi-Fi + Bluetooth', 'AirPlay 2']),
                    'battery' => $faker->randomElement(['12 hours', '20 hours', 'Plug-in']),
                    'waterproof' => $faker->randomElement(['IPX7', 'IP67', 'Not Waterproof']),
                    'voice_assistant' => $faker->randomElement(['Alexa', 'Google Assistant', 'Siri', 'None']),
                    'multiroom' => $faker->boolean(),
                ]
            ],
            'in_stock' => $faker->boolean(80),
        ];
    }

    private function getDefaultProductData($faker): array
    {
        $models = ['iPhone 15 Pro', 'Samsung Galaxy S24', 'Google Pixel 8', 'OnePlus 12'];
        $model = $faker->randomElement($models);
        return [
            'name' => $model . ' ' . $faker->word(),
            'reviews' => [
                $faker->sentence(10),
                $faker->sentence(8),
                $faker->sentence(12),
            ],
            'price' => $faker->randomFloat(2, 299, 1299),
            'overview' => $faker->paragraph(3),
            'description' => $faker->paragraph(5),
            'about' => $faker->paragraph(4),
            'images_url' => [
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
                $faker->imageUrl(400, 400, 'technics'),
            ],
            'colors' => [
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Space Black'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Silver'],
                ['path' => $faker->imageUrl(200, 200, 'abstract'), 'name' => 'Gold']
            ],
            'included' => ['Device', 'Cable', 'Documentation'],
            'specification' => [
                'productcondition' => $faker->randomElement(['New', 'Refurbished', 'Used - Like New']),
                'model' => $model,
                'basefeature' => [
                    'bluetooth' => $faker->randomElement(['5.0', '5.1', '5.2', '5.3']),
                    'storage' => $faker->randomElement(['128GB', '256GB', '512GB']),
                ]
            ],
            'in_stock' => $faker->boolean(80),
        ];
    }
}
