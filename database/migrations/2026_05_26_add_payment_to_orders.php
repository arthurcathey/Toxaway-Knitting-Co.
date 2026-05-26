<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('orders', function (Blueprint $table) {
      // Check if columns don't already exist
      if (!Schema::hasColumn('orders', 'user_id')) {
        $table->unsignedBigInteger('user_id')->nullable();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
      }

      if (!Schema::hasColumn('orders', 'full_name')) {
        $table->string('full_name')->nullable();
      }

      if (!Schema::hasColumn('orders', 'email')) {
        $table->string('email')->nullable();
      }

      if (!Schema::hasColumn('orders', 'phone')) {
        $table->string('phone')->nullable();
      }

      if (!Schema::hasColumn('orders', 'shipping_country')) {
        $table->string('shipping_country')->default('United States');
      }

      if (!Schema::hasColumn('orders', 'tax')) {
        $table->decimal('tax', 10, 2)->default(0);
      }

      if (!Schema::hasColumn('orders', 'total_amount')) {
        $table->decimal('total_amount', 10, 2)->nullable();
      }

      if (!Schema::hasColumn('orders', 'payment_method')) {
        $table->string('payment_method')->nullable();
      }

      if (!Schema::hasColumn('orders', 'stripe_charge_id')) {
        $table->string('stripe_charge_id')->nullable()->unique();
      }

      if (!Schema::hasColumn('orders', 'paid_at')) {
        $table->timestamp('paid_at')->nullable();
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('orders', function (Blueprint $table) {
      if (Schema::hasColumn('orders', 'user_id')) {
        $table->dropForeign(['user_id']);
      }

      $columnsToDrop = [];
      foreach (['user_id', 'full_name', 'email', 'phone', 'shipping_country', 'tax', 'total_amount', 'payment_method', 'stripe_charge_id', 'paid_at'] as $column) {
        if (Schema::hasColumn('orders', $column)) {
          $columnsToDrop[] = $column;
        }
      }

      if (!empty($columnsToDrop)) {
        $table->dropColumn($columnsToDrop);
      }
    });
  }
};
