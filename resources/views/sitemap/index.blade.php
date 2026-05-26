<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <!-- Homepage -->
  <url>
    <loc>{{ config('app.url') }}/</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
  </url>

  <!-- Main Pages -->
  <url>
    <loc>{{ config('app.url') }}/shop</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>daily</changefreq>
    <priority>0.9</priority>
  </url>

  <url>
    <loc>{{ config('app.url') }}/heritage</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>

  <url>
    <loc>{{ config('app.url') }}/craftsmanship</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>

  <url>
    <loc>{{ config('app.url') }}/contact</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>

  <url>
    <loc>{{ config('app.url') }}/custom-jacket</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>

  <!-- Products -->
  @foreach($products as $product)
  <url>
    <loc>{{ route('product.show', $product->slug) }}</loc>
    <lastmod>{{ $product->updated_at->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
  </url>
  @endforeach
</urlset>
