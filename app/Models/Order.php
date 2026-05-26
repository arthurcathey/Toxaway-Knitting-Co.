<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  protected $fillable = [
    'order_number',
    'user_id',
    'full_name',
    'email',
    'phone',
    'customer_name',
    'customer_email',
    'customer_phone',
    'shipping_address',
    'shipping_city',
    'shipping_state',
    'shipping_zip',
    'shipping_country',
    'subtotal',
    'shipping_cost',
    'tax',
    'total_amount',
    'total',
    'status',
    'payment_method',
    'stripe_charge_id',
    'paid_at',
    'notes',
  ];

  protected $casts = [
    'subtotal' => 'decimal:2',
    'shipping_cost' => 'decimal:2',
    'tax' => 'decimal:2',
    'total_amount' => 'decimal:2',
    'total' => 'decimal:2',
    'paid_at' => 'datetime',
  ];

  public function items()
  {
    return $this->hasMany(OrderItem::class);
  }

  public function generateOrderNumber()
  {
    return 'ORD-' . date('Y') . '-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
  }
}
