<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $roles = [
      [
        'name' => 'super-admin',
        'display_name' => 'Super Admin',
        'group' => 'system',
      ],
      [
        'name' => 'admin',
        'display_name' => 'Admin',
        'group' => 'system',
      ],
      [
        'name' => 'employee',
        'display_name' => 'Employee',
        'group' => 'system',
      ],
      [
        'name' => 'user',
        'display_name' => 'User',
        'group' => 'system',
      ],
    ];

    foreach ($roles as $role) {
      $createdRole = Role::updateOrCreate(
        ['name' => $role['name']],
        $role
      );

      // Give all permissions to super-admin
      if ($role['name'] === 'super-admin') {
        $allPermissions = Permission::all();
        $createdRole->syncPermissions($allPermissions);
      }
    }
  }
}
