<?php

namespace App\Services;

class SeoService
{
  private string $title = '';
  private string $description = '';
  private string $url = '';
  private string $image = '';
  private array $keywords = [];
  private string $type = 'website';
  private array $structured_data = [];

  public function setTitle(string $title): self
  {
    $this->title = $title;
    return $this;
  }

  public function setDescription(string $description): self
  {
    // Limit to 160 characters for optimal display
    $this->description = substr($description, 0, 160);
    return $this;
  }

  public function setUrl(string $url): self
  {
    $this->url = $url;
    return $this;
  }

  public function setImage(string $image): self
  {
    $this->image = $image;
    return $this;
  }

  public function setKeywords(array $keywords): self
  {
    $this->keywords = array_slice($keywords, 0, 10); // Limit to 10 keywords
    return $this;
  }

  public function setType(string $type): self
  {
    $this->type = $type;
    return $this;
  }

  public function setStructuredData(array $data): self
  {
    $this->structured_data = $data;
    return $this;
  }

  public function getTitle(): string
  {
    return $this->title ?: 'Toxaway Knitting Co. | Handmade American Knitwear';
  }

  public function getDescription(): string
  {
    return $this->description ?: 'Premium, heavyweight, American-made knitwear with meticulous attention to craft. Handcrafted sweaters and custom jackets made to last.';
  }

  public function getUrl(): string
  {
    return $this->url ?: config('app.url');
  }

  public function getImage(): string
  {
    return $this->image ?: asset('images/og-image.png');
  }

  public function getKeywords(): string
  {
    $keywords = $this->keywords ?: [
      'handmade knitwear',
      'American made sweaters',
      'custom jackets',
      'wool sweaters',
      'sustainable fashion',
    ];
    return implode(', ', $keywords);
  }

  public function getMetaTags(): string
  {
    $html = '<meta name="description" content="' . htmlspecialchars($this->getDescription(), ENT_QUOTES) . '">' . "\n";
    $html .= '<meta name="keywords" content="' . htmlspecialchars($this->getKeywords(), ENT_QUOTES) . '">' . "\n";
    $html .= '<meta name="theme-color" content="#1c1917">' . "\n";

    // Open Graph Tags
    $html .= '<meta property="og:type" content="' . htmlspecialchars($this->type) . '">' . "\n";
    $html .= '<meta property="og:title" content="' . htmlspecialchars($this->getTitle(), ENT_QUOTES) . '">' . "\n";
    $html .= '<meta property="og:description" content="' . htmlspecialchars($this->getDescription(), ENT_QUOTES) . '">' . "\n";
    $html .= '<meta property="og:url" content="' . htmlspecialchars($this->getUrl(), ENT_QUOTES) . '">' . "\n";
    $html .= '<meta property="og:image" content="' . htmlspecialchars($this->getImage(), ENT_QUOTES) . '">' . "\n";
    $html .= '<meta property="og:site_name" content="Toxaway Knitting Co.">' . "\n";

    // Twitter Card Tags
    $html .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
    $html .= '<meta name="twitter:title" content="' . htmlspecialchars($this->getTitle(), ENT_QUOTES) . '">' . "\n";
    $html .= '<meta name="twitter:description" content="' . htmlspecialchars($this->getDescription(), ENT_QUOTES) . '">' . "\n";
    $html .= '<meta name="twitter:image" content="' . htmlspecialchars($this->getImage(), ENT_QUOTES) . '">' . "\n";

    return $html;
  }

  public function getStructuredData(): string
  {
    if (empty($this->structured_data)) {
      return '';
    }

    return '<script type="application/ld+json">' . json_encode($this->structured_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
  }

  public static function productSchema($product): array
  {
    return [
      '@context' => 'https://schema.org/',
      '@type' => 'Product',
      'name' => $product->name,
      'description' => $product->description,
      'image' => asset('images/products/' . ($product->image ?? 'placeholder.png')),
      'url' => route('product.show', $product->slug),
      'sku' => $product->sku ?? '',
      'price' => $product->price,
      'priceCurrency' => 'USD',
      'availability' => $product->in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
      'brand' => [
        '@type' => 'Brand',
        'name' => 'Toxaway Knitting Co.',
      ],
    ];
  }

  public static function organizationSchema(): array
  {
    return [
      '@context' => 'https://schema.org',
      '@type' => 'Organization',
      'name' => 'Toxaway Knitting Co.',
      'url' => config('app.url'),
      'logo' => asset('logo.png'),
      'description' => 'Premium, heavyweight, American-made knitwear with meticulous attention to craft.',
      'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => '123 Craft Lane',
        'addressLocality' => 'Brevard',
        'addressRegion' => 'NC',
        'postalCode' => '28712',
        'addressCountry' => 'US',
      ],
      'contactPoint' => [
        '@type' => 'ContactPoint',
        'contactType' => 'Customer Service',
        'telephone' => '+1-828-555-0123',
        'email' => 'support@toxawayknitting.com',
      ],
      'sameAs' => [
        'https://facebook.com/toxawayknitting',
        'https://instagram.com/toxawayknitting',
        'https://twitter.com/toxawayknitting',
      ],
    ];
  }
}
