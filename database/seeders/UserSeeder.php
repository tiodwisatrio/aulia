<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Developer user if not exists
        if (!User::where('email', 'tiodwisatrio27@gmail.com')->exists()) {
            User::create([
                'name' => 'Developer',
                'email' => 'tiodwisatrio27@gmail.com',
                'password' => Hash::make('developer123'),
                'role' => 'developer',
                'email_verified_at' => now(),
            ]);
            $this->command->info('✓ Developer user created');
        } else {
            // Update existing user to developer role
            User::where('email', 'tiodwisatrio27@gmail.com')->update([
                'role' => 'developer',
                'password' => Hash::make('developer123'),
            ]);
            $this->command->info('✓ Developer user updated');
        }

        // Create Super Admin user if not exists
        if (!User::where('email', 'tiodwisatrio7@gmail.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'tiodwisatrio7@gmail.com',
                'password' => Hash::make('superadmin123'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]);
            $this->command->info('✓ Super Admin user created');
        } else {
            // Update existing user to super_admin role
            User::where('email', 'tiodwisatrio7@gmail.com')->update([
                'role' => 'super_admin',
                'password' => Hash::make('superadmin123'),
            ]);
            $this->command->info('✓ Super Admin user updated');
        }

        // Create Admin user if not exists
        if (!User::where('email', 'tiodwisatrio270@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'tiodwisatrio270@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            $this->command->info('✓ Admin user created');
        } else {
            // Update existing user to admin role
            User::where('email', 'tiodwisatrio270@gmail.com')->update([
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]);
            $this->command->info('✓ Admin user updated');
        }

        $this->command->info('');
        $this->command->info('=== Users Credentials ===');
        $this->command->info('Developer: tiodwisatrio27@gmail.com / developer123');
        $this->command->info('Super Admin: tiodwisatrio7@gmail.com / superadmin123');
        $this->command->info('Admin: tiodwisatrio270@gmail.com / admin123');
    }
}
