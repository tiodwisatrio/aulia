<?php

/**
 * Module Migration Script
 * Migrates logic from old controllers/models to new module structure
 */

$basePath = __DIR__ . '/..';
$appPath = $basePath . '/app';
$modulesPath = $appPath . '/Modules';

// Modules mapping
$modules = [
    'Post' => [
        'oldController' => 'App\Http\Controllers\Backend\PostController',
        'oldFrontendController' => 'App\Http\Controllers\Frontend\PostController',
        'oldModel' => 'App\Models\Post',
        'newModel' => 'App\Modules\Post\Models\Post',
        'newController' => 'App\Modules\Post\Http\Controllers\Backend\PostController',
        'newFrontendController' => 'App\Modules\Post\Http\Controllers\Frontend\PostController',
    ],
    'Product' => [
        'oldController' => 'App\Http\Controllers\Backend\ProductController',
        'oldFrontendController' => 'App\Http\Controllers\Frontend\ProductController',
        'oldModel' => 'App\Models\Product',
        'newModel' => 'App\Modules\Product\Models\Product',
        'newController' => 'App\Modules\Product\Http\Controllers\Backend\ProductController',
        'newFrontendController' => 'App\Modules\Product\Http\Controllers\Frontend\ProductController',
    ],
    'Category' => [
        'oldController' => 'App\Http\Controllers\Backend\CategoryController',
        'oldModel' => 'App\Models\Category',
        'newModel' => 'App\Modules\Category\Models\Category',
        'newController' => 'App\Modules\Category\Http\Controllers\Backend\CategoryController',
    ],
    'Contact' => [
        'oldController' => 'App\Http\Controllers\Backend\ContactController',
        'oldModel' => 'App\Models\ContactMessage',
        'newModel' => 'App\Modules\Contact\Models\Contact',
        'newController' => 'App\Modules\Contact\Http\Controllers\Backend\ContactController',
    ],
    'Team' => [
        'oldController' => 'App\Http\Controllers\Backend\TeamController',
        'oldModel' => 'App\Models\Team',
        'newModel' => 'App\Modules\Team\Models\Team',
        'newController' => 'App\Modules\Team\Http\Controllers\Backend\TeamController',
    ],
    'Service' => [
        'oldController' => 'App\Http\Controllers\Backend\ServiceController',
        'oldModel' => 'App\Models\Service',
        'newModel' => 'App\Modules\Service\Models\Service',
        'newController' => 'App\Modules\Service\Http\Controllers\Backend\ServiceController',
    ],
    'Testimonial' => [
        'oldController' => 'App\Http\Controllers\Backend\TestimonialController',
        'oldModel' => 'App\Models\Testimonial',
        'newModel' => 'App\Modules\Testimonial\Models\Testimonial',
        'newController' => 'App\Modules\Testimonial\Http\Controllers\Backend\TestimonialController',
    ],
    'About' => [
        'oldController' => 'App\Http\Controllers\Backend\AboutController',
        'oldModel' => 'App\Models\About',
        'newModel' => 'App\Modules\About\Models\About',
        'newController' => 'App\Modules\About\Http\Controllers\Backend\AboutController',
    ],
    'Agenda' => [
        'oldController' => 'App\Http\Controllers\Backend\AgendaController',
        'oldModel' => 'App\Models\Agenda',
        'newModel' => 'App\Modules\Agenda\Models\Agenda',
        'newController' => 'App\Modules\Agenda\Http\Controllers\Backend\AgendaController',
    ],
    'OurClient' => [
        'oldController' => 'App\Http\Controllers\Backend\OurClientController',
        'oldModel' => 'App\Models\OurClient',
        'newModel' => 'App\Modules\OurClient\Models\OurClient',
        'newController' => 'App\Modules\OurClient\Http\Controllers\Backend\OurClientController',
    ],
    'OurValue' => [
        'oldController' => 'App\Http\Controllers\Backend\OurValueController',
        'oldModel' => 'App\Models\OurValue',
        'newModel' => 'App\Modules\OurValue\Models\OurValue',
        'newController' => 'App\Modules\OurValue\Http\Controllers\Backend\OurValueController',
    ],
    'WhyChooseUs' => [
        'oldController' => 'App\Http\Controllers\Backend\WhyChooseUsController',
        'oldModel' => 'App\Models\WhyChooseUs',
        'newModel' => 'App\Modules\WhyChooseUs\Models\WhyChooseUs',
        'newController' => 'App\Modules\WhyChooseUs\Http\Controllers\Backend\WhyChooseUsController',
    ],
];

