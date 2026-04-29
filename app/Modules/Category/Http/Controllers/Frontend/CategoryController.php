<?php

namespace App\Modules\Category\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Category\Models\Post;

class CategoryController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 1)
            ->with(['user', 'category'])
            ->latest()
            ->paginate(10);

        return view('post::frontend.index', compact('posts'));
    }

    public function show(Post $post)
    {
        if ($post->status !== 1) {
            abort(404);
        }

        return view('post::frontend.show', compact('category'));
    }
}
