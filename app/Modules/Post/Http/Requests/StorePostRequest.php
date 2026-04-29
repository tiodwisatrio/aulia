<?php

namespace App\Modules\Post\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'posts_judul'        => ['required', 'string', 'max:255'],
            'posts_slug'         => ['nullable', 'string', 'max:255', 'unique:posts,posts_slug'],
            'posts_konten'       => ['required', 'string', 'min:10'],
            'posts_deskripsi'    => ['nullable', 'string', 'max:1000'],
            'posts_kategori_id'  => [
                'required',
                Rule::exists('kategori', 'kategori_id')->where(fn($q) =>
                    $q->where('kategori_tipe', 'post')->where('kategori_aktif', true)
                ),
            ],
            'posts_gambar_utama' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'posts_status'       => ['required', 'in:aktif,nonaktif'],
            'posts_unggulan'     => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'posts_judul.required'       => 'Judul artikel wajib diisi.',
            'posts_konten.required'      => 'Konten artikel wajib diisi.',
            'posts_konten.min'           => 'Konten terlalu pendek (min 10 karakter).',
            'posts_kategori_id.required' => 'Kategori artikel wajib dipilih.',
            'posts_kategori_id.exists'   => 'Kategori tidak valid atau tidak aktif.',
            'posts_gambar_utama.image'   => 'File harus berformat gambar.',
            'posts_status.required'      => 'Status artikel wajib dipilih.',
        ];
    }
}