function copyFile($source, $destination) {
    if (!file_exists($source)) {
        return false;
    }
    return copy($source, $destination);
}

function migrateModel($moduleName, $config) {
    global $appPath, $modulesPath;

    // Extract old model name from path
    $oldModelPath = str_replace('\\', '/', $config['oldModel']);
    $parts = explode('/', $oldModelPath);
    $modelFile = end($parts) . '.php';
    $oldPath = $appPath . '/Models/' . $modelFile;

    if (!file_exists($oldPath)) {
        return false;
    }

    // Copy to module
    $newPath = $modulesPath . '/' . $moduleName . '/Models/' . $modelFile;

    $content = file_get_contents($oldPath);

    // Update namespace
    $content = str_replace(
        'namespace App\Models;',
        'namespace App\Modules\\' . $moduleName . '\Models;',
        $content
    );

    // Update User import if exists
    $content = str_replace(
        'use App\Models\User;',
        'use App\Modules\User\Models\User;',
        $content
    );

    file_put_contents($newPath, $content);

    return true;
}

function migrateController($moduleName, $oldPath, $newPath, $controllerType = 'backend') {
    if (!file_exists($oldPath)) {
        return false;
    }

    $content = file_get_contents($oldPath);

    // Update namespaces and imports based on controller type
    if ($controllerType === 'backend') {
        $content = str_replace(
            'namespace App\Http\Controllers\Backend;',
            'namespace App\Modules\\' . $moduleName . '\Http\Controllers\Backend;',
            $content
        );
    } else {
        $content = str_replace(
            'namespace App\Http\Controllers\Frontend;',
            'namespace App\Modules\\' . $moduleName . '\Http\Controllers\Frontend;',
            $content
        );
    }

    // Update model imports
    $content = str_replace(
        'use App\Models\\' . $moduleName,
        'use App\Modules\\' . $moduleName . '\Models\\' . $moduleName,
        $content
    );

    // Update User import
    $content = str_replace(
        'use App\Models\User;',
        'use App\Modules\User\Models\User;',
        $content
    );

    file_put_contents($newPath, $content);

    return true;
}

echo "\n🔄 Starting Module Migration...\n";
echo "═════════════════════════════════════════\n\n";

$migratedCount = 0;

foreach ($modules as $moduleName => $config) {
    echo "→ Migrating $moduleName Module\n";

    // Migrate model
    if (isset($config['oldModel'])) {
        echo "  • Migrating model... ";
        if (migrateModel($moduleName, $config)) {
            echo "✓\n";
        } else {
            echo "⚠ (not found, skipped)\n";
        }
    }

    // Migrate backend controller
    if (isset($config['oldController'])) {
        $controllerFile = str_replace('App\Http\Controllers\Backend\\', '', $config['oldController']) . '.php';
        $oldPath = $appPath . '/Http/Controllers/Backend/' . $controllerFile;
        $newPath = $modulesPath . '/' . $moduleName . '/Http/Controllers/Backend/' . $controllerFile;

        echo "  • Migrating backend controller... ";
        if (migrateController($moduleName, $oldPath, $newPath, 'backend')) {
            echo "✓\n";
        } else {
            echo "⚠ (not found, skipped)\n";
        }
    }

    // Migrate frontend controller
    if (isset($config['oldFrontendController'])) {
        $controllerFile = str_replace('App\Http\Controllers\Frontend\\', '', $config['oldFrontendController']) . '.php';
        $oldPath = $appPath . '/Http/Controllers/Frontend/' . $controllerFile;
        $newPath = $modulesPath . '/' . $moduleName . '/Http/Controllers/Frontend/' . $controllerFile;

        echo "  • Migrating frontend controller... ";
        if (migrateController($moduleName, $oldPath, $newPath, 'frontend')) {
            echo "✓\n";
        } else {
            echo "⚠ (not found, skipped)\n";
        }
    }

    echo "\n";
    $migratedCount++;
}

echo "═════════════════════════════════════════\n";
echo "✅ Module migration complete!\n";
echo "   Processed: $migratedCount modules\n\n";
echo "Next steps:\n";
echo "1. Verify all modules in app/Modules/\n";
echo "2. Update routes/web.php\n";
echo "3. Delete old app/Http/Controllers files\n";
echo "4. Delete old app/Models files\n";
echo "5. php artisan config:clear && php artisan cache:clear\n";
?>
