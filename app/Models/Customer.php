<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'email',
    'phone',
    'notes',
  ];

  public function appointments()
  {
    return $this->hasMany(Appointment::class);
  }

  public function invoices()
  {
    return $this->hasMany(Invoice::class);
  }
}
