<?php

namespace App\Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Gate checks in controller
    }

    public function rules(): array
    {
        return [
            'produk_nama'         => ['required', 'string', 'max:255'],
            'produk_slug'         => ['nullable', 'string', 'max:255', Rule::unique('produk', 'produk_slug')],
            'produk_deskripsi'    => ['nullable', 'string'],
            'produk_kategori_id'  => ['required', Rule::exists('kategori', 'kategori_id')],
            'produk_gambar_utama' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'produk_harga'        => ['nullable', 'numeric', 'min:0'],
            'produk_harga_diskon' => ['nullable', 'numeric', 'min:0'],
            'produk_sku'          => ['nullable', 'string', 'max:100'],
            'produk_stok'         => ['nullable', 'integer', 'min:0'],
            'produk_stok_minimum' => ['nullable', 'integer', 'min:0'],
            'produk_ukuran'       => ['nullable', 'integer', 'min:0'],
            'produk_origin'           => ['nullable', 'string', 'max:255'],
            'produk_ketinggian'       => ['nullable', 'string', 'max:255'],
            'produk_profile_roasting' => ['nullable', 'string', 'max:255'],
            'produk_varietas'         => ['nullable', 'string', 'max:255'],
            'produk_process'          => ['nullable', 'string', 'max:100'],
            'produk_roast_date'       => ['nullable', 'date'],
            'produk_status'       => ['required', 'in:aktif,nonaktif'],
            'produk_unggulan'     => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'produk_nama.required'        => 'Nama produk harus diisi',
            'produk_nama.max'             => 'Nama produk maksimal 255 karakter',
            'produk_kategori_id.required' => 'Kategori harus dipilih',
            'produk_kategori_id.exists'   => 'Kategori tidak valid',
            'produk_status.required'      => 'Status harus dipilih',
            'produk_status.in'            => 'Status harus: aktif atau nonaktif',
            'produk_gambar_utama.image'   => 'File harus berupa gambar',
            'produk_gambar_utama.mimes'   => 'Gambar harus format: jpeg, png, jpg, gif, webp',
            'produk_gambar_utama.max'     => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
