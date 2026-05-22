<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  protected $fillable = [
    'order_number',
    'customer_name',
    'customer_email',
    'customer_phone',
    'shipping_address',
    'shipping_city',
    'shipping_state',
    'shipping_zip',
    'subtotal',
    'shipping_cost',
    'total',
    'status',
    'notes',
  ];

  protected $casts = [
    'subtotal' => 'decimal:2',
    'shipping_cost' => 'decimal:2',
    'total' => 'decimal:2',
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
