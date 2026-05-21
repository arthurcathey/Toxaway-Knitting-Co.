<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomJacketRequestResource extends JsonResource
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
      'user_id' => $this->user_id,
      'full_name' => $this->full_name,
      'email' => $this->email,
      'phone' => $this->phone,
      'base_style' => $this->base_style,
      'primary_color' => $this->primary_color,
      'secondary_color' => $this->secondary_color,
      'material' => $this->material,
      'sizes' => $this->sizes ?? [],
      'front_text' => $this->front_text,
      'custom_details' => $this->custom_details,
      'inspiration_image_url' => $this->inspiration_image ? asset('storage/custom-jackets/' . $this->inspiration_image) : null,
      'quoted_price' => $this->quoted_price ? (float) $this->quoted_price : null,
      'status' => $this->status,
      'admin_notes' => $this->admin_notes,
      'quoted_at' => $this->quoted_at,
      'approved_at' => $this->approved_at,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}
