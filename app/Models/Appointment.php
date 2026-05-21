<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
  use HasFactory;

  protected $fillable = [
    'customer_id',
    'service_id',
    'starts_at',
    'ends_at',
    'notes',
    'status',
  ];

  protected $casts = [
    'starts_at' => 'datetime',
    'ends_at' => 'datetime',
  ];

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function service()
  {
    return $this->belongsTo(Service::class);
  }

  public function invoice()
  {
    return $this->hasOne(Invoice::class);
  }
}
