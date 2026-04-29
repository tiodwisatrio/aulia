<?php

/**
 * Reusable Form Component Functions
 *
 * Functions to generate form fields with consistent styling
 */

/**
 * Generate text input field
 */
if (!function_exists('formInput')) {
    function formInput($name, $label = null, $value = null, $attributes = [])
    {
        $attributes = array_merge([
            'type' => 'text',
            'placeholder' => '',
            'required' => false,
        ], $attributes);

        $required = $attributes['required'] ? '<span class="text-red-600">*</span>' : '';
        $requiredAttr = $attributes['required'] ? 'required' : '';
        $hasError = session('errors')?->has($name);
        $errorClass = $hasError ? 'border-red-500' : 'border-gray-300';

        $html = '<div>';
        if ($label) {
            $html .= '<label class="block text-sm font-semibold text-gray-900 mb-2">' . $label . ' ' . $required . '</label>';
        }
        $html .= '<input type="' . htmlspecialchars($attributes['type'], ENT_QUOTES, 'UTF-8') . '" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars(old($name, $value ?? ''), ENT_QUOTES, 'UTF-8') . '" ' . $requiredAttr . '
                    class="w-full px-4 py-2 border ' . $errorClass . ' rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                    placeholder="' . htmlspecialchars($attributes['placeholder'], ENT_QUOTES, 'UTF-8') . '">';
        if ($hasError) {
            $html .= '<p class="text-red-600 text-sm mt-1">' . htmlspecialchars(session('errors')->first($name), ENT_QUOTES, 'UTF-8') . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}

/**
 * Generate textarea field
 */
if (!function_exists('formTextarea')) {
    function formTextarea($name, $label = null, $value = null, $attributes = [])
    {
        $attributes = array_merge([
            'rows' => 5,
            'placeholder' => '',
            'required' => false,
        ], $attributes);

        $required = $attributes['required'] ? '<span class="text-red-600">*</span>' : '';
        $requiredAttr = $attributes['required'] ? 'required' : '';
        $hasError = session('errors')?->has($name);
        $errorClass = $hasError ? 'border-red-500' : 'border-gray-300';

        $html = '<div>';
        if ($label) {
            $html .= '<label class="block text-sm font-semibold text-gray-900 mb-2">' . $label . ' ' . $required . '</label>';
        }
        $html .= '<textarea name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" rows="' . intval($attributes['rows']) . '" ' . $requiredAttr . '
                    class="w-full px-4 py-2 border ' . $errorClass . ' rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                    placeholder="' . htmlspecialchars($attributes['placeholder'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars(old($name, $value ?? ''), ENT_QUOTES, 'UTF-8') . '</textarea>';
        if ($hasError) {
            $html .= '<p class="text-red-600 text-sm mt-1">' . htmlspecialchars(session('errors')->first($name), ENT_QUOTES, 'UTF-8') . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}

/**
 * Generate CKEditor field
 */
if (!function_exists('formCKEditor')) {
    function formCKEditor($name, $label = null, $value = null, $attributes = [])
    {
        $attributes = array_merge([
            'placeholder' => '',
            'required' => false,
        ], $attributes);

        $required = $attributes['required'] ? '<span class="text-red-600">*</span>' : '';
        $requiredAttr = $attributes['required'] ? 'required' : '';
        $hasError = session('errors')?->has($name);
        $errorClass = $hasError ? 'border-red-500' : 'border-gray-300';

        $html = '<div>';
        if ($label) {
            $html .= '<label class="block text-sm font-semibold text-gray-900 mb-2">' . $label . ' ' . $required . '</label>';
        }
        $html .= '<textarea id="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" ' . $requiredAttr . '
                    class="w-full px-4 py-2 border ' . $errorClass . ' rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">' . htmlspecialchars(old($name, $value ?? ''), ENT_QUOTES, 'UTF-8') . '</textarea>';
        if ($hasError) {
            $html .= '<p class="text-red-600 text-sm mt-1">' . htmlspecialchars(session('errors')->first($name), ENT_QUOTES, 'UTF-8') . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}

/**
 * Generate file input field
 */
if (!function_exists('formFile')) {
    function formFile($name, $label = null, $attributes = [])
    {
        $attributes = array_merge([
            'accept' => '*/*',
            'required' => false,
        ], $attributes);

        $required = $attributes['required'] ? '<span class="text-red-600">*</span>' : '';
        $requiredAttr = $attributes['required'] ? 'required' : '';
        $hasError = session('errors')?->has($name);
        $errorClass = $hasError ? 'border-red-500' : 'border-gray-300';

        $html = '<div>';
        if ($label) {
            $html .= '<label class="block text-sm font-semibold text-gray-900 mb-2">' . $label . ' ' . $required . '</label>';
        }
        $html .= '<input type="file" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" accept="' . htmlspecialchars($attributes['accept'], ENT_QUOTES, 'UTF-8') . '" ' . $requiredAttr . '
                    class="w-full px-4 py-2 border ' . $errorClass . ' rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">';
        if ($hasError) {
            $html .= '<p class="text-red-600 text-sm mt-1">' . htmlspecialchars(session('errors')->first($name), ENT_QUOTES, 'UTF-8') . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}

/**
 * Generate select/dropdown field
 */
if (!function_exists('formSelect')) {
    function formSelect($name, $label = null, $options = [], $value = null, $attributes = [])
    {
        $attributes = array_merge([
            'placeholder' => 'Pilih opsi',
            'required' => false,
        ], $attributes);

        $required = $attributes['required'] ? '<span class="text-red-600">*</span>' : '';
        $requiredAttr = $attributes['required'] ? 'required' : '';
        $hasError = session('errors')?->has($name);
        $errorClass = $hasError ? 'border-red-500' : 'border-gray-300';

        $html = '<div>';
        if ($label) {
            $html .= '<label class="block text-sm font-semibold text-gray-900 mb-2">' . $label . ' ' . $required . '</label>';
        }
        $html .= '<select name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" ' . $requiredAttr . '
                    class="w-full px-4 py-2 border ' . $errorClass . ' rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">' . htmlspecialchars($attributes['placeholder'], ENT_QUOTES, 'UTF-8') . '</option>';

        foreach ($options as $optValue => $optLabel) {
            $selected = old($name, $value) == $optValue ? 'selected' : '';
            $html .= '<option value="' . htmlspecialchars($optValue, ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($optLabel, ENT_QUOTES, 'UTF-8') . '</option>';
        }

        $html .= '</select>';
        if ($hasError) {
            $html .= '<p class="text-red-600 text-sm mt-1">' . htmlspecialchars(session('errors')->first($name), ENT_QUOTES, 'UTF-8') . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}

/**
 * Generate radio button group
 */
if (!function_exists('formRadio')) {
    function formRadio($name, $label = null, $options = [], $value = null, $attributes = [])
    {
        $required = isset($attributes['required']) && $attributes['required'] ? '<span class="text-red-600">*</span>' : '';

        $html = '<div>';
        if ($label) {
            $html .= '<label class="block text-sm font-semibold text-gray-900 mb-2">' . $label . ' ' . $required . '</label>';
        }
        $html .= '<div class="space-y-2">';

        foreach ($options as $optValue => $optLabel) {
            $checked = old($name, $value) == $optValue ? 'checked' : '';
            $html .= '<label class="flex items-center space-x-2">
                        <input type="radio" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars($optValue, ENT_QUOTES, 'UTF-8') . '" ' . $checked . '
                            class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500">
                        <span class="text-sm font-semibold text-gray-900">' . htmlspecialchars($optLabel, ENT_QUOTES, 'UTF-8') . '</span>
                    </label>';
        }

        $html .= '</div>';
        if (session('errors')?->has($name)) {
            $html .= '<p class="text-red-600 text-sm mt-1">' . htmlspecialchars(session('errors')->first($name), ENT_QUOTES, 'UTF-8') . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}

/**
 * Generate checkbox field
 */
if (!function_exists('formCheckbox')) {
    function formCheckbox($name, $label = null, $value = '1', $checked = false, $attributes = [])
    {
        $html = '<div>';
        $html .= '<label class="flex items-center space-x-2">
                    <input type="checkbox" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '" ' . (old($name, $checked) ? 'checked' : '') . '
                        class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500">
                    <span class="text-sm font-semibold text-gray-900">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</span>
                </label>';
        if (session('errors')?->has($name)) {
            $html .= '<p class="text-red-600 text-sm mt-1">' . htmlspecialchars(session('errors')->first($name), ENT_QUOTES, 'UTF-8') . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}

/**
 * Generate checkbox group
 */
if (!function_exists('formCheckboxGroup')) {
    function formCheckboxGroup($name, $label = null, $options = [], $values = [], $attributes = [])
    {
        $required = isset($attributes['required']) && $attributes['required'] ? '<span class="text-red-600">*</span>' : '';

        $html = '<div>';
        if ($label) {
            $html .= '<label class="block text-sm font-semibold text-gray-900 mb-2">' . $label . ' ' . $required . '</label>';
        }
        $html .= '<div class="space-y-2">';

        $oldValues = old($name, $values);
        foreach ($options as $optValue => $optLabel) {
            $checked = in_array($optValue, (array)$oldValues) ? 'checked' : '';
            $html .= '<label class="flex items-center space-x-2">
                        <input type="checkbox" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[]" value="' . htmlspecialchars($optValue, ENT_QUOTES, 'UTF-8') . '" ' . $checked . '
                            class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500">
                        <span class="text-sm font-semibold text-gray-900">' . htmlspecialchars($optLabel, ENT_QUOTES, 'UTF-8') . '</span>
                    </label>';
        }

        $html .= '</div>';
        if (session('errors')?->has($name)) {
            $html .= '<p class="text-red-600 text-sm mt-1">' . htmlspecialchars(session('errors')->first($name), ENT_QUOTES, 'UTF-8') . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}

/**
 * Generate date input field
 */
if (!function_exists('formDate')) {
    function formDate($name, $label = null, $value = null, $attributes = [])
    {
        $attributes = array_merge([
            'required' => false,
        ], $attributes);

        $required = $attributes['required'] ? '<span class="text-red-600">*</span>' : '';
        $requiredAttr = $attributes['required'] ? 'required' : '';
        $hasError = session('errors')?->has($name);
        $errorClass = $hasError ? 'border-red-500' : 'border-gray-300';

        $html = '<div>';
        if ($label) {
            $html .= '<label class="block text-sm font-semibold text-gray-900 mb-2">' . $label . ' ' . $required . '</label>';
        }
        $html .= '<input type="date" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars(old($name, $value ?? ''), ENT_QUOTES, 'UTF-8') . '" ' . $requiredAttr . '
                    class="w-full px-4 py-2 border ' . $errorClass . ' rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">';
        if ($hasError) {
            $html .= '<p class="text-red-600 text-sm mt-1">' . htmlspecialchars(session('errors')->first($name), ENT_QUOTES, 'UTF-8') . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}

/**
 * Generate number input field
 */
if (!function_exists('formNumber')) {
    function formNumber($name, $label = null, $value = null, $attributes = [])
    {
        $attributes = array_merge([
            'placeholder' => '',
            'step' => '1',
            'required' => false,
            'min' => null,
            'max' => null,
        ], $attributes);

        $required = $attributes['required'] ? '<span class="text-red-600">*</span>' : '';
        $requiredAttr = $attributes['required'] ? 'required' : '';
        $minAttr = $attributes['min'] !== null ? 'min="' . htmlspecialchars($attributes['min'], ENT_QUOTES, 'UTF-8') . '"' : '';
        $maxAttr = $attributes['max'] !== null ? 'max="' . htmlspecialchars($attributes['max'], ENT_QUOTES, 'UTF-8') . '"' : '';
        $hasError = session('errors')?->has($name);
        $errorClass = $hasError ? 'border-red-500' : 'border-gray-300';

        $html = '<div>';
        if ($label) {
            $html .= '<label class="block text-sm font-semibold text-gray-900 mb-2">' . $label . ' ' . $required . '</label>';
        }
        $html .= '<input type="number" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars(old($name, $value ?? ''), ENT_QUOTES, 'UTF-8') . '" step="' . htmlspecialchars($attributes['step'], ENT_QUOTES, 'UTF-8') . '" ' . $minAttr . ' ' . $maxAttr . ' ' . $requiredAttr . '
                    class="w-full px-4 py-2 border ' . $errorClass . ' rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                    placeholder="' . htmlspecialchars($attributes['placeholder'], ENT_QUOTES, 'UTF-8') . '">';
        if ($hasError) {
            $html .= '<p class="text-red-600 text-sm mt-1">' . htmlspecialchars(session('errors')->first($name), ENT_QUOTES, 'UTF-8') . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}

/**
 * Universal form field generator using Blade component
 *
 * Supported types: text, email, password, number, date, time, datetime-local,
 * textarea, select, radio, checkbox, checkbox-group, file, color, range, url, tel, search
 *
 * @param string $name Field name
 * @param string $type Field type
 * @param string|null $label Field label
 * @param mixed $value Field value
 * @param array $options Options for select, radio, checkbox-group
 * @param array $attributes Additional attributes
 *
 * @return \Illuminate\View\View
 */
if (!function_exists('formField')) {
    function formField($name, $type = 'text', $label = null, $value = null, $options = [], $attributes = [])
    {
        $defaultAttributes = [
            'required' => false,
            'placeholder' => '',
            'readonly' => false,
            'disabled' => false,
            'class' => '',
            'help' => null,
            'rows' => 5,
            'min' => null,
            'max' => null,
            'minLength' => null,
            'maxLength' => null,
            'step' => null,
            'accept' => null,
            'pattern' => null,
            'multiple' => false,
            'checkboxValue' => '1',
            'checkboxLabel' => null,
        ];

        $mergedAttributes = array_merge($defaultAttributes, $attributes);

        return view('components.forms.form-field', [
            'name' => $name,
            'type' => $type,
            'label' => $label,
            'value' => $value,
            'options' => $options,
            'required' => $mergedAttributes['required'],
            'placeholder' => $mergedAttributes['placeholder'],
            'readonly' => $mergedAttributes['readonly'],
            'disabled' => $mergedAttributes['disabled'],
            'class' => $mergedAttributes['class'],
            'help' => $mergedAttributes['help'],
            'rows' => $mergedAttributes['rows'],
            'min' => $mergedAttributes['min'],
            'max' => $mergedAttributes['max'],
            'minLength' => $mergedAttributes['minLength'],
            'maxLength' => $mergedAttributes['maxLength'],
            'step' => $mergedAttributes['step'],
            'accept' => $mergedAttributes['accept'],
            'pattern' => $mergedAttributes['pattern'],
            'multiple' => $mergedAttributes['multiple'],
            'checkboxValue' => $mergedAttributes['checkboxValue'],
            'checkboxLabel' => $mergedAttributes['checkboxLabel'],
        ]);
    }
}
