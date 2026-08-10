<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
  public function run(): void
  {
    // Define standard sizes and colors
    $sizes = ['sm', 'md', 'lg', 'xl', 'xxl'];
    $colors = ['navy', 'black', 'forest_green', 'burgundy', 'cream'];

    Product::updateOrCreate(
      ['slug' => 'wool-sweater-heavyweight'],
      [
        'name' => 'Wool Sweater — Heavyweight',
        'description' => '100% merino wool. Thick knit construction. Perfect for outdoor activities and everyday wear. Premium quality craftsmanship with reinforced seams. Temperature-regulating fibers keep you warm in winter and cool in summer.',
        'price' => 89.99,
        'category' => 'sweaters',
        'in_stock' => true,
        'sizes' => $sizes,
        'colors' => array_slice($colors, 0, 3),
      ]
    );

    Product::updateOrCreate(
      ['slug' => 'riding-sweater-merino'],
      [
        'name' => 'Riding Sweater — Merino',
        'description' => 'Premium merino blend. Designed for equestrian use. Breathable, durable, temperature-regulating. Specially tailored fit for riding positions with reinforced stitching at stress points. Machine washable and fade-resistant.',
        'price' => 129.99,
        'category' => 'riding',
        'in_stock' => true,
        'sizes' => $sizes,
        'colors' => array_slice($colors, 0, 3),
      ]
    );

    Product::updateOrCreate(
      ['slug' => 'tactical-sweater-rugged'],
      [
        'name' => 'Tactical Sweater — Rugged',
        'description' => 'Industrial-grade knit. Reinforced seams. Built for demanding work environments. Features double-stitched construction and stain-resistant treatment. Ideal for outdoor work, hiking, and adventure sports.',
        'price' => 99.99,
        'category' => 'sweaters',
        'in_stock' => true,
        'sizes' => $sizes,
        'colors' => array_slice($colors, 0, 3),
      ]
    );

    Product::updateOrCreate(
      ['slug' => 'coastal-sweater-weather-resistant'],
      [
        'name' => 'Coastal Sweater — Weather Resistant',
        'description' => 'Water-resistant finish. Sea-worthy construction. Perfect for maritime activities. Special coating protects against wind and moisture while maintaining breathability. Treated to resist salt water and UV damage.',
        'price' => 119.99,
        'category' => 'sweaters',
        'in_stock' => true,
        'sizes' => $sizes,
        'colors' => array_slice($colors, 0, 3),
      ]
    );

    Product::updateOrCreate(
      ['slug' => 'heritage-cardigan-classic'],
      [
        'name' => 'Heritage Cardigan — Classic',
        'description' => 'Timeless design. Hand-loomed construction. A wardrobe staple for generations. Each piece is individually crafted with attention to detail. Features traditional button placket and ribbed cuffs.',
        'price' => 159.99,
        'category' => 'sweaters',
        'in_stock' => true,
        'sizes' => $sizes,
        'colors' => array_slice($colors, 0, 3),
      ]
    );

    Product::updateOrCreate(
      ['slug' => 'custom-varsity-jacket'],
      [
        'name' => 'Custom Varsity Jacket',
        'description' => 'Design your own. Full personalization available. Consultation included with every custom order. Choose colors, materials, embroidery options, and sizing. Quote provided upon consultation.',
        'price' => 0,
        'category' => 'custom',
        'in_stock' => true,
      ]
    );
  }
}
