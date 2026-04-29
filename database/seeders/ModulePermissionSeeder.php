<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\UserLevel\Models\ModulePermission;

class ModulePermissionSeeder extends Seeder
{
    /**
     * Default: semua modul bisa diakses oleh semua role.
     * Developer selalu punya akses (enforced di middleware).
     */
    public function run(): void
    {
        $modules = [
            ['module_name' => 'posts.index',         'module_label' => 'Posts'],
            ['module_name' => 'products.index',       'module_label' => 'Products'],
            ['module_name' => 'categories.index',     'module_label' => 'Categories'],
            ['module_name' => 'services.index',       'module_label' => 'Services'],
            ['module_name' => 'abouts.index',         'module_label' => 'About'],
            ['module_name' => 'teams.index',          'module_label' => 'Teams'],
            ['module_name' => 'testimonials.index',   'module_label' => 'Testimonials'],
            ['module_name' => 'our-clients.index',    'module_label' => 'Our Clients'],
            ['module_name' => 'our-values.index',     'module_label' => 'Our Values'],
            ['module_name' => 'why-choose-us.index',  'module_label' => 'Why Choose Us'],
            ['module_name' => 'agendas.index',        'module_label' => 'Agendas'],
            ['module_name' => 'contacts.index',       'module_label' => 'Contacts'],
            ['module_name' => 'faqs.index',           'module_label' => 'FAQs'],
            ['module_name' => 'catalogs.index',       'module_label' => 'Catalogs'],
        ];

        foreach ($modules as $mod) {
            ModulePermission::firstOrCreate(
                ['module_name' => $mod['module_name']],
                [
                    'module_label'  => $mod['module_label'],
                    'allowed_roles' => ['admin', 'super_admin', 'developer'],
                ]
            );
        }

        $this->command->info('Module permissions seeded with default access (all roles).');
    }
}
