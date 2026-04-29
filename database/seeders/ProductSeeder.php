<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get product categories and admin user
        $categories = Category::forProducts()->active()->get();
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $admin = User::first(); // Fallback to first user if no admin
        }

        // Sample products data
        $products = [
            [
                'name' => 'Laptop Gaming ASUS ROG Strix',
                'sku' => 'LPT-ASUS-ROG-001',
                'description' => 'Laptop gaming high-end dengan processor Intel Core i7, RAM 16GB, dan graphics card RTX 4060. Cocok untuk gaming dan productivity.',
                'price' => 25000000.00,
                'sale_price' => 23500000.00,
                'stock' => 15,
                'min_stock' => 3,
                'weight' => 2.5,
                'dimensions' => '35.5 x 25.5 x 2.5',
                'is_featured' => true,
                'meta_description' => 'Laptop gaming ASUS ROG Strix dengan performa tinggi untuk gaming dan productivity',
                'meta_keywords' => 'laptop gaming, ASUS ROG, RTX 4060, Intel Core i7',
            ],
            [
                'name' => 'Mouse Gaming Logitech G Pro X',
                'sku' => 'MSE-LOG-GPX-002',
                'description' => 'Mouse gaming wireless dengan sensor HERO 25K, battery life hingga 70 jam, dan design ergonomis untuk competitive gaming.',
                'price' => 1250000.00,
                'sale_price' => null,
                'stock' => 45,
                'min_stock' => 10,
                'weight' => 0.063,
                'dimensions' => '12.5 x 6.3 x 4.0',
                'is_featured' => true,
                'meta_description' => 'Mouse gaming Logitech G Pro X wireless dengan sensor HERO 25K',
                'meta_keywords' => 'mouse gaming, logitech, wireless, HERO sensor',
            ],
            [
                'name' => 'Keyboard Mechanical Corsair K95',
                'sku' => 'KBD-COR-K95-003',
                'description' => 'Keyboard mechanical gaming dengan Cherry MX switches, RGB lighting, dan dedicated macro keys. Build quality premium.',
                'price' => 3500000.00,
                'sale_price' => 3200000.00,
                'stock' => 25,
                'min_stock' => 5,
                'weight' => 1.4,
                'dimensions' => '46.4 x 17.0 x 3.8',
                'is_featured' => false,
                'meta_description' => 'Keyboard mechanical Corsair K95 dengan Cherry MX switches dan RGB lighting',
                'meta_keywords' => 'keyboard mechanical, corsair, cherry mx, rgb gaming',
            ],
            [
                'name' => 'Monitor Gaming ASUS TUF 27"',
                'sku' => 'MON-ASUS-TUF27-004',
                'description' => 'Monitor gaming 27 inci dengan refresh rate 144Hz, resolusi 2K QHD, dan teknologi FreeSync untuk pengalaman gaming yang smooth.',
                'price' => 4500000.00,
                'sale_price' => null,
                'stock' => 12,
                'min_stock' => 2,
                'weight' => 6.5,
                'dimensions' => '61.4 x 45.2 x 21.0',
                'is_featured' => true,
                'meta_description' => 'Monitor gaming ASUS TUF 27 inci 144Hz 2K QHD dengan FreeSync',
                'meta_keywords' => 'monitor gaming, ASUS TUF, 144Hz, 2K QHD, FreeSync',
            ],
            [
                'name' => 'Headset Gaming SteelSeries Arctis 7',
                'sku' => 'HDS-SS-ARC7-005',
                'description' => 'Headset gaming wireless dengan audio berkualitas tinggi, microphone ClearCast, dan battery life 24 jam.',
                'price' => 2200000.00,
                'sale_price' => 1980000.00,
                'stock' => 30,
                'min_stock' => 8,
                'weight' => 0.35,
                'dimensions' => '20.0 x 18.0 x 9.0',
                'is_featured' => false,
                'meta_description' => 'Headset gaming SteelSeries Arctis 7 wireless dengan audio berkualitas tinggi',
                'meta_keywords' => 'headset gaming, steelseries, wireless, arctis 7',
            ],
            [
                'name' => 'Webcam Logitech C920 HD Pro',
                'sku' => 'WBC-LOG-C920-006',
                'description' => 'Webcam HD 1080p dengan auto-focus dan built-in microphone. Ideal untuk streaming dan video conference.',
                'price' => 1500000.00,
                'sale_price' => null,
                'stock' => 40,
                'min_stock' => 10,
                'weight' => 0.16,
                'dimensions' => '9.4 x 2.9 x 7.1',
                'is_featured' => false,
                'meta_description' => 'Webcam Logitech C920 HD Pro 1080p untuk streaming dan video conference',
                'meta_keywords' => 'webcam, logitech c920, 1080p, streaming',
            ],
            [
                'name' => 'SSD Samsung 970 EVO Plus 1TB',
                'sku' => 'SSD-SAM-970EP-007',
                'description' => 'SSD NVMe M.2 dengan kecepatan baca hingga 3,500 MB/s. Upgrade storage terbaik untuk performa maksimal.',
                'price' => 1800000.00,
                'sale_price' => 1650000.00,
                'stock' => 60,
                'min_stock' => 15,
                'weight' => 0.008,
                'dimensions' => '8.0 x 2.2 x 0.15',
                'is_featured' => true,
                'meta_description' => 'SSD Samsung 970 EVO Plus 1TB NVMe M.2 dengan kecepatan tinggi',
                'meta_keywords' => 'SSD, samsung 970 evo, NVMe, M.2, 1TB',
            ],
            [
                'name' => 'RAM Corsair Vengeance 16GB DDR4',
                'sku' => 'RAM-COR-VEN16-008',
                'description' => 'Memory RAM DDR4 16GB (2x8GB) dengan frekuensi 3200MHz. Optimized untuk gaming dan multitasking.',
                'price' => 1200000.00,
                'sale_price' => null,
                'stock' => 35,
                'min_stock' => 10,
                'weight' => 0.045,
                'dimensions' => '13.3 x 0.8 x 3.4',
                'is_featured' => false,
                'meta_description' => 'RAM Corsair Vengeance 16GB DDR4 3200MHz untuk gaming dan multitasking',
                'meta_keywords' => 'RAM, corsair vengeance, DDR4, 16GB, 3200MHz',
            ],
            [
                'name' => 'GPU RTX 4060 Ti ASUS Dual',
                'sku' => 'GPU-ASUS-4060TI-009',
                'description' => 'Graphics card RTX 4060 Ti dengan 16GB VRAM, DLSS 3, dan Ray Tracing. Performa gaming 1440p yang optimal.',
                'price' => 8500000.00,
                'sale_price' => 8200000.00,
                'stock' => 8,
                'min_stock' => 2,
                'weight' => 1.1,
                'dimensions' => '26.7 x 13.1 x 5.0',
                'is_featured' => true,
                'meta_description' => 'GPU RTX 4060 Ti ASUS Dual 16GB dengan DLSS 3 dan Ray Tracing',
                'meta_keywords' => 'GPU, RTX 4060 Ti, ASUS, DLSS 3, Ray Tracing',
            ],
            [
                'name' => 'Cooling Fan Noctua NH-D15',
                'sku' => 'FAN-NOC-NHD15-010',
                'description' => 'CPU cooler premium dengan dual tower dan 2 fan. Cooling performance terbaik dengan noise level rendah.',
                'price' => 1100000.00,
                'sale_price' => null,
                'stock' => 20,
                'min_stock' => 5,
                'weight' => 1.32,
                'dimensions' => '16.5 x 15.0 x 16.1',
                'is_featured' => false,
                'meta_description' => 'CPU cooler Noctua NH-D15 premium dengan dual tower dan 2 fan',
                'meta_keywords' => 'CPU cooler, noctua, NH-D15, dual tower, premium cooling',
            ]
        ];

        // Create products
        foreach ($products as $index => $productData) {
            // Generate slug from name
            $productData['slug'] = Str::slug($productData['name']);
            
            // Assign random category or use first category if available
            $productData['category_id'] = $categories->isNotEmpty() 
                ? $categories->random()->id 
                : 1; // fallback to category ID 1
            
            // Assign admin user
            $productData['user_id'] = $admin->id;
            
            // Set default status
            $productData['status'] = 'active';
            
            // Set track_stock to true
            $productData['track_stock'] = true;

            Product::create($productData);
        }

        // Update view_count and order_count with random values for some realism
        Product::all()->each(function ($product) {
            $product->update([
                'view_count' => rand(50, 1500),
                'order_count' => rand(5, 100),
            ]);
        });

        $this->command->info('✅ ProductSeeder completed! Created ' . count($products) . ' sample products.');
    }
}
