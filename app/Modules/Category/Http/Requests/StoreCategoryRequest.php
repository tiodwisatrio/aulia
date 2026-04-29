<?php

namespace App\Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Gate checks in controller
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'unique:categories'],
            'content' => ['required', 'string'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', 'in:active,draft,archived'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul category harus diisi',
            'title.max' => 'Judul category maksimal 255 karakter',
            'content.required' => 'Konten category harus diisi',
            'category_id.required' => 'Kategori harus dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status harus: active, draft, atau archived',
            'featured_image.image' => 'File harus berupa gambar',
            'featured_image.mimes' => 'Gambar harus format: jpeg, png, jpg, gif',
            'featured_image.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
