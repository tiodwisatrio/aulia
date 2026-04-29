<?php

namespace Database\Seeders;

use App\Modules\User\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin123'),
                'role' => 'super_admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'developer@example.com'],
            [
                'name' => 'Developer',
                'password' => Hash::make('developer123'),
                'role' => 'developer',
            ]
        );
    }
}
