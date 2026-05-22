<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('cart_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('product_id')->constrained()->cascadeOnDelete();
      $table->string('product_name');
      $table->decimal('price', 10, 2);
      $table->integer('quantity')->default(1);
      $table->string('size');
      $table->timestamps();

      // Ensure each product with each size is unique per user
      $table->unique(['user_id', 'product_id', 'size']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('cart_items');
  }
};
