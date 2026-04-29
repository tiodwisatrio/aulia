<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postCategories = [
            [
                'name' => 'Kesehatan',
                'description' => 'Artikel tentang kesehatan, tips hidup sehat, dan informasi medis',
                'color' => '#10B981', // Green
                'icon' => 'fas fa-heartbeat',
            ],
            [
                'name' => 'Pendidikan',
                'description' => 'Artikel tentang dunia pendidikan, tips belajar, dan perkembangan edukasi',
                'color' => '#3B82F6', // Blue
                'icon' => 'fas fa-graduation-cap',
            ],
            [
                'name' => 'Teknologi',
                'description' => 'Berita dan artikel tentang perkembangan teknologi terbaru',
                'color' => '#8B5CF6', // Purple
                'icon' => 'fas fa-microchip',
            ],
            [
                'name' => 'Lifestyle',
                'description' => 'Tips dan artikel tentang gaya hidup, fashion, dan trend terkini',
                'color' => '#EC4899', // Pink
                'icon' => 'fas fa-coffee',
            ],
            [
                'name' => 'Bisnis',
                'description' => 'Artikel tentang dunia bisnis, entrepreneurship, dan tips keuangan',
                'color' => '#F59E0B', // Amber
                'icon' => 'fas fa-briefcase',
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Berita olahraga, tips fitness, dan informasi aktivitas fisik',
                'color' => '#EF4444', // Red
                'icon' => 'fas fa-running',
            ],
            [
                'name' => 'Kuliner',
                'description' => 'Review makanan, resep, dan tips kuliner',
                'color' => '#F97316', // Orange
                'icon' => 'fas fa-utensils',
            ],
            [
                'name' => 'Travel',
                'description' => 'Tips perjalanan, review destinasi, dan panduan wisata',
                'color' => '#06B6D4', // Cyan
                'icon' => 'fas fa-plane',
            ],
            [
                'name' => 'Entertainment',
                'description' => 'Berita hiburan, review film, musik, dan industri kreatif',
                'color' => '#8B5CF6', // Violet
                'icon' => 'fas fa-film',
            ],
            [
                'name' => 'Otomotif',
                'description' => 'Review kendaraan, tips perawatan, dan perkembangan otomotif',
                'color' => '#6B7280', // Gray
                'icon' => 'fas fa-car',
            ]
        ];

        foreach ($postCategories as $categoryData) {
            // Generate slug from name
            $categoryData['slug'] = Str::slug($categoryData['name']);
            
            // Set type as 'post'
            $categoryData['type'] = 'post';
            
            // Set default status
            $categoryData['is_active'] = true;
            
            // Set sort order
            $categoryData['sort_order'] = Category::where('type', 'post')->count() + 1;

            Category::create($categoryData);
        }

        $this->command->info('✅ PostCategorySeeder completed! Created ' . count($postCategories) . ' post categories.');
    }
}