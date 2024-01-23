<?php

namespace Database\Seeders;

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

        Permission::create(['name' => 'products.view', 'group' => 'Product']);
        Permission::create(['name' => 'products.create', 'group' => 'Product']);
        Permission::create(['name' => 'products.edit', 'group' => 'Product']);
        Permission::create(['name' => 'products.delete', 'group' => 'Product']);

        Permission::create(['name' => 'product-reviews.view', 'group' => 'Product Review']);
        Permission::create(['name' => 'product-reviews.edit', 'group' => 'Product Review']);
        Permission::create(['name' => 'product-reviews.delete', 'group' => 'Product Review']);
        Permission::create(['name' => 'product-reviews.response', 'group' => 'Product Review']);

        Permission::create(['name' => 'daily-offers.view', 'group' => 'Daily Offer']);
        Permission::create(['name' => 'daily-offers.create', 'group' => 'Daily Offer']);
        Permission::create(['name' => 'daily-offers.edit', 'group' => 'Daily Offer']);
        Permission::create(['name' => 'daily-offers.delete', 'group' => 'Daily Offer']);

        Permission::create(['name' => 'coupons.view', 'group' => 'Coupon']);
        Permission::create(['name' => 'coupons.create', 'group' => 'Coupon']);
        Permission::create(['name' => 'coupons.edit', 'group' => 'Coupon']);
        Permission::create(['name' => 'coupons.delete', 'group' => 'Coupon']);

        Permission::create(['name' => 'delivery-areas.view', 'group' => 'Manage Shipping']);
        Permission::create(['name' => 'delivery-areas.create', 'group' => 'Manage Shipping']);
        Permission::create(['name' => 'delivery-areas.edit', 'group' => 'Manage Shipping']);
        Permission::create(['name' => 'delivery-areas.delete', 'group' => 'Manage Shipping']);

        Permission::create(['name' => 'shipping-methods.view', 'group' => 'Manage Shipping']);
        Permission::create(['name' => 'shipping-methods.create', 'group' => 'Manage Shipping']);
        Permission::create(['name' => 'shipping-methods.edit', 'group' => 'Manage Shipping']);
        Permission::create(['name' => 'shipping-methods.delete', 'group' => 'Manage Shipping']);

        Permission::create(['name' => 'blog-categories.view', 'group' => 'Manage Blog']);
        Permission::create(['name' => 'blog-categories.create', 'group' => 'Manage Blog']);
        Permission::create(['name' => 'blog-categories.edit', 'group' => 'Manage Blog']);
        Permission::create(['name' => 'blog-categories.delete', 'group' => 'Manage Blog']);

        Permission::create(['name' => 'permissions.view', 'group' => 'Authority Management']);

        Permission::create(['name' => 'roles.view', 'group' => 'Authority Management']);
        Permission::create(['name' => 'roles.create', 'group' => 'Authority Management']);
        Permission::create(['name' => 'roles.edit', 'group' => 'Authority Management']);
        Permission::create(['name' => 'roles.delete', 'group' => 'Authority Management']);
    }
}
