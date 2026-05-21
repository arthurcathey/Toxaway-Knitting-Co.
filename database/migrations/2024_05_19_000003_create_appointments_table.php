<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('appointments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
      $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null');
      $table->dateTime('starts_at');
      $table->dateTime('ends_at')->nullable();
      $table->text('notes')->nullable();
      $table->enum('status', ['requested', 'scheduled', 'completed', 'paid', 'canceled'])->default('requested');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('appointments');
  }
};
