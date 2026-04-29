<?php

namespace App\Modules\ModuleGenerator\Services;

use Illuminate\Support\Str;
use App\Modules\Navigation\Models\Navigation;

class ModuleGeneratorService
{
    private array $config;
    private array $names;
    private array $created = [];

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->resolveNames();
    }

    public function generate(): array
    {
        $this->createDirectoryStructure();
        $this->generateServiceProvider();
        $this->generateRoutes();
        $this->generatePermissions();
        $this->generateModel();
        $this->generateBackendController();
        $this->generateMigration();
        $this->generateBackendIndexView();
        $this->generateBackendCreateView();
        $this->generateBackendEditView();
        $this->generateBackendShowView();

        if ($this->config['include_frontend']) {
            $this->generateFrontendController();
            $this->generateFrontendIndexView();
            $this->generateFrontendShowView();
        }

        $this->createNavigationEntry();

        return [
            'files' => $this->created,
            'module_name' => $this->names['moduleName'],
            'table_name' => $this->config['table_name'],
            'navigation_created' => true,
        ];
    }

    private function resolveNames(): void
    {
        $moduleName = $this->config['module_name'];
        $tableName = $this->config['table_name'];

        // Derive from table_name (user-controlled, reliable) instead of module_name
        // This avoids issues with all-caps names like "FAQ" -> "f_a_q_s"
        $routePrefix = str_replace('_', '-', $tableName);           // faqs, galleries
        $singularSnake = Str::singular($tableName);                  // faq, gallery
        $singularCamel = Str::camel($singularSnake);                 // faq, gallery
        $pluralCamel = Str::camel($tableName);                       // faqs, galleries

        $this->names = [
            'moduleName'       => $moduleName,
            'modelName'        => $moduleName,
            'tableName'        => $tableName,
            'routePrefix'      => $routePrefix,
            'routeParam'       => $singularSnake,
            'viewNamespace'    => Str::lower($moduleName),
            'uploadDir'        => 'uploads/' . $routePrefix,
            'variableSingular' => $singularCamel,
            'variablePlural'   => $pluralCamel,
            'labelSingular'    => Str::headline($singularSnake),
            'labelPlural'      => Str::headline($tableName),
        ];
    }

    private function createDirectoryStructure(): void
    {
        $base = app_path("Modules/{$this->names['moduleName']}");

        $dirs = [
            "{$base}/Http/Controllers/Backend",
            "{$base}/Models",
            "{$base}/Views/Backend",
        ];

        if ($this->config['include_frontend']) {
            $dirs[] = "{$base}/Http/Controllers/Frontend";
            $dirs[] = "{$base}/Views/Frontend";
        }

        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }
    }

    private function generateServiceProvider(): void
    {
        $mn = $this->names['moduleName'];
        $vn = $this->names['viewNamespace'];

        $content = <<<PHP
<?php

namespace App\\Modules\\{$mn};

use Illuminate\\Support\\ServiceProvider;

class {$mn}ServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \$this->loadRoutes();
        \$this->loadViews();
        \$this->loadPermissions();
    }

    protected function loadRoutes(): void
    {
        \$routesPath = __DIR__ . '/routes.php';
        if (file_exists(\$routesPath)) {
            \$this->app['router']->group([
                'middleware' => ['web'],
            ], function () use (\$routesPath) {
                require \$routesPath;
            });
        }
    }

    protected function loadViews(): void
    {
        \$viewPath = __DIR__ . '/Views';
        \$this->loadViewsFrom(\$viewPath, '{$vn}');
    }

    protected function loadPermissions(): void
    {
        \$permissionsPath = __DIR__ . '/permissions.php';
        if (file_exists(\$permissionsPath)) {
            require \$permissionsPath;
        }
    }
}

PHP;

        $path = app_path("Modules/{$mn}/{$mn}ServiceProvider.php");
        $this->writeFile($path, $content);
    }

    private function generateRoutes(): void
    {
        $mn = $this->names['moduleName'];
        $rp = $this->names['routePrefix'];
        $param = $this->names['routeParam'];
        $includeSlug = $this->config['include_slug'];

        $backendUse = "use App\\Modules\\{$mn}\\Http\\Controllers\\Backend\\{$mn}Controller as Backend{$mn}Controller;";
        $frontendUse = '';
        $frontendRoutes = '';

        if ($this->config['include_frontend']) {
            $frontendUse = "\nuse App\\Modules\\{$mn}\\Http\\Controllers\\Frontend\\{$mn}Controller as Frontend{$mn}Controller;";
            $binding = $includeSlug ? "{{$param}:slug}" : "{{$param}}";
            $frontendRoutes = <<<PHP

// Frontend routes (public)
Route::get('/{$rp}', [Frontend{$mn}Controller::class, 'index'])->name('frontend.{$rp}.index');
Route::get('/{$rp}/{$binding}', [Frontend{$mn}Controller::class, 'show'])->name('frontend.{$rp}.show');
PHP;
        }

        $content = <<<PHP
<?php

use Illuminate\\Support\\Facades\\Route;
{$backendUse}{$frontendUse}
{$frontendRoutes}

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('{$rp}', Backend{$mn}Controller::class)
        ->middleware('can:admin-access');
});

