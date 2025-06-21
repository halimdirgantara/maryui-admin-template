<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default users with different roles
        $users = [
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@admin.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin'
            ],
            [
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role' => 'Admin'
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@admin.com',
                'password' => Hash::make('password'),
                'role' => 'Manager'
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@admin.com',
                'password' => Hash::make('password'),
                'role' => 'User'
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'email_verified_at' => now(),
                ]
            );

            // Assign role to user
            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->assignRole($role);
            }
        }

        // Create additional test users
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('User');
        });

        $this->command->info('Default users created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin: superadmin@admin.com / password');
        $this->command->info('Admin: admin@admin.com / password');
        $this->command->info('Manager: manager@admin.com / password');
        $this->command->info('User: user@admin.com / password');
    }
}
