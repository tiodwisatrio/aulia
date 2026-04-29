<?php

namespace App\Modules\Post\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Post\Models\Post;
use App\Modules\Category\Models\Category;
use App\Modules\Post\Http\Requests\StorePostRequest;
use App\Modules\Post\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'user']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('posts_judul', 'like', '%' . $request->search . '%')
                  ->orWhere('posts_konten', 'like', '%' . $request->search . '%')
                  ->orWhere('posts_deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('posts_kategori_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('posts_status', $request->status);
        }

        if ($request->filled('featured')) {
            $query->where('posts_unggulan', $request->featured);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::forPosts()->active()->ordered()->get();

        return view('post::backend.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::forPosts()->active()->ordered()->get();

        return view('post::backend.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('posts_gambar_utama')) {
            $validated['posts_gambar_utama'] = $request->file('posts_gambar_utama')
                ->store('posts/images', 'public');
        }

        $validated['posts_pengguna_id'] = Auth::id();

        $post = Post::create($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post berhasil dibuat!');
    }

    public function show(Post $post)
    {
        $post->load(['category', 'user']);

        $post->increment('posts_jumlah_lihat');

        return view('post::backend.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::forPosts()->active()->ordered()->get();

        return view('post::backend.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        if ($request->has('remove_current_image') && $post->posts_gambar_utama) {
            Storage::disk('public')->delete($post->posts_gambar_utama);
            $validated['posts_gambar_utama'] = null;
        }

        if ($request->hasFile('posts_gambar_utama')) {
            if ($post->posts_gambar_utama) {
                Storage::disk('public')->delete($post->posts_gambar_utama);
            }
            $validated['posts_gambar_utama'] = $request->file('posts_gambar_utama')
                ->store('posts/images', 'public');
        }

        $post->update($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        if ($post->posts_gambar_utama) {
            Storage::disk('public')->delete($post->posts_gambar_utama);
        }

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post berhasil dihapus!');
    }
}
