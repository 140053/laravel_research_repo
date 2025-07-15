<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Make sure roles exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
       

        // Create admin user or get existing
        $admin = User::firstOrCreate(
            ['email' => 'admin@local.a'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('resrepo'),
                'email_verified_at' => now(),
            ]
        );

        // Assign role if not already assigned
        if (! $admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        // Optional: Add users
        $user = User::firstOrCreate(
            ['email' => 'user@local.a'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        
        if (! $user->hasRole('user')) {
            $user->assignRole($userRole);
        }

        

        
    }
}
