<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'categories.view', 'group' => 'Category']);
        Permission::create(['name' => 'categories.create', 'group' => 'Category']);
        Permission::create(['name' => 'categories.edit', 'group' => 'Category']);
        Permission::create(['name' => 'categories.delete', 'group' => 'Category']);

        Permission::create(['name' => 'permissions.view', 'group' => 'Authority Management']);

        Permission::create(['name' => 'roles.view', 'group' => 'Authority Management']);
        Permission::create(['name' => 'roles.create', 'group' => 'Authority Management']);
        Permission::create(['name' => 'roles.edit', 'group' => 'Authority Management']);
        Permission::create(['name' => 'roles.delete', 'group' => 'Authority Management']);
    }
}
