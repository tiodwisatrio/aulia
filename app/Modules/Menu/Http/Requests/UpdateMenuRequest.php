<?php

namespace App\Modules\Menu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Gate checks in controller
    }

    public function rules(): array
    {
        $menuId = $this->route('menu')?->id;

        return [
            'menu_nama'         => ['required', 'string', 'max:255'],
            'menu_slug'         => ['nullable', 'string', 'max:255', Rule::unique('menus', 'menu_slug')->ignore($menuId, 'menu_id')],
            'menu_deskripsi'    => ['nullable', 'string'],
            'menu_kategori_id'  => ['required', Rule::exists('kategori', 'kategori_id')],
            'menu_image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'menu_harga'        => ['nullable', 'numeric', 'min:0'],
            'menu_status'       => ['required', 'in:aktif,tidak aktif'],
        ];
    }

    public function messages(): array
    {
        return [
            'menu_nama.required'        => 'Nama menu harus diisi',
            'menu_nama.max'             => 'Nama menu maksimal 255 karakter',
            'menu_kategori_id.required' => 'Kategori harus dipilih',
            'menu_kategori_id.exists'   => 'Kategori tidak valid',
            'menu_status.required'      => 'Status harus dipilih',
            'menu_status.in'            => 'Status harus: aktif atau tidak aktif',
            'menu_image.image'          => 'File harus berupa gambar',
            'menu_image.mimes'          => 'Gambar harus format: jpeg, png, jpg, gif, webp',
            'menu_image.max'            => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
