<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  use HasFactory;

  protected $fillable = [
    'customer_id',
    'appointment_id',
    'invoice_number',
    'status',
    'issued_at',
    'due_at',
    'subtotal',
    'tax_total',
    'total',
    'notes',
  ];

  protected $casts = [
    'issued_at' => 'date',
    'due_at' => 'date',
    'subtotal' => 'decimal:2',
    'tax_total' => 'decimal:2',
    'total' => 'decimal:2',
  ];

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function appointment()
  {
    return $this->belongsTo(Appointment::class);
  }

  public function items()
  {
    return $this->hasMany(InvoiceItem::class);
  }
}
