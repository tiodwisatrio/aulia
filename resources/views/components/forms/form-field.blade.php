{{--
    Reusable Form Field Component untuk berbagai tipe input

    Props yang tersedia:
    @prop string $name - Nama field
    @prop string $type - Tipe field (text, number, date, textarea, select, radio, dll)
    @prop string|null $label - Label field
    @prop mixed $value - Nilai default
    @prop array $options - Opsi untuk select, radio, checkbox-group
    @prop bool $required - Field wajib diisi
    @prop string $placeholder - Placeholder text
    @prop bool $readonly - Field read-only
    @prop bool $disabled - Field disabled
    @prop string|null $class - CSS class tambahan
    @prop string|null $help - Teks bantuan di bawah field
    @prop int $rows - Jumlah baris untuk textarea
    @prop float|null $min - Nilai/tanggal minimum
    @prop float|null $max - Nilai/tanggal maksimum
    @prop int|null $minLength - Panjang minimum
    @prop int|null $maxLength - Panjang maksimum
    @prop string|null $step - Langkah untuk number/range
    @prop string|null $accept - MIME types untuk file
    @prop string|null $pattern - Regex pattern
    @prop bool $multiple - Multiple file upload
    @prop string $checkboxValue - Nilai checkbox
    @prop string|null $checkboxLabel - Label checkbox
--}}

