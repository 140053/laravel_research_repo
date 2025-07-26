<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Albums;
use App\Models\ResearchPaper;
class DevSeed extends Seeder
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



        Albums::factory()->count(10)->create();

        ResearchPaper::factory()->count(50)->create();

        ResearchPaper::factory()->journal()->count(20)->create();
        #ResearchPaper::factory()->conference()->count(15)->create();
        #ResearchPaper::factory()->thesis()->count(10)->create();
        #ResearchPaper::factory()->published()->featured()->count(5)->create();

        

        
    }
}
