<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing categories to type = 'post'
        Category::whereNull('type')->update(['type' => 'post']);

        // Product Categories
        $productCategories = [
            [
                'name' => 'Laptops & Computers',
                'type' => 'product',
                'description' => 'Laptop gaming, workstation, desktop PC, dan aksesoris komputer',
                'color' => '#3B82F6',
                'icon' => 'fas fa-laptop',
                'sort_order' => 1
            ],
            [
                'name' => 'Gaming Peripherals',
                'type' => 'product',
                'description' => 'Mouse gaming, keyboard mechanical, headset, dan aksesoris gaming',
                'color' => '#EF4444',
                'icon' => 'fas fa-gamepad',
                'sort_order' => 2
            ],
            [
                'name' => 'Audio & Video',
                'type' => 'product',
                'description' => 'Speaker, headphone, webcam, microphone, dan perangkat multimedia',
                'color' => '#F59E0B',
                'icon' => 'fas fa-headphones',
                'sort_order' => 3
            ],
            [
                'name' => 'PC Components',
                'type' => 'product',
                'description' => 'RAM, SSD, HDD, GPU, motherboard, dan komponen PC lainnya',
                'color' => '#7C3AED',
                'icon' => 'fas fa-microchip',
                'sort_order' => 4
            ],
            [
                'name' => 'Monitors & Displays',
                'type' => 'product',
                'description' => 'Monitor gaming, monitor profesional, TV, dan layar display',
                'color' => '#059669',
                'icon' => 'fas fa-desktop',
                'sort_order' => 5
            ],
            [
                'name' => 'Mobile & Tablets',
                'type' => 'product',
                'description' => 'Smartphone, tablet, smartwatch, dan aksesoris mobile',
                'color' => '#EC4899',
                'icon' => 'fas fa-mobile-alt',
                'sort_order' => 6
            ],
            [
                'name' => 'Networking',
                'type' => 'product',
                'description' => 'Router, modem, switch, access point, dan perangkat networking',
                'color' => '#06B6D4',
                'icon' => 'fas fa-wifi',
                'sort_order' => 7
            ],
            [
                'name' => 'Storage & Memory',
                'type' => 'product',
                'description' => 'External HDD, flash drive, memory card, dan solusi penyimpanan',
                'color' => '#F97316',
                'icon' => 'fas fa-hdd',
                'sort_order' => 8
            ],
            [
                'name' => 'Power & Cooling',
                'type' => 'product',
                'description' => 'Power supply, UPS, cooling fan, liquid cooling, dan thermal paste',
                'color' => '#8B5CF6',
                'icon' => 'fas fa-fan',
                'sort_order' => 9
            ],
            [
                'name' => 'Cables & Adapters',
                'type' => 'product',
                'description' => 'Kabel USB, HDMI, adapter, converter, dan aksesoris konektivitas',
                'color' => '#374151',
                'icon' => 'fas fa-plug',
                'sort_order' => 10
            ]
        ];

        // Create product categories
        foreach ($productCategories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ ProductCategorySeeder completed! Created ' . count($productCategories) . ' product categories.');
    }
}