<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Post Categories
        $postCategories = [
            [
                'name' => 'Kesehatan',
                'type' => 'post',
                'description' => 'Informasi kesehatan, tips hidup sehat, dan berita medis terkini',
                'color' => '#EF4444',
                'icon' => 'fas fa-heart-pulse',
                'sort_order' => 1
            ],
            [
                'name' => 'Pendidikan',
                'type' => 'post',
                'description' => 'Artikel pendidikan, tips belajar, dan informasi akademik',
                'color' => '#3B82F6',
                'icon' => 'fas fa-graduation-cap',
                'sort_order' => 2
            ],
            [
                'name' => 'Politik',
                'type' => 'post',
                'description' => 'Berita politik, analisis kebijakan, dan isu pemerintahan',
                'color' => '#DC2626',
                'icon' => 'fas fa-landmark',
                'sort_order' => 3
            ],
            [
                'name' => 'Ekonomi',
                'type' => 'post',
                'description' => 'Berita ekonomi, bisnis, investasi, dan keuangan',
                'color' => '#059669',
                'icon' => 'fas fa-chart-line',
                'sort_order' => 4
            ],
            [
                'name' => 'Teknologi',
                'type' => 'post',
                'description' => 'Perkembangan teknologi, gadget, dan inovasi digital',
                'color' => '#7C3AED',
                'icon' => 'fas fa-microchip',
                'sort_order' => 5
            ],
            [
                'name' => 'Olahraga',
                'type' => 'post',
                'description' => 'Berita olahraga, hasil pertandingan, dan profil atlet',
                'color' => '#F59E0B',
                'icon' => 'fas fa-trophy',
                'sort_order' => 6
            ],
            [
                'name' => 'Hiburan',
                'type' => 'post',
                'description' => 'Berita hiburan, selebriti, film, dan musik',
                'color' => '#EC4899',
                'icon' => 'fas fa-masks-theater',
                'sort_order' => 7
            ],
            [
                'name' => 'Travel',
                'type' => 'post',
                'description' => 'Tips perjalanan, destinasi wisata, dan panduan traveling',
                'color' => '#06B6D4',
                'icon' => 'fas fa-plane',
                'sort_order' => 8
            ],
            [
                'name' => 'Kuliner',
                'type' => 'post',
                'description' => 'Resep masakan, review makanan, dan tips kuliner',
                'color' => '#F97316',
                'icon' => 'fas fa-utensils',
                'sort_order' => 9
            ],
            [
                'name' => 'Gaya Hidup',
                'type' => 'post',
                'description' => 'Fashion, kecantikan, dan trend gaya hidup terkini',
                'color' => '#8B5CF6',
                'icon' => 'fas fa-star',
                'sort_order' => 10
            ],
            [
                'name' => 'Agama',
                'type' => 'post',
                'description' => 'Artikel keagamaan, kajian spiritual, dan nilai-nilai moral',
                'color' => '#10B981',
                'icon' => 'fas fa-mosque',
                'sort_order' => 11
            ],
            [
                'name' => 'Hukum',
                'type' => 'post',
                'description' => 'Berita hukum, analisis peraturan, dan isu keadilan',
                'color' => '#374151',
                'icon' => 'fas fa-balance-scale',
                'sort_order' => 12
            ]
        ];

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

        // Create all categories
        $allCategories = array_merge($postCategories, $productCategories);
        
        foreach ($allCategories as $category) {
            Category::create($category);
        }
    }
}