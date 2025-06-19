<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'Manage Users',
            'slug' => 'manage-users',
            'description' => 'Allows managing user accounts (create, edit, delete, assign permissions)',
        ]);

        Permission::create([
            'name' => 'Create Events',
            'slug' => 'create-events',
            'description' => 'Allows creating new events',
        ]);

        Permission::create([
            'name' => 'Edit Events',
            'slug' => 'edit-events',
            'description' => 'Allows editing existing events',
        ]);

        Permission::create([
            'name' => 'Delete Events',
            'slug' => 'delete-events',
            'description' => 'Allows deleting events',
        ]);

        Permission::create([
            'name' => 'Manage Groups',
            'slug' => 'manage-groups',
            'description' => 'Allows managing KPOP groups (create, edit, delete)',
        ]);

        Permission::create([
            'name' => 'Manage Music',
            'slug' => 'manage-music',
            'description' => 'Allows managing music (create, edit, delete)',
        ]);
        // Add more permissions as needed based on your RBAC system
    }
}