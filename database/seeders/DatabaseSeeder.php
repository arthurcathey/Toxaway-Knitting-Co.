<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
    // Order matters: roles first, then users
    $this->call([
      RolesAndPermissionsSeeder::class,
      UserSeeder::class,
    ]);
  }
}
