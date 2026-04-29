<?php

namespace App\Support;

use Illuminate\Support\Arr;

class ModuleManager
{
    /**
     * Base modules path
     */
    protected string $basePath;

    /**
     * All discovered modules
     */
    protected array $modules = [];

    public function __construct()
    {
        $this->basePath = app_path('Modules');
    }

    /**
     * Discover all modules in the Modules directory
     */
    public function discover(): array
    {
        if (!is_dir($this->basePath)) {
            return [];
        }

        $directories = array_filter(scandir($this->basePath), function ($dir) {
            return $dir !== '.' && $dir !== '..' && is_dir("{$this->basePath}/{$dir}");
        });

        foreach ($directories as $moduleName) {
            $this->registerModule($moduleName);
        }

        return $this->modules;
    }

    /**
     * Register a single module
     */
    protected function registerModule(string $moduleName): void
    {
        $modulePath = "{$this->basePath}/{$moduleName}";
        $providerClass = "App\\Modules\\{$moduleName}\\{$moduleName}ServiceProvider";

        if (class_exists($providerClass)) {
            $this->modules[$moduleName] = [
                'path' => $modulePath,
                'provider' => $providerClass,
                'enabled' => true,
            ];
        }
    }

    /**
     * Get all registered modules
     */
    public function getModules(): array
    {
        return $this->modules;
    }

    /**
     * Get a specific module
     */
    public function getModule(string $name): ?array
    {
        return Arr::get($this->modules, $name);
    }

    /**
     * Check if module exists
     */
    public function hasModule(string $name): bool
    {
        return isset($this->modules[$name]);
    }

    /**
     * Get all module providers
     */
    public function getProviders(): array
    {
        return array_column($this->modules, 'provider');
    }
}
