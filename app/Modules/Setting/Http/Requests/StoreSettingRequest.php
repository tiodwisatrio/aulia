<?php

namespace App\Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Gate checks in controller
    }

    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:255', 'unique:settings'],
            'label' => ['nullable', 'string', 'max:255'],
            'value' => ['required', 'string'],
            'type' => ['required', 'in:text,number,boolean,file'],
            'group' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'key.required' => 'Key setting harus diisi',
            'key.max' => 'Key setting maksimal 255 karakter',
            'key.unique' => 'Key setting sudah ada',
            'value.required' => 'Nilai setting harus diisi',
            'type.required' => 'Tipe setting harus dipilih',
            'type.in' => 'Tipe setting harus: text, number, boolean, atau file',
            'group.required' => 'Grup setting harus diisi',
        ];
    }
}
