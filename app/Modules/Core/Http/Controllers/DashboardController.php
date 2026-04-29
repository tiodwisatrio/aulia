<?php

namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\About\Models\About;
use App\Modules\Post\Models\Post;
use App\Modules\Product\Models\Product;
use App\Modules\Service\Models\Service;
use App\Modules\Team\Models\Team;
use App\Modules\Testimonial\Models\Testimonial;
use App\Modules\OurClient\Models\OurClient;
use App\Modules\Hero\Models\Hero;
use App\Modules\Reel\Models\Reel;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function home(): View
    {
        $heros            = Hero::where('hero_status', 1)->latest()->get();
        $abouts           = About::where('tentang_status', 1)->latest()->get();
        $latestPosts      = Post::where('posts_status', 'aktif')->latest()->limit(3)->get();
        $featuredProducts = Product::where('produk_status', 'aktif')->latest()->limit(4)->get();
        $services         = Service::where('layanan_status', 1)->orderBy('layanan_urutan')->get();
        $teams            = Team::where('tim_status', 1)->latest()->get();
        $testimonials     = Testimonial::where('testimoni_status', 1)->latest()->get();
        $ourClients       = OurClient::where('klien_status', 1)->latest()->get();
        $reels            = Reel::where('reel_status', 1)->latest()->limit(3)->get();

        return view('core::home', compact(
            'heros',
            'abouts',
            'latestPosts',
            'featuredProducts',
            'services',
            'teams',
            'testimonials',
            'ourClients',
            'reels'
        ));
    }

    public function index(): View
    {
        return view('core::dashboard', []);
    }
}
