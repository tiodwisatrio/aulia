<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get post categories and admin user
        $categories = Category::forPosts()->active()->get();
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $admin = User::first(); // Fallback to first user if no admin
        }

        // Sample posts data
        $posts = [
            [
                'title' => '10 Tips Menjaga Kesehatan Mental di Era Digital',
                'content' => 'Di era digital seperti sekarang, kesehatan mental menjadi hal yang sangat penting untuk dijaga. Paparan teknologi yang berlebihan dapat mempengaruhi kondisi psikologis kita. Berikut adalah beberapa tips yang dapat membantu menjaga kesehatan mental: 1. Batasi waktu screen time, 2. Lakukan digital detox secara berkala, 3. Aktif bersosialisasi secara offline, 4. Rutin berolahraga dan meditasi, 5. Jaga pola tidur yang teratur.',
                'description' => 'Tips praktis untuk menjaga kesehatan mental di tengah perkembangan teknologi digital yang pesat.',
                'status' => 'active',
                'is_featured' => true,
                'publish_date' => Carbon::now()->subDays(7),
                'category_type' => 'Kesehatan',
            ],
            [
                'title' => 'Revolusi Pembelajaran Online: Tren Pendidikan 2025',
                'content' => 'Pendidikan online telah mengalami perkembangan pesat, terutama setelah pandemi. Tahun 2025 menandai era baru dalam dunia pendidikan dengan berbagai inovasi teknologi. Platform pembelajaran adaptif, virtual reality dalam kelas, dan AI tutor personal menjadi trend utama. Institusi pendidikan mulai mengadopsi hybrid learning sebagai model standar.',
                'description' => 'Analisis mendalam tentang tren dan inovasi terbaru dalam dunia pendidikan online di tahun 2025.',
                'status' => 'active',
                'is_featured' => true,
                'publish_date' => Carbon::now()->subDays(5),
                'category_type' => 'Pendidikan',
            ],
            [
                'title' => 'Artificial Intelligence: Masa Depan Teknologi yang Mengubah Dunia',
                'content' => 'Kecerdasan Buatan (AI) telah menjadi teknologi yang paling transformatif di abad ini. Dari asisten virtual hingga autonomous vehicles, AI terus berkembang dan mengintegrasikan diri dalam kehidupan sehari-hari. Machine learning, deep learning, dan neural networks menjadi fondasi pengembangan AI modern. Dampaknya terasa di berbagai sektor: healthcare, finance, education, dan manufacturing.',
                'description' => 'Eksplorasi komprehensif tentang perkembangan AI dan dampaknya terhadap berbagai aspek kehidupan manusia.',
                'status' => 'active',
                'is_featured' => true,
                'publish_date' => Carbon::now()->subDays(3),
                'category_type' => 'Teknologi',
            ],
            [
                'title' => 'Minimalist Living: Gaya Hidup Sederhana untuk Kehidupan Bahagia',
                'content' => 'Minimalism bukan sekedar tentang memiliki barang yang sedikit, tapi tentang memiliki barang yang benar-benar bermakna. Gaya hidup minimalis mengajarkan kita untuk fokus pada hal-hal yang truly matter. Decluttering tidak hanya berlaku pada barang fisik, tapi juga digital clutter dan mental clutter. Dengan hidup minimalis, kita bisa lebih fokus, produktif, dan bahagia.',
                'description' => 'Panduan lengkap menerapkan gaya hidup minimalis untuk mencapai kebahagiaan dan ketenangan hidup.',
                'status' => 'active',
                'is_featured' => false,
                'publish_date' => Carbon::now()->subDays(10),
                'category_type' => 'Lifestyle',
            ],
            [
                'title' => 'Startup Indonesia: Ekosistem Bisnis Digital yang Berkembang Pesat',
                'content' => 'Indonesia telah menjadi salah satu negara dengan pertumbuhan startup tercepat di Asia Tenggara. Dengan populasi digital yang besar dan penetrasi internet yang terus meningkat, peluang bisnis digital sangat terbuka lebar. Dari fintech, e-commerce, hingga edtech, berbagai sektor mengalami inovasi berkelanjutan. Dukungan pemerintah dan investor lokal maupun internasional semakin memperkuat ekosistem startup Indonesia.',
                'description' => 'Overview lengkap tentang perkembangan ekosistem startup dan bisnis digital di Indonesia.',
                'status' => 'active',
                'is_featured' => true,
                'publish_date' => Carbon::now()->subDays(1),
                'category_type' => 'Bisnis',
            ],
            [
                'title' => 'Home Workout: Panduan Olahraga Efektif di Rumah',
                'content' => 'Tidak perlu gym yang mahal untuk tetap sehat dan bugar. Olahraga di rumah bisa sama efektifnya dengan proper planning dan consistency. Bodyweight exercises seperti push-up, squat, dan plank bisa dilakukan tanpa peralatan. Untuk yang ingin lebih intense, resistance band dan dumbbell sederhana sudah cukup untuk full-body workout. Yang terpenting adalah konsistensi dan progressive overload.',
                'description' => 'Tips dan panduan lengkap untuk melakukan workout efektif di rumah tanpa peralatan mahal.',
                'status' => 'active',
                'is_featured' => false,
                'publish_date' => Carbon::now()->subDays(12),
                'category_type' => 'Olahraga',
            ],
            [
                'title' => 'Street Food Jakarta: Wisata Kuliner yang Tak Boleh Dilewatkan',
                'content' => 'Jakarta adalah surga kuliner street food dengan ribuan pilihan makanan dari berbagai daerah. Mulai dari kerak telor khas Betawi, gado-gado, sampai martabak manis, setiap sudut kota menawarkan cita rasa yang unik. Food truck dan pedagang kaki lima menjadi bagian integral dari budaya kuliner Jakarta. Panduan lengkap lokasi terbaik dan rekomendasi must-try dishes untuk food enthusiast.',
                'description' => 'Panduan wisata kuliner street food Jakarta dengan rekomendasi lokasi dan makanan terbaik.',
                'status' => 'active',
                'is_featured' => false,
                'publish_date' => Carbon::now()->subDays(8),
                'category_type' => 'Kuliner',
            ],
            [
                'title' => 'Bali Hidden Gems: Destinasi Tersembunyi yang Wajib Dikunjungi',
                'content' => 'Selain Kuta dan Ubud yang sudah mainstream, Bali menyimpan banyak destinasi tersembunyi yang tidak kalah memukau. Sekumpang Waterfall di Sekumpul, Blue Lagoon di Nusa Ceningan, dan Taman Ujung di Karangasem adalah beberapa hidden gems yang masih belum terlalu crowded. Tempat-tempat ini menawarkan pengalaman autentik Bali yang berbeda dari tourist trap pada umumnya.',
                'description' => 'Eksplorasi destinasi-destinasi tersembunyi di Bali yang menawarkan keindahan alami dan pengalaman autentik.',
                'status' => 'active',
                'is_featured' => true,
                'publish_date' => Carbon::now()->subDays(2),
                'category_type' => 'Travel',
            ],
            [
                'title' => 'Marvel vs DC: Analisis Perbandingan Dua Raksasa Industri Superhero',
                'content' => 'Persaingan Marvel dan DC Comics telah berlangsung puluhan tahun dan kini meluas ke layar lebar. Marvel Cinematic Universe (MCU) telah menciptakan connected universe yang sangat sukses, sementara DC mencoba approach yang berbeda dengan tone yang lebih gelap. Dari segi karakter, storytelling, hingga box office performance, kedua studio memiliki kelebihan dan kekurangan masing-masing. Analisis mendalam tentang strategi dan pencapaian keduanya.',
                'description' => 'Perbandingan komprehensif antara Marvel dan DC dari berbagai aspek: karakter, film, dan strategi bisnis.',
                'status' => 'active',
                'is_featured' => false,
                'publish_date' => Carbon::now()->subDays(15),
                'category_type' => 'Entertainment',
            ],
            [
                'title' => 'Electric Vehicle Indonesia: Masa Depan Transportasi Ramah Lingkungan',
                'content' => 'Indonesia sedang bersiap menghadapi era kendaraan listrik dengan berbagai inisiatif pemerintah dan swasta. Dari mobil listrik seperti Hyundai IONIQ hingga motor listrik seperti Gesits, pilihan kendaraan ramah lingkungan semakin beragam. Infrastructure charging station mulai dikembangkan di kota-kota besar. Tantangan terbesar adalah harga, range anxiety, dan kesiapan infrastruktur pendukung.',
                'description' => 'Overview lengkap tentang perkembangan kendaraan listrik di Indonesia dan tantangan implementasinya.',
                'status' => 'active',
                'is_featured' => false,
                'publish_date' => Carbon::now()->subDays(6),
                'category_type' => 'Otomotif',
            ]
        ];

        // Create posts
        foreach ($posts as $postData) {
            // Generate slug from title
            $postData['slug'] = Str::slug($postData['title']);
            
            // Find category by name/type
            $category = $categories->where('name', $postData['category_type'])->first();
            $postData['category_id'] = $category ? $category->id : $categories->first()->id;
            
            // Remove category_type as it's not a database field
            unset($postData['category_type']);
            
            // Assign admin user
            $postData['user_id'] = $admin->id;

            Post::create($postData);
        }

        // Update view_count with random values for some realism
        Post::all()->each(function ($post) {
            $post->update([
                'view_count' => rand(100, 5000),
            ]);
        });

        $this->command->info('✅ PostSeeder completed! Created ' . count($posts) . ' sample posts.');
    }
}