PHP;

        $path = app_path("Modules/{$mn}/routes.php");
        $this->writeFile($path, $content);
    }

    private function generatePermissions(): void
    {
        $mn = $this->names['moduleName'];

        $content = <<<'PHP'
<?php

use Illuminate\Support\Facades\Gate;

// Permissions defined in AppServiceProvider (admin-access gate)

PHP;

        $path = app_path("Modules/{$mn}/permissions.php");
        $this->writeFile($path, $content);
    }

    private function generateModel(): void
    {
        $mn = $this->names['moduleName'];
        $model = $this->names['modelName'];
        $tableName = $this->names['tableName'];
        $var = $this->names['variableSingular'];

        $fillable = $this->getFieldsForFillable();
        $casts = $this->getFieldsForCasts();

        $slugImport = '';
        $slugBoot = '';

        if ($this->config['include_slug']) {
            $slugImport = "use Illuminate\\Support\\Str;\n";
            $slugSource = $this->getSlugSourceField();

            $slugBoot = <<<PHP

    protected static function boot()
    {
        parent::boot();

        static::creating(function (\$model) {
            if (empty(\$model->slug)) {
                \$model->slug = Str::slug(\$model->{$slugSource});
                \$originalSlug = \$model->slug;
                \$count = 1;
                while (static::where('slug', \$model->slug)->exists()) {
                    \$model->slug = \$originalSlug . '-' . \$count;
                    \$count++;
                }
            }
        });

        static::updating(function (\$model) {
            if (\$model->isDirty('{$slugSource}') && !\$model->isDirty('slug')) {
                \$model->slug = Str::slug(\$model->{$slugSource});
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
PHP;
        }

        $content = <<<PHP
<?php

namespace App\\Modules\\{$mn}\\Models;

use Illuminate\\Database\\Eloquent\\Model;
{$slugImport}
class {$model} extends Model
{
    protected \$table = '{$tableName}';

    protected \$fillable = [
{$fillable}
    ];

    protected \$casts = [
{$casts}
    ];
{$slugBoot}

    public function getStatusLabelAttribute()
    {
        return \$this->status === 1 ? 'Aktif' : 'Tidak Aktif';
    }
}

PHP;

        $path = app_path("Modules/{$mn}/Models/{$model}.php");
        $this->writeFile($path, $content);
    }

    private function generateBackendController(): void
    {
        $mn = $this->names['moduleName'];
        $model = $this->names['modelName'];
        $vn = $this->names['viewNamespace'];
        $rp = $this->names['routePrefix'];
        $var = $this->names['variableSingular'];
        $varPlural = $this->names['variablePlural'];
        $label = $this->names['labelSingular'];

        $searchFields = $this->getSearchableFields();
        $fileFields = $this->getFileFields();
        $nonFileFields = $this->getNonFileNonBooleanFields();

        // Build search query
        $searchQuery = '';
        if (!empty($searchFields)) {
            $firstField = $searchFields[0];
            $searchLines = "                \$q->where('{$firstField}', 'like', '%' . \$request->search . '%')";
            for ($i = 1; $i < count($searchFields); $i++) {
                $searchLines .= "\n                  ->orWhere('{$searchFields[$i]}', 'like', '%' . \$request->search . '%')";
            }
            $searchQuery = <<<PHP

        if (\$request->has('search') && \$request->search) {
            \$query->where(function(\$q) use (\$request) {
{$searchLines};
            });
        }
PHP;
        }

        // Build validation rules for store
        $storeRules = $this->getValidationRules(false);
        $updateRules = $this->getValidationRules(true);

        // Build $data = $request->only([...])
        $onlyFields = $this->getRequestOnlyFields();

        // Build file upload handling for store
        $storeFileHandling = $this->getStoreFileHandling();
        $updateFileHandling = $this->getUpdateFileHandling($var);
        $destroyFileHandling = $this->getDestroyFileHandling($var);

        // Storage import
        $storageImport = !empty($fileFields) ? "\nuse Illuminate\\Support\\Facades\\Storage;" : '';

        $content = <<<PHP
<?php

namespace App\\Modules\\{$mn}\\Http\\Controllers\\Backend;

use App\\Http\\Controllers\\Controller;
use Illuminate\\Http\\Request;
use App\\Modules\\{$mn}\\Models\\{$model};{$storageImport}

class {$model}Controller extends Controller
{
    public function index(Request \$request)
    {
        \$query = {$model}::latest();
{$searchQuery}

        \${$varPlural} = \$query->paginate(10);
        return view('{$vn}::backend.index', compact('{$varPlural}'));
    }

    public function create()
    {
        return view('{$vn}::backend.create');
    }

    public function store(Request \$request)
    {
        \$request->validate([
{$storeRules}
        ]);

        \$data = \$request->only([{$onlyFields}]);
{$storeFileHandling}

        {$model}::create(\$data);

        return redirect()->route('{$rp}.index')->with('success', '{$label} berhasil ditambahkan.');
    }

    public function show({$model} \${$var})
    {
        return view('{$vn}::backend.show', compact('{$var}'));
    }

    public function edit({$model} \${$var})
    {
        return view('{$vn}::backend.edit', compact('{$var}'));
    }

    public function update(Request \$request, {$model} \${$var})
    {
        \$request->validate([
{$updateRules}
        ]);

        \$data = \$request->only([{$onlyFields}]);
{$updateFileHandling}

        \${$var}->update(\$data);

        return redirect()->route('{$rp}.index')->with('success', '{$label} berhasil diperbarui.');
    }

    public function destroy({$model} \${$var})
    {
{$destroyFileHandling}        \${$var}->delete();

        return redirect()->route('{$rp}.index')->with('success', '{$label} berhasil dihapus.');
    }
}

PHP;

        $path = app_path("Modules/{$mn}/Http/Controllers/Backend/{$model}Controller.php");
        $this->writeFile($path, $content);
    }

    private function generateFrontendController(): void
    {
        $mn = $this->names['moduleName'];
        $model = $this->names['modelName'];
        $vn = $this->names['viewNamespace'];
        $var = $this->names['variableSingular'];
        $varPlural = $this->names['variablePlural'];

        $content = <<<PHP
<?php

namespace App\\Modules\\{$mn}\\Http\\Controllers\\Frontend;

use App\\Http\\Controllers\\Controller;
use App\\Modules\\{$mn}\\Models\\{$model};

class {$model}Controller extends Controller
{
    public function index()
    {
        \${$varPlural} = {$model}::where('status', 1)
            ->orderBy('order')
            ->paginate(12);

        return view('{$vn}::frontend.index', compact('{$varPlural}'));
    }

    public function show({$model} \${$var})
    {
        if (\${$var}->status !== 1) {
            abort(404);
        }

        return view('{$vn}::frontend.show', compact('{$var}'));
    }
}

PHP;

        $path = app_path("Modules/{$mn}/Http/Controllers/Frontend/{$model}Controller.php");
        $this->writeFile($path, $content);
    }

    private function generateMigration(): void
    {
        $tableName = $this->names['tableName'];
        $columns = $this->getMigrationColumns();

        $content = <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('{$tableName}', function (Blueprint \$table) {
            \$table->id();
{$columns}
            \$table->tinyInteger('status')->default(1);
            \$table->integer('order')->default(0);
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{$tableName}');
    }
};

PHP;

        $timestamp = date('Y_m_d_His');
        $filename = "{$timestamp}_create_{$tableName}_table.php";
        $path = database_path("migrations/{$filename}");
        $this->writeFile($path, $content);
    }

    private function generateBackendIndexView(): void
    {
        $mn = $this->names['moduleName'];
        $rp = $this->names['routePrefix'];
        $var = $this->names['variableSingular'];
        $varPlural = $this->names['variablePlural'];
        $label = $this->names['labelSingular'];
        $labelPlural = $this->names['labelPlural'];

        $tableHeaders = $this->getTableHeaders();
        $tableCells = $this->getTableCells($var);
        $colSpan = $this->getIndexColumnCount();

        $content = <<<BLADE
@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between gap-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{$labelPlural}</h1>
            <p class="text-gray-600 mt-1">Kelola semua {$labelPlural}</p>
            <div class="mt-4">
                <a href="{{ route('{$rp}.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition inline-block">
                    + Tambah {$label}
                </a>
            </div>
        </div>

        <div class="flex-shrink-0">
            <form method="GET" action="{{ route('{$rp}.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari {$labelPlural}..."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
{$tableHeaders}
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Dibuat</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse(\${$varPlural} as \${$var})
                <tr class="hover:bg-gray-50 transition">
{$tableCells}
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ \${$var}->status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ \${$var}->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ \${$var}->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3 items-center">
                            <a href="{{ route('{$rp}.show', \${$var}) }}" class="text-gray-600 hover:text-gray-900 transition" title="Lihat">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </a>
                            <a href="{{ route('{$rp}.edit', \${$var}) }}" class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                                <i data-lucide="edit" class="w-5 h-5"></i>
                            </a>
                            <form action="{{ route('{$rp}.destroy', \${$var}) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{$colSpan}" class="px-6 py-8 text-center text-gray-600">
                        Belum ada data. <a href="{{ route('{$rp}.create') }}" class="text-teal-600 hover:text-teal-900 font-semibold">Buat yang pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ \${$varPlural}->links() }}
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

@endsection

BLADE;

        $path = app_path("Modules/{$mn}/Views/Backend/index.blade.php");
        $this->writeFile($path, $content);
    }

    private function generateBackendCreateView(): void
    {
        $mn = $this->names['moduleName'];
        $rp = $this->names['routePrefix'];
        $label = $this->names['labelSingular'];

        $formFields = $this->getFormFields(false);

        $content = <<<BLADE
@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Buat {$label}</h1>
            <p class="text-gray-600 mt-1">Tambahkan {$label} baru</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('{$rp}.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

{$formFields}

            {{-- Order Field --}}
            {!! formField('order', 'number', 'Urutan', null, [], [
                'min' => 0,
                'placeholder' => '0',
                'help' => 'Urutan tampilan'
            ]) !!}

            {{-- Status Field --}}
            {!! formField('status', 'select', 'Status', null, [
                '1' => 'Active',
                '0' => 'Inactive'
            ], [
                'required' => true,
                'placeholder' => 'Pilih Status'
            ]) !!}

            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan {$label}
                </button>
                <a href="{{ route('{$rp}.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="x" class="w-4 h-4"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

@endsection

BLADE;

        $path = app_path("Modules/{$mn}/Views/Backend/create.blade.php");
        $this->writeFile($path, $content);
    }

    private function generateBackendEditView(): void
    {
        $mn = $this->names['moduleName'];
        $rp = $this->names['routePrefix'];
        $var = $this->names['variableSingular'];
        $label = $this->names['labelSingular'];

        $formFields = $this->getFormFields(true);
        $firstField = $this->config['fields'][0]['name'] ?? 'id';

        $content = <<<BLADE
@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit {$label}</h1>
            <p class="text-gray-600 mt-1">{{ \${$var}->{$firstField} }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('{$rp}.update', \${$var}) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

{$formFields}

            {{-- Order Field --}}
            {!! formField('order', 'number', 'Urutan', \${$var}->order, [], [
                'min' => 0,
                'placeholder' => '0',
                'help' => 'Urutan tampilan'
            ]) !!}

            {{-- Status Field --}}
            {!! formField('status', 'select', 'Status', \${$var}->status, [
                '1' => 'Active',
                '0' => 'Inactive'
            ], [
                'required' => true,
                'placeholder' => 'Pilih Status'
            ]) !!}

            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Perbarui {$label}
                </button>
                <a href="{{ route('{$rp}.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="x" class="w-4 h-4"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

@endsection

BLADE;

        $path = app_path("Modules/{$mn}/Views/Backend/edit.blade.php");
        $this->writeFile($path, $content);
    }

    private function generateBackendShowView(): void
    {
        $mn = $this->names['moduleName'];
        $rp = $this->names['routePrefix'];
        $var = $this->names['variableSingular'];
        $label = $this->names['labelSingular'];

        $firstField = $this->config['fields'][0]['name'] ?? 'id';
        $showFields = $this->getShowFields($var);

        $content = <<<BLADE
@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ \${$var}->{$firstField} }}</h1>
            <p class="text-gray-600 mt-1">{{ \${$var}->created_at->format('d M Y H:i') }}</p>
        </div>
        <div>
            <a href="{{ route('{$rp}.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
                &larr; Kembali ke {$label}
            </a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
{$showFields}
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">STATUS</p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if(\${$var}->status == 1) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ \${$var}->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @if(\${$var}->order !== null)
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">URUTAN</p>
                        <p class="text-gray-900">{{ \${$var}->order }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIBUAT</p>
                        <p class="text-gray-900">{{ \${$var}->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIPERBARUI</p>
                        <p class="text-gray-900">{{ \${$var}->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

@endsection

BLADE;

        $path = app_path("Modules/{$mn}/Views/Backend/show.blade.php");
        $this->writeFile($path, $content);
    }

    private function generateFrontendIndexView(): void
    {
        $mn = $this->names['moduleName'];
        $rp = $this->names['routePrefix'];
        $var = $this->names['variableSingular'];
        $varPlural = $this->names['variablePlural'];
        $labelPlural = $this->names['labelPlural'];

        $firstField = $this->config['fields'][0]['name'] ?? 'id';
        $firstFileField = $this->getFirstFileField();
        $descField = $this->getFirstTextareaField();

        $imageBlock = '';
        if ($firstFileField) {
            $imageBlock = <<<BLADE
                        @if(\${$var}->{$firstFileField})
                        <img src="{{ asset('storage/' . \${$var}->{$firstFileField}) }}" alt="{{ \${$var}->{$firstField} }}" class="w-full h-48 object-cover">
                        @endif
BLADE;
        }

        $descBlock = '';
        if ($descField) {
            $descBlock = "                        <p class=\"text-gray-600 text-sm mt-2\">{{ Str::limit(strip_tags(\${$var}->{$descField}), 100) }}</p>";
        }

        $content = <<<BLADE
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">{$labelPlural}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse(\${$varPlural} as \${$var})
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
{$imageBlock}
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-900">
                            <a href="{{ route('frontend.{$rp}.show', \${$var}) }}" class="hover:text-teal-600">
                                {{ \${$var}->{$firstField} }}
                            </a>
                        </h3>
{$descBlock}
                    </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 text-gray-600">
            Belum ada data.
        </div>
        @endforelse
    </div>

    <div class="mt-8 flex justify-center">
        {{ \${$varPlural}->links() }}
    </div>
</div>
@endsection

BLADE;

        $path = app_path("Modules/{$mn}/Views/Frontend/index.blade.php");
        $this->writeFile($path, $content);
    }

    private function generateFrontendShowView(): void
    {
        $mn = $this->names['moduleName'];
        $rp = $this->names['routePrefix'];
        $var = $this->names['variableSingular'];
        $label = $this->names['labelSingular'];

        $firstField = $this->config['fields'][0]['name'] ?? 'id';
        $showContent = $this->getFrontendShowContent($var);

        $content = <<<BLADE
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('frontend.{$rp}.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
            &larr; Kembali ke {$label}
        </a>

        <h1 class="text-3xl font-bold text-gray-900 mt-4 mb-6">{{ \${$var}->{$firstField} }}</h1>

{$showContent}
    </div>
</div>
@endsection

BLADE;

        $path = app_path("Modules/{$mn}/Views/Frontend/show.blade.php");
        $this->writeFile($path, $content);
    }

    private function createNavigationEntry(): void
    {
        $maxOrder = Navigation::max('order') ?? 0;

        Navigation::create([
            'label'  => $this->names['labelPlural'],
            'route'  => $this->names['routePrefix'] . '.index',
            'icon'   => 'box',
            'order'  => $maxOrder + 1,
            'status' => 1,
        ]);
    }

    // =====================================================================
    // HELPER METHODS
    // =====================================================================

    private function getSlugSourceField(): string
    {
        foreach ($this->config['fields'] as $field) {
            if (in_array($field['type'], ['text', 'email'])) {
                return $field['name'];
            }
        }
        return $this->config['fields'][0]['name'];
    }

    private function getFieldsForFillable(): string
    {
        $fields = [];
        foreach ($this->config['fields'] as $field) {
            $fields[] = "        '{$field['name']}',";
        }
        if ($this->config['include_slug']) {
            $fields[] = "        'slug',";
        }
        $fields[] = "        'status',";
        $fields[] = "        'order',";
        return implode("\n", $fields);
    }

    private function getFieldsForCasts(): string
    {
        $casts = ["        'status' => 'integer',", "        'order' => 'integer',"];
        foreach ($this->config['fields'] as $field) {
            if ($field['type'] === 'boolean') {
                $casts[] = "        '{$field['name']}' => 'boolean',";
            } elseif ($field['type'] === 'number') {
                $casts[] = "        '{$field['name']}' => 'integer',";
            }
        }
        return implode("\n", $casts);
    }

    private function getMigrationColumns(): string
    {
        $lines = [];

        if ($this->config['include_slug']) {
            $lines[] = "            \$table->string('slug')->unique();";
        }

        foreach ($this->config['fields'] as $field) {
            $nullable = $field['nullable'] ? '->nullable()' : '';

            switch ($field['type']) {
                case 'text':
                case 'email':
                case 'select':
                    $lines[] = "            \$table->string('{$field['name']}'){$nullable};";
                    break;
                case 'textarea':
                    $lines[] = "            \$table->text('{$field['name']}'){$nullable};";
                    break;
                case 'number':
                    $lines[] = "            \$table->integer('{$field['name']}'){$nullable};";
                    break;
                case 'date':
                    $lines[] = "            \$table->date('{$field['name']}'){$nullable};";
                    break;
                case 'file':
                    $lines[] = "            \$table->string('{$field['name']}'){$nullable};";
                    break;
                case 'boolean':
                    $lines[] = "            \$table->boolean('{$field['name']}')->default(false);";
                    break;
            }
        }

        return implode("\n", $lines);
    }

    private function getValidationRules(bool $isUpdate): string
    {
        $rules = [];

        foreach ($this->config['fields'] as $field) {
            $rulesParts = [];

            if ($field['required']) {
                $rulesParts[] = 'required';
            } else {
                $rulesParts[] = 'nullable';
            }

            switch ($field['type']) {
                case 'text':
                    $rulesParts[] = 'string';
                    $rulesParts[] = 'max:255';
                    break;
                case 'textarea':
                    $rulesParts[] = 'string';
                    break;
                case 'number':
                    $rulesParts[] = 'integer';
                    break;
                case 'email':
                    $rulesParts[] = 'email';
                    $rulesParts[] = 'max:255';
                    break;
                case 'date':
                    $rulesParts[] = 'date';
                    break;
                case 'select':
                    $rulesParts[] = 'string';
                    $rulesParts[] = 'max:255';
                    break;
                case 'file':
                    $rulesParts = [$field['required'] ? 'nullable' : 'nullable'];
                    $rulesParts[] = 'image';
                    $rulesParts[] = 'mimes:jpeg,png,jpg';
                    $rulesParts[] = 'max:2048';
                    break;
                case 'boolean':
                    $rulesParts = ['nullable', 'in:0,1'];
                    break;
            }

            $ruleString = implode('|', $rulesParts);
            $rules[] = "            '{$field['name']}' => '{$ruleString}',";
        }

        $rules[] = "            'status' => 'required|in:0,1',";
        $rules[] = "            'order' => 'nullable|integer',";

        return implode("\n", $rules);
    }

    private function getRequestOnlyFields(): string
    {
        $fields = [];
        foreach ($this->config['fields'] as $field) {
            if ($field['type'] !== 'file') {
                $fields[] = "'{$field['name']}'";
            }
        }
        $fields[] = "'status'";
        $fields[] = "'order'";
        return implode(', ', $fields);
    }

    private function getSearchableFields(): array
    {
        $fields = [];
        foreach ($this->config['fields'] as $field) {
            if (in_array($field['type'], ['text', 'textarea', 'email'])) {
                $fields[] = $field['name'];
            }
        }
        return $fields;
    }

    private function getFileFields(): array
    {
        $fields = [];
        foreach ($this->config['fields'] as $field) {
            if ($field['type'] === 'file') {
                $fields[] = $field['name'];
            }
        }
        return $fields;
    }

    private function getNonFileNonBooleanFields(): array
    {
        $fields = [];
        foreach ($this->config['fields'] as $field) {
            if (!in_array($field['type'], ['file', 'boolean'])) {
                $fields[] = $field['name'];
            }
        }
        return $fields;
    }

    private function getFirstFileField(): ?string
    {
        foreach ($this->config['fields'] as $field) {
            if ($field['type'] === 'file') {
                return $field['name'];
            }
        }
        return null;
    }

    private function getFirstTextareaField(): ?string
    {
        foreach ($this->config['fields'] as $field) {
            if ($field['type'] === 'textarea') {
                return $field['name'];
            }
        }
        return null;
    }

    private function getStoreFileHandling(): string
    {
        $fileFields = $this->getFileFields();
        if (empty($fileFields)) {
            return '';
        }

        $uploadDir = $this->names['uploadDir'];
        $lines = "\n";
        foreach ($fileFields as $field) {
            $lines .= <<<PHP

        if (\$request->hasFile('{$field}')) {
            \$data['{$field}'] = \$request->file('{$field}')->store('{$uploadDir}', 'public');
        }
PHP;
        }
        return $lines;
    }

    private function getUpdateFileHandling(string $var): string
    {
        $fileFields = $this->getFileFields();
        if (empty($fileFields)) {
            return '';
        }

        $uploadDir = $this->names['uploadDir'];
        $lines = "\n";
        foreach ($fileFields as $field) {
            $lines .= <<<PHP

        if (\$request->hasFile('{$field}')) {
            if (\${$var}->{$field}) {
                Storage::disk('public')->delete(\${$var}->{$field});
            }
            \$data['{$field}'] = \$request->file('{$field}')->store('{$uploadDir}', 'public');
        }
PHP;
        }
        return $lines;
    }

    private function getDestroyFileHandling(string $var): string
    {
        $fileFields = $this->getFileFields();
        if (empty($fileFields)) {
            return '';
        }

        $lines = '';
        foreach ($fileFields as $field) {
            $lines .= <<<PHP
        if (\${$var}->{$field}) {
            Storage::disk('public')->delete(\${$var}->{$field});
        }

PHP;
        }
        return $lines;
    }

    private function getFormFields(bool $withValues): string
    {
        $var = $this->names['variableSingular'];
        $lines = [];

        foreach ($this->config['fields'] as $field) {
            $label = $field['label'];
            $name = $field['name'];
            $required = $field['required'] ? 'true' : 'false';

            if ($field['type'] === 'file') {
                if ($withValues) {
                    $lines[] = "            {{-- {$label} Field --}}";
                    $lines[] = "            <div>";
                    $lines[] = "                <label class=\"block text-sm font-semibold text-gray-900 mb-2\">{$label}</label>";
                    $lines[] = "                @if(\${$var}->{$name})";
                    $lines[] = "                    <div class=\"mb-3\">";
                    $lines[] = "                        <img src=\"{{ asset('storage/' . \${$var}->{$name}) }}\" alt=\"{$label}\" class=\"h-32 w-auto rounded-lg\">";
                    $lines[] = "                        <p class=\"text-xs text-gray-600 mt-2\">Gambar saat ini</p>";
                    $lines[] = "                    </div>";
                    $lines[] = "                @endif";
                    $lines[] = "                {!! formField('{$name}', 'file', null, null, [], [";
                    $lines[] = "                    'accept' => 'image/*',";
                    $lines[] = "                    'help' => 'Format: JPG, PNG (Max 2MB)'";
                    $lines[] = "                ]) !!}";
                    $lines[] = "            </div>";
                } else {
                    $lines[] = "            {{-- {$label} Field --}}";
                    $lines[] = "            {!! formField('{$name}', 'file', '{$label}', null, [], [";
                    $lines[] = "                'accept' => 'image/*',";
                    $lines[] = "                'help' => 'Format: JPG, PNG (Max 2MB)'";
                    $lines[] = "            ]) !!}";
                }
            } elseif ($field['type'] === 'boolean') {
                $checked = $withValues ? "\${$var}->{$name}" : 'false';
                $lines[] = "            {{-- {$label} Field --}}";
                $lines[] = "            <div>";
                $lines[] = "                <label class=\"flex items-center\">";
                $lines[] = "                    <input type=\"checkbox\" name=\"{$name}\" value=\"1\" {{ old('{$name}', {$checked}) ? 'checked' : '' }}";
                $lines[] = "                        class=\"w-4 h-4 text-teal-600 rounded border-gray-300 focus:ring-2 focus:ring-teal-500\">";
                $lines[] = "                    <span class=\"ml-2 text-sm font-semibold text-gray-900\">{$label}</span>";
                $lines[] = "                </label>";
                $lines[] = "            </div>";
            } elseif ($field['type'] === 'textarea') {
                $value = $withValues ? "\${$var}->{$name}" : 'null';
                $lines[] = "            {{-- {$label} Field --}}";
                $lines[] = "            {!! formField('{$name}', 'textarea', '{$label}', {$value}, [], [";
                $lines[] = "                'required' => {$required},";
                $lines[] = "                'rows' => 5,";
                $lines[] = "                'placeholder' => 'Masukkan {$label}'";
                $lines[] = "            ]) !!}";
            } elseif ($field['type'] === 'select') {
                $value = $withValues ? "\${$var}->{$name}" : 'null';
                $lines[] = "            {{-- {$label} Field --}}";
                $lines[] = "            {!! formField('{$name}', 'select', '{$label}', {$value}, [";
                $lines[] = "                'option1' => 'Option 1',";
                $lines[] = "                'option2' => 'Option 2',";
                $lines[] = "            ], [";
                $lines[] = "                'required' => {$required},";
                $lines[] = "                'placeholder' => 'Pilih {$label}'";
                $lines[] = "            ]) !!}";
            } else {
                $formType = $field['type'];
                $value = $withValues ? "\${$var}->{$name}" : 'null';
                $lines[] = "            {{-- {$label} Field --}}";
                $lines[] = "            {!! formField('{$name}', '{$formType}', '{$label}', {$value}, [], [";
                $lines[] = "                'required' => {$required},";
                $lines[] = "                'placeholder' => 'Masukkan {$label}'";
                $lines[] = "            ]) !!}";
            }

            $lines[] = '';
        }

        return implode("\n", $lines);
    }

    private function getTableHeaders(): string
    {
        $fields = array_slice($this->config['fields'], 0, 4);
        $headers = [];
        foreach ($fields as $field) {
            $headers[] = "                    <th class=\"px-6 py-4 text-left text-sm font-semibold text-gray-900\">{$field['label']}</th>";
        }
        return implode("\n", $headers);
    }

    private function getTableCells(string $var): string
    {
        $fields = array_slice($this->config['fields'], 0, 4);
        $cells = [];

        foreach ($fields as $field) {
            if ($field['type'] === 'file') {
                $cells[] = "                    <td class=\"px-6 py-4\">";
                $cells[] = "                        @if(\${$var}->{$field['name']})";
                $cells[] = "                            <img src=\"{{ asset('storage/' . \${$var}->{$field['name']}) }}\" alt=\"{$field['label']}\" class=\"h-10 w-auto object-cover rounded\">";
                $cells[] = "                        @else";
                $cells[] = "                            <span class=\"text-gray-400\">-</span>";
                $cells[] = "                        @endif";
                $cells[] = "                    </td>";
            } elseif ($field['type'] === 'boolean') {
                $cells[] = "                    <td class=\"px-6 py-4\">";
                $cells[] = "                        <span class=\"text-xs font-semibold px-3 py-1 rounded-full {{ \${$var}->{$field['name']} ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}\">";
                $cells[] = "                            {{ \${$var}->{$field['name']} ? 'Ya' : 'Tidak' }}";
                $cells[] = "                        </span>";
                $cells[] = "                    </td>";
            } elseif ($field['type'] === 'textarea') {
                $cells[] = "                    <td class=\"px-6 py-4\">";
                $cells[] = "                        <span class=\"text-gray-700\">{{ Str::limit(strip_tags(\${$var}->{$field['name']}), 50) }}</span>";
                $cells[] = "                    </td>";
            } else {
                $cells[] = "                    <td class=\"px-6 py-4\">";
                $cells[] = "                        <span class=\"font-medium text-gray-900\">{{ \${$var}->{$field['name']} }}</span>";
                $cells[] = "                    </td>";
            }
        }

        return implode("\n", $cells);
    }

    private function getIndexColumnCount(): int
    {
        return min(count($this->config['fields']), 4) + 3; // +3 for status, created_at, actions
    }

    private function getShowFields(string $var): string
    {
        $lines = [];

        foreach ($this->config['fields'] as $field) {
            if ($field['type'] === 'file') {
                $lines[] = "            @if(\${$var}->{$field['name']})";
                $lines[] = "            <div class=\"bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden\">";
                $lines[] = "                <img src=\"{{ asset('storage/' . \${$var}->{$field['name']}) }}\" alt=\"{$field['label']}\" class=\"w-full h-96 object-cover\">";
                $lines[] = "            </div>";
                $lines[] = "            @endif";
            } elseif ($field['type'] === 'textarea') {
                $lines[] = "            <div class=\"bg-white rounded-xl shadow-sm border border-gray-100 p-8\">";
                $lines[] = "                <h3 class=\"font-semibold text-gray-900 mb-2\">{$field['label']}</h3>";
                $lines[] = "                <div class=\"prose max-w-none\">";
                $lines[] = "                    {!! nl2br(e(\${$var}->{$field['name']})) !!}";
                $lines[] = "                </div>";
                $lines[] = "            </div>";
            } elseif ($field['type'] === 'boolean') {
                $lines[] = "            <div class=\"bg-white rounded-xl shadow-sm border border-gray-100 p-8\">";
                $lines[] = "                <h3 class=\"font-semibold text-gray-900 mb-2\">{$field['label']}</h3>";
                $lines[] = "                <span class=\"text-xs font-semibold px-3 py-1 rounded-full {{ \${$var}->{$field['name']} ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}\">";
                $lines[] = "                    {{ \${$var}->{$field['name']} ? 'Ya' : 'Tidak' }}";
                $lines[] = "                </span>";
                $lines[] = "            </div>";
            } else {
                $lines[] = "            <div class=\"bg-white rounded-xl shadow-sm border border-gray-100 p-8\">";
                $lines[] = "                <h3 class=\"font-semibold text-gray-900 mb-2\">{$field['label']}</h3>";
                $lines[] = "                <p class=\"text-gray-700\">{{ \${$var}->{$field['name']} }}</p>";
                $lines[] = "            </div>";
            }
            $lines[] = '';
        }

        return implode("\n", $lines);
    }

    private function getFrontendShowContent(string $var): string
    {
        $lines = [];

        foreach ($this->config['fields'] as $field) {
            if ($field['type'] === 'file') {
                $lines[] = "        @if(\${$var}->{$field['name']})";
                $lines[] = "        <div class=\"mb-6\">";
                $lines[] = "            <img src=\"{{ asset('storage/' . \${$var}->{$field['name']}) }}\" alt=\"{{ \${$var}->{$this->config['fields'][0]['name']} }}\" class=\"w-full rounded-xl\">";
                $lines[] = "        </div>";
                $lines[] = "        @endif";
            } elseif ($field['type'] === 'textarea') {
                $lines[] = "        <div class=\"prose max-w-none mb-6\">";
                $lines[] = "            {!! nl2br(e(\${$var}->{$field['name']})) !!}";
                $lines[] = "        </div>";
            } elseif ($field['type'] !== 'boolean') {
                $lines[] = "        <div class=\"mb-4\">";
                $lines[] = "            <span class=\"text-sm text-gray-500\">{$field['label']}</span>";
                $lines[] = "            <p class=\"text-gray-900\">{{ \${$var}->{$field['name']} }}</p>";
                $lines[] = "        </div>";
            }
        }

        return implode("\n", $lines);
    }

    private function writeFile(string $path, string $content): void
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($path, $content);
        $this->created[] = str_replace('\\', '/', $path);
    }
}
