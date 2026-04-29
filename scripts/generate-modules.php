<?php

/**
 * Module Generator Script
 * Generates modular structure for CMS features
 */

$basePath = __DIR__ . '/../app/Modules';
$postModulePath = $basePath . '/Post';

// List of modules to generate (copy from Post module)
$modules = [
    'Product' => [
        'table' => 'products',
        'singular' => 'product',
        'plural' => 'products',
    ],
    'Category' => [
        'table' => 'categories',
        'singular' => 'category',
        'plural' => 'categories',
    ],
    'Setting' => [
        'table' => 'settings',
        'singular' => 'setting',
        'plural' => 'settings',
    ],
    'Navigation' => [
        'table' => 'navigations',
        'singular' => 'navigation',
        'plural' => 'navigations',
    ],
    'Contact' => [
        'table' => 'contacts',
        'singular' => 'contact',
        'plural' => 'contacts',
    ],
    'Team' => [
        'table' => 'teams',
        'singular' => 'team',
        'plural' => 'teams',
    ],
    'Service' => [
        'table' => 'services',
        'singular' => 'service',
        'plural' => 'services',
    ],
    'Testimonial' => [
        'table' => 'testimonials',
        'singular' => 'testimonial',
        'plural' => 'testimonials',
    ],
    'About' => [
        'table' => 'abouts',
        'singular' => 'about',
        'plural' => 'abouts',
    ],
    'Agenda' => [
        'table' => 'agendas',
        'singular' => 'agenda',
        'plural' => 'agendas',
    ],
    'OurClient' => [
        'table' => 'ourclient',
        'singular' => 'ourclient',
        'plural' => 'ourclients',
    ],
    'OurValue' => [
        'table' => 'ourvalues',
        'singular' => 'ourvalue',
        'plural' => 'ourvalues',
    ],
    'WhyChooseUs' => [
        'table' => 'whychooseus',
        'singular' => 'whychooseus',
        'plural' => 'whychooseus',
    ],
];

function copyDirectory($source, $destination) {
    $command = PHP_OS_FAMILY === 'Windows'
        ? "xcopy \"$source\" \"$destination\" /E /I /Y"
        : "cp -r \"$source\" \"$destination\"";

    exec($command, $output, $return);
    return $return === 0;
}

function replaceInFile($filepath, $replacements) {
    if (!file_exists($filepath)) {
        return false;
    }

    $content = file_get_contents($filepath);

    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }

    file_put_contents($filepath, $content);
    return true;
}

function processModule($moduleName, $config, $postModulePath, $basePath) {
    $moduleDir = $basePath . '/' . $moduleName;

    // Copy Post module to new module dir
    echo "Copying Post module to $moduleName...";
    copyDirectory($postModulePath, $moduleDir);
    echo " ✓\n";

    // Rename files
    echo "Renaming files...";
    rename($moduleDir . '/PostServiceProvider.php', $moduleDir . '/' . $moduleName . 'ServiceProvider.php');
    rename($moduleDir . '/Models/Post.php', $moduleDir . '/Models/' . $moduleName . '.php');
    rename($moduleDir . '/Http/Requests/StorePostRequest.php', $moduleDir . '/Http/Requests/Store' . $moduleName . 'Request.php');
    rename($moduleDir . '/Http/Requests/UpdatePostRequest.php', $moduleDir . '/Http/Requests/Update' . $moduleName . 'Request.php');
    rename($moduleDir . '/Http/Controllers/Backend/PostController.php', $moduleDir . '/Http/Controllers/Backend/' . $moduleName . 'Controller.php');
    rename($moduleDir . '/Http/Controllers/Frontend/PostController.php', $moduleDir . '/Http/Controllers/Frontend/' . $moduleName . 'Controller.php');
    echo " ✓\n";

    // Find and replace in all files
    echo "Updating namespace and class names...";
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($moduleDir),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($files as $file) {
        if (!$file->isFile() || !in_array($file->getExtension(), ['php', 'blade'])) {
            continue;
        }

        $replacements = [
            'App\Modules\Post' => 'App\Modules\\' . $moduleName,
            'namespace App\Modules\Post' => 'namespace App\Modules\\' . $moduleName,
            'PostServiceProvider' => $moduleName . 'ServiceProvider',
            'PostController' => $moduleName . 'Controller',
            'StorePostRequest' => 'Store' . $moduleName . 'Request',
            'UpdatePostRequest' => 'Update' . $moduleName . 'Request',
            'class Post ' => 'class ' . $moduleName . ' ',
            "'post'" => "'" . strtolower($config['singular']) . "'",
            'unique:posts' => 'unique:' . $config['table'],
            '/blog' => '/' . $config['plural'],
            '{post:slug}' => '{' . $config['singular'] . ':slug}',
            'Judul post' => 'Judul ' . strtolower($moduleName),
            'Konten post' => 'Konten ' . strtolower($moduleName),
        ];

        replaceInFile($file->getPathname(), $replacements);
    }
    echo " ✓\n";

    echo "\n✅ Module $moduleName created successfully!\n";
}

// Generate all modules
echo "\n🔄 Starting Module Generation...\n";
echo "═════════════════════════════════════════\n\n";

foreach ($modules as $moduleName => $config) {
    echo "→ Creating $moduleName Module\n";
    processModule($moduleName, $config, $postModulePath, $basePath);
}

echo "═════════════════════════════════════════\n";
echo "✅ All modules generated successfully!\n\n";
echo "Next steps:\n";
echo "1. php artisan config:clear\n";
echo "2. php artisan cache:clear\n";
echo "3. Verify routes: php artisan route:list\n";
?>
