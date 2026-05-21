<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
  public function run(): void
  {
    // Create roles
    Role::create(['name' => 'super_admin']);
    Role::create(['name' => 'admin']);

    // Example permissions (can be extended)
    Permission::create(['name' => 'manage users']);
    Permission::create(['name' => 'manage customers']);
    Permission::create(['name' => 'manage invoices']);
    Permission::create(['name' => 'manage appointments']);
    Permission::create(['name' => 'view reports']);

    // Assign all permissions to super_admin
    $superAdminRole = Role::findByName('super_admin');
    $superAdminRole->givePermissionTo(Permission::all());

    // Assign subset to admin
    $adminRole = Role::findByName('admin');
    $adminRole->givePermissionTo([
      'manage customers',
      'manage invoices',
      'manage appointments',
    ]);
  }
}
