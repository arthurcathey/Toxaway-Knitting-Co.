<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  public function up(): void
  {
    // Update all products with all available sizes
    DB::table('products')->update([
      'sizes' => json_encode(['sm', 'md', 'lg', 'xl', 'xxl']),
    ]);
  }

  public function down(): void
  {
    // Reset to empty
    DB::table('products')->update([
      'sizes' => null,
    ]);
  }
};
