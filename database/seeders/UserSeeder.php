<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'role' => 'admin',
            'email' => 'superadmin@gmail.com',
            'password' => 'Password!',
            'status' => 'active',
        ]);

        $superAdmin->assignRole(1);

        $role = Role::with('permissions')->find(1);

        $superAdmin->syncPermissions($role->permissions);

        // Admin
        User::factory()->create([
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'Password!',
            'status' => 'active',
        ]);

        User::factory(100)->create(['role' => 'user']);
    }
}
