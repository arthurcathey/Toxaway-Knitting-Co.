<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('custom_jacket_requests', function (Blueprint $table) {
      $table->json('sizes')->nullable()->after('material');
    });
  }

  public function down(): void
  {
    Schema::table('custom_jacket_requests', function (Blueprint $table) {
      $table->dropColumn('sizes');
    });
  }
};
