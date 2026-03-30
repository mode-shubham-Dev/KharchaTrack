<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@kharchatrack.com'],
            [
                'name'              => 'Admin',
                'password'          => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole($adminRole);

    
        User::whereDoesntHave('roles')->each(function ($user) use ($userRole) {
            $user->assignRole($userRole);
        });

        $this->command->info('Roles created and assigned successfully!');
    }
}