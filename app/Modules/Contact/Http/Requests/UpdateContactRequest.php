<?php

namespace App\Modules\Contact\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Gate checks in controller
    }

    public function rules(): array
    {
        $postId = $this->route('contact')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', Rule::unique('posts')->ignore($postId)],
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
            'title.required' => 'Judul contact harus diisi',
            'title.max' => 'Judul contact maksimal 255 karakter',
            'content.required' => 'Konten contact harus diisi',
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
