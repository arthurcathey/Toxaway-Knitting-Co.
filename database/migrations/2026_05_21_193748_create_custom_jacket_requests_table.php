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
    Schema::create('custom_jacket_requests', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
      $table->string('full_name');
      $table->string('email');
      $table->string('phone');
      $table->string('base_style'); // Classic Varsity Cut, Oversized Fit, etc.
      $table->string('primary_color'); // Body color
      $table->string('secondary_color'); // Sleeve color
      $table->string('material'); // Wool, Wool Blend, Linen Blend, Leather
      $table->string('front_text'); // Letters/text for front
      $table->longText('custom_details')->nullable(); // Additional specifications
      $table->string('inspiration_image')->nullable(); // Uploaded reference image
      $table->decimal('quoted_price', 10, 2)->nullable(); // Quote price
      $table->enum('status', ['pending', 'quoted', 'approved', 'in_production', 'completed', 'cancelled'])->default('pending');
      $table->text('admin_notes')->nullable(); // Internal notes for admin
      $table->timestamp('quoted_at')->nullable();
      $table->timestamp('approved_at')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('custom_jacket_requests');
  }
};
