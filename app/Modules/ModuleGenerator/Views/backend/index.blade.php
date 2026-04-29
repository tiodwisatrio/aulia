@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6" x-data="moduleGenerator()">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Module Generator</h1>
        <p class="text-gray-600 mt-1">Generate modul CRUD baru secara otomatis</p>
    </div>

    <!-- Error Message -->
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl">
        <div class="flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span class="font-semibold">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl">
        <div class="flex items-center gap-2 mb-2">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span class="font-semibold">Terdapat kesalahan pada form:</span>
        </div>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('module-generator.generate') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Section 1: Basic Configuration -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Konfigurasi Dasar</h2>

            <div class="grid grid-cols-2 gap-6">
                <!-- Module Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Nama Modul <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="module_name" x-model="moduleName"
                        @input="tableName = generateTableName(moduleName)"
                        value="{{ old('module_name') }}"
                        placeholder="Gallery, FAQ, OurClient"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                        required>
                    <p class="text-gray-500 text-xs mt-1">PascalCase tanpa spasi. Contoh: Gallery, FAQ, OurClient</p>
                </div>

                <!-- Table Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Nama Tabel <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="table_name" x-model="tableName"
                        value="{{ old('table_name') }}"
                        placeholder="galleries, faqs, our_clients"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                        required>
                    <p class="text-gray-500 text-xs mt-1">snake_case plural. Auto-generate dari nama modul, bisa diedit.</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mt-6">
                <!-- Include Frontend -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Include Frontend Routes</label>
                    <select name="include_frontend" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="1" {{ old('include_frontend', '1') == '1' ? 'selected' : '' }}>Ya - Buat halaman publik</option>
                        <option value="0" {{ old('include_frontend') == '0' ? 'selected' : '' }}>Tidak - Backend saja</option>
                    </select>
                    <p class="text-gray-500 text-xs mt-1">Buat controller & views untuk halaman frontend (publik)</p>
                </div>

                <!-- Include Slug -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Include Slug Field</label>
                    <select name="include_slug" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="1" {{ old('include_slug', '1') == '1' ? 'selected' : '' }}>Ya - Auto-generate slug dari field pertama</option>
                        <option value="0" {{ old('include_slug') == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <p class="text-gray-500 text-xs mt-1">Slug akan di-generate otomatis dari field text pertama</p>
                </div>
            </div>
        </div>

        <!-- Section 2: Fields Configuration -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Konfigurasi Fields</h2>
                    <p class="text-gray-600 text-sm mt-1">Field <code class="bg-gray-100 px-1 rounded">id</code>, <code class="bg-gray-100 px-1 rounded">status</code>, <code class="bg-gray-100 px-1 rounded">order</code>, <code class="bg-gray-100 px-1 rounded">slug</code>, <code class="bg-gray-100 px-1 rounded">timestamps</code> sudah otomatis ditambahkan.</p>
                </div>
                <button type="button" @click="addField()"
                    class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Tambah Field
                </button>
            </div>

            <!-- Fields List -->
            <div class="space-y-4">
                <template x-for="(field, index) in fields" :key="index">
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-gray-700" x-text="'Field #' + (index + 1)"></span>
                            <button type="button" @click="removeField(index)"
                                x-show="fields.length > 1"
                                class="text-red-500 hover:text-red-700 transition" title="Hapus field">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-12 gap-4">
                            <!-- Field Name -->
                            <div class="col-span-3">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Field <span class="text-red-600">*</span></label>
                                <input type="text"
                                    :name="'fields[' + index + '][name]'"
                                    x-model="field.name"
                                    @input="if(!field.labelEdited) field.label = generateLabel(field.name)"
                                    placeholder="title, description"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    required>
                                <p class="text-gray-400 text-xs mt-1">snake_case</p>
                            </div>

                            <!-- Field Type -->
                            <div class="col-span-2">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Tipe <span class="text-red-600">*</span></label>
                                <select :name="'fields[' + index + '][type]'"
                                    x-model="field.type"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    required>
                                    <option value="text">Text</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="number">Number</option>
                                    <option value="email">Email</option>
                                    <option value="date">Date</option>
                                    <option value="select">Select</option>
                                    <option value="file">File/Image</option>
                                    <option value="boolean">Boolean/Checkbox</option>
                                </select>
                            </div>

                            <!-- Field Label -->
                            <div class="col-span-3">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Label <span class="text-red-600">*</span></label>
                                <input type="text"
                                    :name="'fields[' + index + '][label]'"
                                    x-model="field.label"
                                    @input="field.labelEdited = true"
                                    placeholder="Judul, Deskripsi"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                                    required>
                                <p class="text-gray-400 text-xs mt-1">Auto dari nama</p>
                            </div>

                            <!-- Required -->
                            <div class="col-span-2">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Required</label>
                                <select :name="'fields[' + index + '][required]'"
                                    x-model="field.required"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>

                            <!-- Nullable -->
                            <div class="col-span-2">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nullable</label>
                                <select :name="'fields[' + index + '][nullable]'"
                                    x-model="field.nullable"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Preview -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Preview</h2>
            <div class="grid grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-gray-600 font-semibold">Folder Modul:</p>
                    <p class="text-gray-900 font-mono" x-text="'app/Modules/' + (moduleName || '...')"></p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Nama Tabel:</p>
                    <p class="text-gray-900 font-mono" x-text="tableName || '...'"></p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Route Admin:</p>
                    <p class="text-gray-900 font-mono" x-text="'/dashboard/' + (tableName ? tableName.replace(/_/g, '-') : '...')"></p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Jumlah Fields:</p>
                    <p class="text-gray-900" x-text="fields.length + ' field(s) + status, order' + (document.querySelector('[name=include_slug]')?.value == '1' ? ', slug' : '')"></p>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex gap-4">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-3 rounded-lg font-semibold transition flex items-center gap-2"
                onclick="return confirm('Yakin ingin generate modul ini? Pastikan konfigurasi sudah benar.')">
                <i data-lucide="cpu" class="w-5 h-5"></i>
                Generate Module
            </button>
            <a href="{{ route('dashboard') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-8 py-3 rounded-lg font-semibold transition flex items-center gap-2">
                <i data-lucide="x" class="w-5 h-5"></i>
                Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    function moduleGenerator() {
        return {
            moduleName: '{{ old("module_name", "") }}',
            tableName: '{{ old("table_name", "") }}',
            fields: {!! old('fields') ? json_encode(collect(old('fields'))->map(function($f) {
                return [
                    'name' => $f['name'] ?? '',
                    'type' => $f['type'] ?? 'text',
                    'label' => $f['label'] ?? '',
                    'required' => $f['required'] ?? '1',
                    'nullable' => $f['nullable'] ?? '0',
                    'labelEdited' => true,
                ];
            })->values()) : '[{ name: "", type: "text", label: "", required: "1", nullable: "0", labelEdited: false }]' !!},

            addField() {
                this.fields.push({
                    name: '',
                    type: 'text',
                    label: '',
                    required: '0',
                    nullable: '1',
                    labelEdited: false
                });
                this.$nextTick(() => {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            },

            removeField(index) {
                if (this.fields.length > 1) {
                    this.fields.splice(index, 1);
                }
            },

            generateTableName(name) {
                if (!name) return '';
                // PascalCase to snake_case (handles consecutive uppercase: "FAQ" -> "faq", "OurClient" -> "our_client")
                let snake = name
                    .replace(/([A-Z]+)([A-Z][a-z])/g, '$1_$2')  // HTMLParser -> HTML_Parser
                    .replace(/([a-z])([A-Z])/g, '$1_$2')         // ourClient -> our_Client
                    .toLowerCase();
                // Simple pluralization
                if (snake.endsWith('y') && !snake.endsWith('ay') && !snake.endsWith('ey') && !snake.endsWith('oy') && !snake.endsWith('uy')) {
                    snake = snake.slice(0, -1) + 'ies';
                } else if (snake.endsWith('s') || snake.endsWith('x') || snake.endsWith('z') || snake.endsWith('ch') || snake.endsWith('sh')) {
                    snake += 'es';
                } else {
                    snake += 's';
                }
                return snake;
            },

            generateRoutePrefix(name) {
                if (!name) return '...';
                // Use table name logic then replace _ with -
                let table = this.generateTableName(name);
                return table.replace(/_/g, '-');
            },

            generateLabel(fieldName) {
                if (!fieldName) return '';
                return fieldName.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
            }
        }
    }
</script>
@endpush

@endsection
