<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PermissionSeeder::class, // Create permissions and roles first
            SettingsSeeder::class,   // Create default settings
            UserSeeder::class,       // Create users and assign roles
            // RoleSeeder::class,    // Commented out as PermissionSeeder handles roles
            // SyncRoleToUser::class, // Commented out as UserSeeder handles role assignment
        ]);
    }
}
