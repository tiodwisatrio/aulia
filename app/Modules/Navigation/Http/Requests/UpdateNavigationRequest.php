<?php

namespace App\Modules\Navigation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNavigationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'menu_label'  => ['required', 'string', 'max:255'],
            'menu_route'  => ['nullable', 'string', 'max:255'],
            'menu_ikon'   => ['nullable', 'string', 'max:255'],
            'menu_status' => ['required', 'boolean'],
            'orders'      => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'menu_label.required' => 'Label menu harus diisi',
            'menu_label.max'      => 'Label menu maksimal 255 karakter',
        ];
    }
}
