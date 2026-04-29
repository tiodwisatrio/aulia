<?php

namespace App\Modules\Navigation\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Navigation\Models\Post;

class NavigationController extends Controller
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

        return view('post::frontend.show', compact('navigation'));
    }
}
