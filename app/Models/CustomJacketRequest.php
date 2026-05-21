<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomJacketRequest extends Model
{
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = [
    'user_id',
    'full_name',
    'email',
    'phone',
    'base_style',
    'primary_color',
    'secondary_color',
    'material',
    'sizes',
    'front_text',
    'custom_details',
    'inspiration_image',
    'quoted_price',
    'status',
    'admin_notes',
    'quoted_at',
    'approved_at',
  ];

  /**
   * The attributes that should be cast.
   */
  protected $casts = [
    'quoted_at' => 'datetime',
    'approved_at' => 'datetime',
    'quoted_price' => 'decimal:2',
    'sizes' => 'array',
  ];

  /**
   * Get the user associated with the request.
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
