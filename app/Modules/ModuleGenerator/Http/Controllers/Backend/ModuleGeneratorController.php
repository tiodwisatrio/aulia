<?php

namespace App\Modules\ModuleGenerator\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use App\Modules\ModuleGenerator\Services\ModuleGeneratorService;

class ModuleGeneratorController extends Controller
{
    public function index()
    {
        return view('module-generator::backend.index');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'module_name'      => ['required', 'string', 'max:50', 'regex:/^[A-Z][a-zA-Z]*$/'],
            'table_name'       => ['required', 'string', 'max:64', 'regex:/^[a-z][a-z0-9_]*$/'],
            'include_frontend' => ['required', 'in:0,1'],
            'include_slug'     => ['required', 'in:0,1'],
            'fields'           => ['required', 'array', 'min:1'],
            'fields.*.name'    => ['required', 'string', 'max:64', 'regex:/^[a-z][a-z0-9_]*$/'],
            'fields.*.type'    => ['required', 'in:text,textarea,number,email,date,select,file,boolean'],
            'fields.*.label'   => ['required', 'string', 'max:100'],
            'fields.*.required' => ['required', 'in:0,1'],
            'fields.*.nullable' => ['required', 'in:0,1'],
        ], [
            'module_name.required' => 'Nama modul harus diisi.',
            'module_name.regex'    => 'Nama modul harus PascalCase (contoh: Gallery, OurClient).',
            'table_name.required'  => 'Nama tabel harus diisi.',
            'table_name.regex'     => 'Nama tabel harus snake_case (contoh: galleries, our_clients).',
            'fields.required'      => 'Minimal harus ada 1 field.',
            'fields.min'           => 'Minimal harus ada 1 field.',
            'fields.*.name.required' => 'Nama field harus diisi.',
            'fields.*.name.regex'    => 'Nama field harus snake_case (contoh: title, featured_image).',
            'fields.*.type.required' => 'Tipe field harus dipilih.',
            'fields.*.label.required' => 'Label field harus diisi.',
        ]);

        // Cast string values to integer
        $validated['include_frontend'] = (int) $validated['include_frontend'];
        $validated['include_slug'] = (int) $validated['include_slug'];

        foreach ($validated['fields'] as &$field) {
            $field['required'] = (int) $field['required'];
            $field['nullable'] = (int) $field['nullable'];
        }
        unset($field);

        // Check if module already exists
        $modulePath = app_path('Modules/' . $validated['module_name']);
        if (is_dir($modulePath)) {
            return back()
                ->withInput()
                ->with('error', 'Module "' . $validated['module_name'] . '" sudah ada.');
        }

        // Check if table already exists
        if (Schema::hasTable($validated['table_name'])) {
            return back()
                ->withInput()
                ->with('error', 'Tabel "' . $validated['table_name'] . '" sudah ada di database.');
        }

        // Check reserved field names
        $reservedNames = ['id', 'created_at', 'updated_at', 'status', 'order', 'slug'];
        foreach ($validated['fields'] as $field) {
            if (in_array($field['name'], $reservedNames)) {
                return back()
                    ->withInput()
                    ->with('error', 'Nama field "' . $field['name'] . '" sudah digunakan secara otomatis oleh sistem.');
            }
        }

        // Check duplicate field names
        $fieldNames = array_column($validated['fields'], 'name');
        if (count($fieldNames) !== count(array_unique($fieldNames))) {
            return back()
                ->withInput()
                ->with('error', 'Terdapat nama field yang duplikat.');
        }

        try {
            $service = new ModuleGeneratorService($validated);
            $result = $service->generate();

            // Clear bootstrap cache to register new service provider
            $this->clearBootstrapCache();

            // Refresh composer autoload to load new classes
            $this->refreshAutoload();

            // Dynamically register and boot the new service provider
            $providerClass = "App\\Modules\\{$validated['module_name']}\\{$validated['module_name']}ServiceProvider";
            if (class_exists($providerClass)) {
                $provider = app()->register($providerClass);
                // Boot the provider to load routes
                if ($provider && method_exists($provider, 'boot')) {
                    $provider->boot();
                }
            }

            return view('module-generator::backend.success', [
                'moduleName' => $validated['module_name'],
                'result'     => $result,
            ]);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal generate module: ' . $e->getMessage());
        }
    }

    public function migrate()
    {
        try {
            Artisan::call('migrate');
            $output = Artisan::output();

            return redirect()->route('module-generator.index')
                ->with('success', 'Migration berhasil dijalankan! ' . trim($output));
        } catch (\Exception $e) {
            return redirect()->route('module-generator.index')
                ->with('error', 'Migration gagal: ' . $e->getMessage());
        }
    }

    /**
     * Clear bootstrap cache files to allow new service provider registration
     */
    protected function clearBootstrapCache(): void
    {
        $cacheFiles = [
            'bootstrap/cache/packages.php',
            'bootstrap/cache/services.php',
        ];

        foreach ($cacheFiles as $file) {
            $path = base_path($file);
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        // Also clear Laravel's config and route cache
        Artisan::call('config:clear');
        Artisan::call('route:clear');
    }

    /**
     * Refresh composer autoload to load new classes
     */
    protected function refreshAutoload(): void
    {
        // Reload composer's class loader
        $autoloadFile = base_path('vendor/autoload.php');
        if (file_exists($autoloadFile)) {
            require $autoloadFile;
        }
    }
}
