<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Modules\About\Models\About;
use App\Modules\Hero\Models\Hero;
use App\Modules\Post\Models\Post;
use App\Modules\Product\Models\Product;
use App\Modules\Service\Models\Service;
use App\Modules\Team\Models\Team;
use App\Modules\Testimonial\Models\Testimonial;
use App\Modules\OurClient\Models\OurClient;
use App\Modules\Reel\Models\Reel;
use App\Modules\User\Models\User;
use App\Modules\Menu\Models\Menu;
use App\Modules\Category\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $stats = [
            'heros' => 1, // Karena biasanya hanya ada 1 hero yang aktif
            'posts' => Post::where('status', 'active')->count(),
            'products' => Product::where('status', 'active')->count(),
            'users' => User::count(),
            'abouts'=>About::where('status', 'active')->get(),
            'services'=>Service::where('status', 1)->get(),
            'ourclients'=>OurClient::where('status', 1)->get(),
            'testimonials'=>Testimonial::where('status', 1)->get(),
        ];

        $heros = Hero::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();


        $abouts = About::where('tentang_status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        // Buatkan untuk menampilkan team beserta divisinya
       $teams = Team::with('category')
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->get();

        $services = Service::where('status', 1)->orderBy('order')->get();

        $ourClients = OurClient::where('status', 1)
            ->orderBy('order', 'asc')
            ->get();

        $testimonials = Testimonial::where('status', 1)
            ->orderBy('order', 'asc')
            ->get();

        $latestPosts = Post::with(['category', 'user'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $featuredProducts = Product::with('category')
            ->where('produk_status', 'aktif')
            ->where('produk_unggulan', true)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $reels = Reel::where('reel_status', 1)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $menuCategories = Category::with(['menus' => function ($q) {
                $q->where('menu_status', 'aktif')->orderBy('id');
            }])
            ->where('kategori_tipe', 'menu')
            ->where('kategori_aktif', true)
            ->orderBy('kategori_urutan')
            ->get()
            ->filter(fn($c) => $c->menus->count() > 0);

        return view('frontend.pages.home', compact('stats', 'heros', 'latestPosts', 'featuredProducts', 'abouts', 'services', 'ourClients', 'testimonials', 'teams', 'reels', 'menuCategories'));
    }
}
