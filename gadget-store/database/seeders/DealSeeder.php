<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deals = [
            [
                'product_name' => 'MacBook Pro 16" M3 Max',
                'price' => 2499000, // ₦2,499,000
                'old_price' => 2999000, // ₦2,999,000
                'overview' => 'Powerful MacBook Pro with M3 Max chip, Liquid Retina XDR display, and all-day battery life',
                'description' => 'Experience the ultimate in performance with the MacBook Pro 16" featuring the M3 Max chip. Perfect for professional work, content creation, and demanding tasks.',
                'about' => 'The MacBook Pro 16" delivers incredible performance with the M3 Max chip, featuring up to 16 CPU cores and up to 40 GPU cores. The stunning Liquid Retina XDR display provides exceptional brightness and contrast.',
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
                    'MacBook Pro 16"',
                    '140W USB-C Power Adapter',
                    'USB-C to MagSafe 3 Cable (2 m)',
                    'Documentation'
                ],
                'specification' => [
                    'productcondition' => 'New',
                    'basefeature' => [
                        'brand' => 'Apple',
                        'model' => 'MacBook Pro 16"',
                        'processor' => 'Apple M3 Max',
                        'memory' => '32GB unified memory',
                        'storage' => '1TB SSD',
                        'display' => '16.2-inch Liquid Retina XDR',
                        'graphics' => 'M3 Max 40-core GPU',
                        'battery' => 'Up to 22 hours',
                        'weight' => '2.15 kg',
                        'warranty' => '1 Year Apple Warranty'
                    ]
                ],
                'in_stock' => true,
            ],
            [
                'product_name' => 'MacBook Pro 14" M3',
                'price' => 1899000, // ₦1,899,000
                'old_price' => 2299000, // ₦2,299,000
                'overview' => 'Compact and powerful MacBook Pro 14" with M3 chip, perfect for professionals on the go',
                'description' => 'The MacBook Pro 14" combines portability with professional performance. Ideal for developers, designers, and content creators.',
                'about' => 'Featuring the powerful M3 chip with up to 11 CPU cores and up to 14 GPU cores, the MacBook Pro 14" delivers exceptional performance in a compact form factor.',
                'images_url' => [
                    'https://www.notebookcheck.net/fileadmin/Notebooks/Apple/MacBook_Pro_14_2024_M4/IMG_7747.JPG',
                    'https://www.hoxtonmacs.co.uk/cdn/shop/products/apple-macbook-pro-14-inch-macbook-pro-14-inch-m1-max-10-core-space-grey-2021-good-40450384625980.jpg?v=1680270111'
                ],
                'colors' => [
                    ['name' => 'Space Gray', 'hex' => '#8E8E93'],
                    ['name' => 'Silver', 'hex' => '#F5F5F7'],
                ],
                'what_is_included' => [
                    'MacBook Pro 14"',
                    '70W USB-C Power Adapter',
                    'USB-C to MagSafe 3 Cable (2 m)',
                    'Documentation'
                ],
                'specification' => [
                    'productcondition' => 'New',
                    'basefeature' => [
                        'brand' => 'Apple',
                        'model' => 'MacBook Pro 14"',
                        'processor' => 'Apple M3',
                        'memory' => '16GB unified memory',
                        'storage' => '512GB SSD',
                        'display' => '14.2-inch Liquid Retina XDR',
                        'graphics' => 'M3 10-core GPU',
                        'battery' => 'Up to 18 hours',
                        'weight' => '1.61 kg',
                        'warranty' => '1 Year Apple Warranty'
                    ]
                ],
                'in_stock' => true,
            ],
            [
                'product_name' => 'iPhone 15 Pro Max',
                'price' => 1299000, // ₦1,299,000
                'old_price' => 1499000, // ₦1,499,000
                'overview' => 'The most advanced iPhone with titanium design, A17 Pro chip, and professional camera system',
                'description' => 'Experience the future of mobile technology with the iPhone 15 Pro Max. Featuring titanium design, A17 Pro chip, and an advanced camera system.',
                'about' => 'The iPhone 15 Pro Max features a titanium design that\'s incredibly strong and lightweight. Powered by the A17 Pro chip, it delivers exceptional performance for gaming, photography, and productivity.',
                'images_url' => [
                    'https://i.rtings.com/assets/products/achdBcky/apple-macbook-pro-16-m3-2023/design-medium.jpg?format=auto'
                ],
                'colors' => [
                    ['name' => 'Natural Titanium', 'hex' => '#8E8E93'],
                    ['name' => 'Blue Titanium', 'hex' => '#007AFF'],
                    ['name' => 'White Titanium', 'hex' => '#F5F5F7'],
                    ['name' => 'Black Titanium', 'hex' => '#1D1D1F'],
                ],
                'what_is_included' => [
                    'iPhone 15 Pro Max',
                    'USB-C to USB-C Cable (1 m)',
                    'Documentation'
                ],
                'specification' => [
                    'productcondition' => 'New',
                    'basefeature' => [
                        'brand' => 'Apple',
                        'model' => 'iPhone 15 Pro Max',
                        'processor' => 'A17 Pro chip',
                        'storage' => '256GB',
                        'display' => '6.7-inch Super Retina XDR',
                        'camera' => '48MP Main, 12MP Ultra Wide, 12MP Telephoto',
                        'battery' => 'Up to 29 hours video playback',
                        'weight' => '221 grams',
                        'warranty' => '1 Year Apple Warranty'
                    ]
                ],
                'in_stock' => true,
            ],
            [
                'product_name' => 'ASUS X415E Laptop',
                'price' => 599000, // ₦599,000
                'old_price' => 799000, // ₦799,000
                'overview' => 'Reliable ASUS laptop with 11th Gen Intel Core i5 processor, perfect for work and study',
                'description' => 'The ASUS X415E is a versatile laptop featuring an 11th Gen Intel Core i5 processor, 8GB RAM, and 256GB SSD storage. Ideal for students, professionals, and everyday computing needs.',
                'about' => 'Powered by the 11th Gen Intel Core i5-1135G7 processor, this ASUS laptop delivers reliable performance for multitasking, web browsing, and light content creation. The 15.6-inch display provides clear visuals for work and entertainment.',
                'images_url' => [
                    'https://www.technocratng.com/wp-content/uploads/2024/01/ASUS-X415E-LAPTOP-11TH-GEN-INTEL-CORE-I5-1135G7-8GB-256-GB-SSD.jpg'
                ],
                'colors' => [
                    ['name' => 'Silver', 'hex' => '#C0C0C0'],
                    ['name' => 'Black', 'hex' => '#000000'],
                ],
                'what_is_included' => [
                    'ASUS X415E Laptop',
                    'Power Adapter',
                    'User Manual',
                    'Warranty Card'
                ],
                'specification' => [
                    'productcondition' => 'New',
                    'basefeature' => [
                        'brand' => 'ASUS',
                        'model' => 'X415E',
                        'processor' => '11th Gen Intel Core i5-1135G7',
                        'memory' => '8GB DDR4 RAM',
                        'storage' => '256GB SSD',
                        'display' => '15.6-inch HD Display',
                        'graphics' => 'Intel Iris Xe Graphics',
                        'battery' => 'Up to 6 hours',
                        'weight' => '1.8 kg',
                        'operating_system' => 'Windows 11',
                        'warranty' => '1 Year Warranty'
                    ]
                ],
                'in_stock' => true,
            ]
        ];

        foreach ($deals as $dealData) {
            \App\Models\Deal::create($dealData);
        }
    }
}
