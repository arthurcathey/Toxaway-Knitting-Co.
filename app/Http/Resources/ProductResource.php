<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'price' => (float) $this->price,
      'category' => $this->category,
      'sizes' => $this->sizes ?? [],
      'quantity_available' => (int) $this->quantity_available,
      'in_stock' => $this->quantity_available > 0,
      'image_url' => $this->image ? asset('storage/' . $this->image) : null,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}
