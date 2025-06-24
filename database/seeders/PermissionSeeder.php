<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions based on menu structure
        $permissions = [
            // Dashboard permissions
            'dashboard.view',
            
            // User Management permissions
            'user-management.view',
            'user-management.user.view',
            'user-management.user.create',
            'user-management.user.edit',
            'user-management.user.delete',
            
            'user-management.role.view',
            'user-management.role.create',
            'user-management.role.edit',
            'user-management.role.delete',
            
            'user-management.permission.view',
            'user-management.permission.create',
            'user-management.permission.edit',
            'user-management.permission.delete',
            
            // Settings permissions
            'settings.view',
            'settings.general.view',
            'settings.general.edit',
            'settings.security.view',
            'settings.security.edit',
            'settings.notifications.view',
            'settings.notifications.edit',
            'settings.system.view',
            'settings.system.edit',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles and their permissions
        $rolePermissions = [
            'Super Admin' => $permissions, // All permissions
            
            'Admin' => [
                'dashboard.view',
                'user-management.view',
                'user-management.user.view',
                'user-management.user.create',
                'user-management.user.edit',
                'user-management.role.view',
                'user-management.role.create',
                'user-management.role.edit',
                'user-management.permission.view',
                'settings.view',
                'settings.general.view',
                'settings.general.edit',
                'settings.notifications.view',
                'settings.notifications.edit',
                'settings.system.view',
                'settings.system.edit',
            ],
            
            'Manager' => [
                'dashboard.view',
                'user-management.view',
                'user-management.user.view',
                'user-management.user.create',
                'user-management.user.edit',
                'user-management.role.view',
                'settings.view',
                'settings.general.view',
                'settings.notifications.view',
            ],
            
            'User' => [
                'dashboard.view',
                'settings.view',
                'settings.general.view',
                'settings.notifications.view',
            ],
        ];

        // Create roles and assign permissions
        foreach ($rolePermissions as $roleName => $rolePerms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePerms);
        }

        $this->command->info('Permissions and roles created successfully!');
    }
}