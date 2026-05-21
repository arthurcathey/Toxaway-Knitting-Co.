<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'default_price',
    'default_duration_minutes',
    'is_active',
  ];

  protected $casts = [
    'default_price' => 'decimal:2',
    'is_active' => 'boolean',
  ];

  public function appointments()
  {
    return $this->hasMany(Appointment::class);
  }

  public function invoiceItems()
  {
    return $this->hasMany(InvoiceItem::class);
  }
}