@props([
    'name' => '',
    'type' => 'text',
    'label' => null,
    'value' => null,
    'options' => [],
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
])

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    {{-- Label --}}
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-900 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif

    {{-- Text Input --}}
    @if($type === 'text' || $type === 'email' || $type === 'url' || $type === 'password' || $type === 'search')
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value ?? '') }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            @if($minLength) minlength="{{ $minLength }}" @endif
            @if($maxLength) maxlength="{{ $maxLength }}" @endif
            @if($pattern) pattern="{{ $pattern }}" @endif
            class="w-full px-4 py-2 border @error($name) border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 {{ $class ?? '' }}">

    {{-- Number Input --}}
    @elseif($type === 'number')
        <input
            type="number"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value ?? '') }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            @if($min !== null) min="{{ $min }}" @endif
            @if($max !== null) max="{{ $max }}" @endif
            @if($step) step="{{ $step }}" @endif
            class="w-full px-4 py-2 border @error($name) border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 {{ $class ?? '' }}">

    {{-- Textarea --}}
    @elseif($type === 'textarea')
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="{{ $rows ?? 5 }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            @if($minLength) minlength="{{ $minLength }}" @endif
            @if($maxLength) maxlength="{{ $maxLength }}" @endif
            class="w-full px-4 py-2 border @error($name) border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 {{ $class ?? '' }}">{{ old($name, $value ?? '') }}</textarea>

    {{-- Date Input --}}
    @elseif($type === 'date')
        <input
            type="date"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value ?? '') }}"
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            @if($min) min="{{ $min }}" @endif
            @if($max) max="{{ $max }}" @endif
            class="w-full px-4 py-2 border @error($name) border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 {{ $class ?? '' }}">

    {{-- Time Input --}}
    @elseif($type === 'time')
        <input
            type="time"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value ?? '') }}"
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            class="w-full px-4 py-2 border @error($name) border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 {{ $class ?? '' }}">

    {{-- DateTime Input --}}
    @elseif($type === 'datetime-local')
        <input
            type="datetime-local"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value ?? '') }}"
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            class="w-full px-4 py-2 border @error($name) border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 {{ $class ?? '' }}">

    {{-- File Input --}}
    @elseif($type === 'file')
        <div class="mt-1">
            <input
                type="file"
                id="{{ $name }}"
                name="{{ $multiple ? $name . '[]' : $name }}"
                @if($accept) accept="{{ $accept }}" @endif
                @if($required) required @endif
                @if($disabled) disabled @endif
                @if($multiple) multiple @endif
                class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0
                    file:text-sm file:font-semibold
                    file:bg-teal-50 file:text-teal-700
                    hover:file:bg-teal-100
                    cursor-pointer border @error($name) border-red-500 @else border-gray-300 @enderror rounded-lg">
        </div>

    {{-- Select/Dropdown --}}
    @elseif($type === 'select')
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            @if($multiple) multiple @endif
            class="w-full px-4 py-2 border @error($name) border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 {{ $class ?? '' }}">
            @if($placeholder && !$multiple)
                <option value="">{{ $placeholder }}</option>
            @endif
            @foreach($options ?? [] as $optionValue => $optionLabel)
                @if(is_array($optionLabel))
                    {{-- Grouped options --}}
                    <optgroup label="{{ $optionValue }}">
                        @foreach($optionLabel as $val => $label)
                            <option value="{{ $val }}" {{ in_array((string)$val, (array)old($name, $value ?? [])) ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </optgroup>
                @else
                    <option value="{{ $optionValue }}" {{ in_array((string)$optionValue, (array)old($name, $value ?? [])) ? 'selected' : '' }}>
                        {{ $optionLabel }}
                    </option>
                @endif
            @endforeach
        </select>

    {{-- Radio Buttons --}}
    @elseif($type === 'radio')
        <div class="space-y-3">
            @foreach($options ?? [] as $optionValue => $optionLabel)
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input
                        type="radio"
                        name="{{ $name }}"
                        value="{{ $optionValue }}"
                        {{ old($name, $value) == $optionValue ? 'checked' : '' }}
                        @if($required) required @endif
                        @if($disabled) disabled @endif
                        class="w-4 h-4 text-teal-600 border-gray-300 focus:ring-2 focus:ring-teal-500">
                    <span class="text-sm text-gray-700">{{ $optionLabel }}</span>
                </label>
            @endforeach
        </div>

    {{-- Checkbox --}}
    @elseif($type === 'checkbox')
        <label class="flex items-center space-x-3 cursor-pointer">
            <input
                type="checkbox"
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ $checkboxValue ?? '1' }}"
                {{ old($name, $value) ? 'checked' : '' }}
                @if($required) required @endif
                @if($disabled) disabled @endif
                class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500">
            <span class="text-sm text-gray-700">{{ $checkboxLabel ?? '' }}</span>
        </label>

    {{-- Checkbox Group --}}
    @elseif($type === 'checkbox-group')
        <div class="space-y-3">
            @foreach($options ?? [] as $optionValue => $optionLabel)
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input
                        type="checkbox"
                        name="{{ $name }}[]"
                        value="{{ $optionValue }}"
                        {{ in_array((string)$optionValue, (array)old($name, $value ?? [])) ? 'checked' : '' }}
                        @if($disabled) disabled @endif
                        class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500">
                    <span class="text-sm text-gray-700">{{ $optionLabel }}</span>
                </label>
            @endforeach
        </div>

    {{-- Color Input --}}
    @elseif($type === 'color')
        <div class="flex items-center gap-2">
            <input
                type="color"
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ old($name, $value ?? '#000000') }}"
                @if($required) required @endif
                @if($disabled) disabled @endif
                class="w-16 h-10 border @error($name) border-red-500 @else border-gray-300 @enderror rounded-lg cursor-pointer">
            <span class="text-sm text-gray-500" id="{{ $name }}_display">{{ old($name, $value ?? '#000000') }}</span>
        </div>

    {{-- Range Input --}}
    @elseif($type === 'range')
        <div>
            <input
                type="range"
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ old($name, $value ?? $min ?? 0) }}"
                @if($min !== null) min="{{ $min }}" @endif
                @if($max !== null) max="{{ $max }}" @endif
                @if($step) step="{{ $step }}" @endif
                @if($required) required @endif
                @if($disabled) disabled @endif
                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-teal-600">
            <div class="flex justify-between text-xs text-gray-500 mt-2">
                <span>{{ $min ?? '0' }}</span>
                <span id="{{ $name }}_display" class="font-semibold text-teal-600">{{ old($name, $value ?? $min ?? 0) }}</span>
                <span>{{ $max ?? '100' }}</span>
            </div>
        </div>

    {{-- Email Input (explicit type) --}}
    @elseif($type === 'email')
        <input
            type="email"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value ?? '') }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            class="w-full px-4 py-2 border @error($name) border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 {{ $class ?? '' }}">

    {{-- Tel Input --}}
    @elseif($type === 'tel')
        <input
            type="tel"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value ?? '') }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            class="w-full px-4 py-2 border @error($name) border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 {{ $class ?? '' }}">

    @endif

    {{-- Error Message --}}
    @error($name)
        <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
            <span>⚠</span> {{ $message }}
        </p>
    @enderror

    {{-- Help Text --}}
    @if($help)
        <p class="text-gray-500 text-xs mt-1">{{ $help }}</p>
    @endif
</div>

{{-- JavaScript untuk color dan range input display --}}
@if($type === 'color' || $type === 'range')
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($type === 'color')
                const colorInput = document.getElementById('{{ $name }}');
                const colorDisplay = document.getElementById('{{ $name }}_display');
                if (colorInput && colorDisplay) {
                    colorInput.addEventListener('input', function() {
                        colorDisplay.textContent = this.value;
                    });
                }
            @endif

            @if($type === 'range')
                const rangeInput = document.getElementById('{{ $name }}');
                const rangeDisplay = document.getElementById('{{ $name }}_display');
                if (rangeInput && rangeDisplay) {
                    rangeInput.addEventListener('input', function() {
                        rangeDisplay.textContent = this.value;
                    });
                }
            @endif
        });
    </script>
    @endpush
@endif
