<?php

namespace App\Modules\Post\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Modules\Post\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
                     ->where('posts_status', 'aktif')
                     ->latest();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('posts_judul', 'like', '%' . $request->search . '%')
                  ->orWhere('posts_konten', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('posts_kategori_id', $request->category);
        }

        $posts = $query->paginate(9);

        // Get all categories that have active posts
        $categories = \App\Modules\Category\Models\Category::whereHas('posts', function($query) {
            $query->where('posts_status', 'aktif');
        })->where('kategori_tipe', 'post')->get();

        return view('post::frontend.index', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        $post->load(['user', 'category']);

        // Get related posts dari kategori yang sama
        $relatedPosts = Post::with(['user', 'category'])
                           ->where('posts_kategori_id', $post->posts_kategori_id)
                           ->where('posts_id', '!=', $post->posts_id)
                           ->where('posts_status', 'aktif')
                           ->latest()
                           ->limit(3)
                           ->get();

        return view('post::frontend.show', compact('post', 'relatedPosts'));
    }
}