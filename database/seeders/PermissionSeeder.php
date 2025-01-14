<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
  public function run(): void
  {
    $permissions = [
      // User permissions
      ['name' => 'view-users', 'display_name' => 'View Users', 'group' => 'User'],
      ['name' => 'create-users', 'display_name' => 'Create Users', 'group' => 'User'],
      ['name' => 'edit-users', 'display_name' => 'Edit Users', 'group' => 'User'],
      ['name' => 'delete-users', 'display_name' => 'Delete Users', 'group' => 'User'],

      // Role permissions
      ['name' => 'view-roles', 'display_name' => 'View Roles', 'group' => 'Role'],
      ['name' => 'create-roles', 'display_name' => 'Create Roles', 'group' => 'Role'],
      ['name' => 'edit-roles', 'display_name' => 'Edit Roles', 'group' => 'Role'],
      ['name' => 'delete-roles', 'display_name' => 'Delete Roles', 'group' => 'Role'],

      // Product permissions
      ['name' => 'view-products', 'display_name' => 'View Products', 'group' => 'Product'],
      ['name' => 'create-products', 'display_name' => 'Create Products', 'group' => 'Product'],
      ['name' => 'edit-products', 'display_name' => 'Edit Products', 'group' => 'Product'],
      ['name' => 'delete-products', 'display_name' => 'Delete Products', 'group' => 'Product'],

      // Category permissions
      ['name' => 'view-categories', 'display_name' => 'View Categories', 'group' => 'Category'],
      ['name' => 'create-categories', 'display_name' => 'Create Categories', 'group' => 'Category'],
      ['name' => 'edit-categories', 'display_name' => 'Edit Categories', 'group' => 'Category'],
      ['name' => 'delete-categories', 'display_name' => 'Delete Categories', 'group' => 'Category'],

      // Coupon permissions
      ['name' => 'view-coupons', 'display_name' => 'View Coupons', 'group' => 'Coupon'],
      ['name' => 'create-coupons', 'display_name' => 'Create Coupons', 'group' => 'Coupon'],
      ['name' => 'edit-coupons', 'display_name' => 'Edit Coupons', 'group' => 'Coupon'],
      ['name' => 'delete-coupons', 'display_name' => 'Delete Coupons', 'group' => 'Coupon'],
    ];

    foreach ($permissions as $permission) {
      Permission::updateOrCreate(
        ['name' => $permission['name']],
        $permission
      );
    }
  }
}
