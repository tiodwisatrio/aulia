<?php

namespace App\Modules\Post\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Gate checks in controller
    }

    public function rules(): array
    {
        $postId = $this->route('post')?->posts_id;

        return [
            'posts_judul'        => ['required', 'string', 'max:255'],
            'posts_slug'         => ['nullable', 'string', 'max:255', Rule::unique('posts', 'posts_slug')->ignore($postId, 'posts_id')],
            'posts_konten'       => ['required', 'string', 'min:10'],
            'posts_deskripsi'    => ['nullable', 'string', 'max:1000'],
            'posts_kategori_id'  => ['required', Rule::exists('kategori', 'kategori_id')],
            'posts_gambar_utama' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'posts_status'       => ['required', 'in:aktif,nonaktif'],
            'posts_unggulan'     => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'posts_judul.required'       => 'Judul post harus diisi',
            'posts_judul.max'            => 'Judul post maksimal 255 karakter',
            'posts_konten.required'      => 'Konten post harus diisi',
            'posts_konten.min'           => 'Konten post minimal 10 karakter',
            'posts_kategori_id.required' => 'Kategori harus dipilih',
            'posts_kategori_id.exists'   => 'Kategori tidak valid',
            'posts_status.required'      => 'Status harus dipilih',
            'posts_status.in'            => 'Status harus: aktif atau nonaktif',
            'posts_gambar_utama.image'   => 'File harus berupa gambar',
            'posts_gambar_utama.mimes'   => 'Gambar harus format: jpeg, png, jpg, gif, webp',
            'posts_gambar_utama.max'     => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
