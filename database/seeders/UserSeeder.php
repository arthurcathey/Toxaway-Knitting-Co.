<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    // Create super admin user
    $superAdmin = User::firstOrCreate(
      ['email' => 'super@toxaway.test'],
      [
        'name' => 'Super Administrator',
        'password' => Hash::make('password123'),
      ]
    );
    $superAdmin->assignRole('super_admin');

    // Create admin user
    $admin = User::firstOrCreate(
      ['email' => 'admin@toxaway.test'],
      [
        'name' => 'Administrator',
        'password' => Hash::make('password123'),
      ]
    );
    $admin->assignRole('admin');

    // Create test customer service user
    $staff = User::firstOrCreate(
      ['email' => 'staff@toxaway.test'],
      [
        'name' => 'Staff Member',
        'password' => Hash::make('password123'),
      ]
    );
    $staff->assignRole('admin');
  }
}
