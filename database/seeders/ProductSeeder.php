<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
  public function run(): void
  {
    Product::create([
      'name' => 'Wool Sweater — Heavyweight',
      'slug' => 'wool-sweater-heavyweight',
      'description' => '100% merino wool. Thick knit construction. Perfect for outdoor activities and everyday wear. Premium quality craftsmanship with reinforced seams. Temperature-regulating fibers keep you warm in winter and cool in summer.',
      'price' => 89.99,
      'category' => 'sweaters',
      'in_stock' => true,
    ]);

    Product::create([
      'name' => 'Riding Sweater — Merino',
      'slug' => 'riding-sweater-merino',
      'description' => 'Premium merino blend. Designed for equestrian use. Breathable, durable, temperature-regulating. Specially tailored fit for riding positions with reinforced stitching at stress points. Machine washable and fade-resistant.',
      'price' => 129.99,
      'category' => 'riding',
      'in_stock' => true,
    ]);

    Product::create([
      'name' => 'Tactical Sweater — Rugged',
      'slug' => 'tactical-sweater-rugged',
      'description' => 'Industrial-grade knit. Reinforced seams. Built for demanding work environments. Features double-stitched construction and stain-resistant treatment. Ideal for outdoor work, hiking, and adventure sports.',
      'price' => 99.99,
      'category' => 'sweaters',
      'in_stock' => true,
    ]);

    Product::create([
      'name' => 'Coastal Sweater — Weather Resistant',
      'slug' => 'coastal-sweater-weather-resistant',
      'description' => 'Water-resistant finish. Sea-worthy construction. Perfect for maritime activities. Special coating protects against wind and moisture while maintaining breathability. Treated to resist salt water and UV damage.',
      'price' => 119.99,
      'category' => 'sweaters',
      'in_stock' => true,
    ]);

    Product::create([
      'name' => 'Heritage Cardigan — Classic',
      'slug' => 'heritage-cardigan-classic',
      'description' => 'Timeless design. Hand-loomed construction. A wardrobe staple for generations. Each piece is individually crafted with attention to detail. Features traditional button placket and ribbed cuffs.',
      'price' => 159.99,
      'category' => 'sweaters',
      'in_stock' => true,
    ]);

    Product::create([
      'name' => 'Custom Varsity Jacket',
      'slug' => 'custom-varsity-jacket',
      'description' => 'Design your own. Full personalization available. Consultation included with every custom order. Choose colors, materials, embroidery options, and sizing. Quote provided upon consultation.',
      'price' => 0,
      'category' => 'custom',
      'in_stock' => true,
    ]);
  }
}
