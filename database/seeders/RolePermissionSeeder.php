<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */
        $permissions = [
            [
                'name' => 'view posts',
                'description' => 'Can view all posts'
            ],
            [
                'name' => 'create posts',
                'description' => 'Can create new posts'
            ],
            [
                'name' => 'edit posts',
                'description' => 'Can edit existing posts'
            ],
            [
                'name' => 'delete posts',
                'description' => 'Can delete posts'
            ],
            [
                'name' => 'manage users',
                'description' => 'Can manage user accounts'
            ],
            [
                'name' => 'manage roles',
                'description' => 'Can manage roles and permissions'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['description' => $permission['description']]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Roles with TYPE & DESCRIPTION
        |--------------------------------------------------------------------------
        */

        // Super Admin (System Owner)
        $superAdmin = Role::firstOrCreate(
            ['name' => 'superadmin'],
            [
                'type' => 'system',
                'description' => 'Full system access. Can manage everything including roles, users, and permissions.'
            ]
        );

        // Admin (Profession-based managers)
        $admin = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'type' => 'teacher, doctor, staff',
                'description' => 'Manages users and content within their assigned department or profession.'
            ]
        );

        // User (Regular users)
        $user = Role::firstOrCreate(
            ['name' => 'user'],
            [
                'type' => 'student, patient, client',
                'description' => 'Basic user with limited access to create and view content.'
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions to Roles
        |--------------------------------------------------------------------------
        */

        // Super Admin → Everything
        $superAdmin->syncPermissions(Permission::all());

        // Admin → Content + User management
        $admin->syncPermissions([
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'manage users',
        ]);

        // User → Basic permissions
        $user->syncPermissions([
            'view posts',
            'create posts',
        ]);
    }
}
