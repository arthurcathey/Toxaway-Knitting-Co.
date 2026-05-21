<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slug',
    'description',
    'price',
    'category',
    'sizes',
    'image',
    'in_stock',
  ];

  protected $casts = [
    'price' => 'decimal:2',
    'in_stock' => 'boolean',
    'sizes' => 'array',
  ];

  public function getRouteKeyName()
  {
    return 'slug';
  }
}
