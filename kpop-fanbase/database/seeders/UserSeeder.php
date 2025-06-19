<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'type' => 'admin',
            'email_verified_at' => now(),
            'birth_date' => '1990-01-01',
        ]);

        // Manager User
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'type' => 'manager',
            'email_verified_at' => now(),
            'birth_date' => '1995-05-10',
        ]);

        // Fan User
        $fan = User::create([
            'name' => 'Fan User',
            'email' => 'fan@example.com',
            'password' => Hash::make('password'),
            'type' => 'fan',
            'email_verified_at' => now(),
            'birth_date' => '2000-11-20',
        ]);

        // Assign all permissions to admin
        $adminPermissions = Permission::all();
        $admin->permissions()->sync($adminPermissions->pluck('id'));

        // Assign specific permissions to manager (e.g., create events, manage groups)
        $managerPermissions = Permission::whereIn('slug', ['create-events', 'manage-groups', 'manage-music'])->get();
        $manager->permissions()->sync($managerPermissions->pluck('id'));
    }
}