<?php

namespace App\Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'site_name'        => ['nullable', 'string', 'max:255'],
            'site_name_alt'    => ['nullable', 'string', 'max:255'],
            'site_address'     => ['nullable', 'string'],
            'site_phone'       => ['nullable', 'string', 'max:50'],
            'site_fax'         => ['nullable', 'string', 'max:50'],
            'site_mobile'      => ['nullable', 'string', 'max:50'],
            'site_email'       => ['nullable', 'email', 'max:255'],
            'site_whatsapp'    => ['nullable', 'string', 'max:50'],
            'site_instagram'   => ['nullable', 'string', 'max:255'],
            'site_youtube'     => ['nullable', 'string', 'max:255'],
            'site_tiktok'      => ['nullable', 'string', 'max:255'],
            'site_twitter'     => ['nullable', 'string', 'max:255'],
            'site_map'         => ['nullable', 'string'],
            'site_description' => ['nullable', 'string'],
            'site_logo'        => ['nullable', 'file', 'image', 'max:2048'],
            'site_logo_dark'   => ['nullable', 'file', 'image', 'max:2048'],
            'site_icon'        => ['nullable', 'file', 'mimes:png,ico,svg', 'max:512'],
        ];
    }
}
