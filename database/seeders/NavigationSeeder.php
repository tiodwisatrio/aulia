<?php
namespace Database\Seeders;

use App\Modules\Navigation\Models\Navigation;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    public function run(): void
    {
        $navigations = [
            ['menu_label' => 'Dashboard',        'menu_route' => 'dashboard',          'menu_ikon' => 'home',          'menu_urutan' => 0,  'menu_status' => 1],
            ['menu_label' => 'Posts',             'menu_route' => 'posts.index',        'menu_ikon' => 'file-text',     'menu_urutan' => 1,  'menu_status' => 1],
            ['menu_label' => 'Products',          'menu_route' => 'products.index',     'menu_ikon' => 'package',       'menu_urutan' => 2,  'menu_status' => 1],
            ['menu_label' => 'About',             'menu_route' => 'abouts.index',       'menu_ikon' => 'info',          'menu_urutan' => 3,  'menu_status' => 1],
            ['menu_label' => 'Services',          'menu_route' => 'services.index',     'menu_ikon' => 'briefcase',     'menu_urutan' => 4,  'menu_status' => 1],
            ['menu_label' => 'Why Choose Us',     'menu_route' => 'whychooseus.index',  'menu_ikon' => 'help-circle',   'menu_urutan' => 5,  'menu_status' => 1],
            ['menu_label' => 'Agenda',            'menu_route' => 'agendas.index',      'menu_ikon' => 'calendar',      'menu_urutan' => 6,  'menu_status' => 1],
            ['menu_label' => 'Our Values',        'menu_route' => 'ourvalues.index',    'menu_ikon' => 'star',          'menu_urutan' => 7,  'menu_status' => 1],
            ['menu_label' => 'Our Clients',       'menu_route' => 'ourclient.index',    'menu_ikon' => 'users',         'menu_urutan' => 8,  'menu_status' => 1],
            ['menu_label' => 'Testimonials',      'menu_route' => 'testimonials.index', 'menu_ikon' => 'message-square','menu_urutan' => 9,  'menu_status' => 1],
            ['menu_label' => 'Our Team',          'menu_route' => 'teams.index',        'menu_ikon' => 'users-2',       'menu_urutan' => 10, 'menu_status' => 1],
            ['menu_label' => 'Contact Messages',  'menu_route' => 'contacts.index',     'menu_ikon' => 'mail',          'menu_urutan' => 11, 'menu_status' => 1],
        ];

        foreach ($navigations as $nav) {
            Navigation::updateOrCreate(
                ['menu_route' => $nav['menu_route']],
                $nav
            );
        }
    }
}
