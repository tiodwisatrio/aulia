<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Product\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::where('produk_status', 'aktif')
            ->select('produk_slug', 'updated_at')
            ->latest('updated_at')
            ->get();

        $staticPages = [
            ['loc' => url('/'),                         'changefreq' => 'weekly',  'priority' => '1.0'],
            ['loc' => route('frontend.products.index'), 'changefreq' => 'weekly',  'priority' => '0.9'],
            ['loc' => route('frontend.reels.index'),    'changefreq' => 'weekly',  'priority' => '0.7'],
            ['loc' => route('frontend.abouts.index'),   'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => route('frontend.contacts.index'), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ];

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');

        foreach ($staticPages as $page) {
            $url = $xml->addChild('url');
            $url->addChild('loc', $page['loc']);
            $url->addChild('changefreq', $page['changefreq']);
            $url->addChild('priority', $page['priority']);
        }

        foreach ($products as $product) {
            $url = $xml->addChild('url');
            $url->addChild('loc', route('frontend.products.show', $product->produk_slug));
            $url->addChild('lastmod', $product->updated_at->toAtomString());
            $url->addChild('changefreq', 'weekly');
            $url->addChild('priority', '0.8');
        }

        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Disallow: /dashboard/\n";
        $content .= "Disallow: /dashboard\n";
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /register\n";
        $content .= "Disallow: /password/\n";
        $content .= "Disallow: /email/\n";
        $content .= "\n";
        $content .= "Sitemap: " . route('sitemap') . "\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
