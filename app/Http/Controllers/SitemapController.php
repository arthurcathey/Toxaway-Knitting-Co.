<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
  public function index()
  {
    $products = Product::where('in_stock', true)->get();

    // Build XML manually to avoid Blade parsing issues with <?xml declaration
    $xml = view('sitemap.index', compact('products'))->render();

    // Remove the @php output and prepend the proper XML declaration
    $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
      preg_replace('/^@php.*?@endphp\n/s', '', $xml);

    return Response::make($xml, 200, [
      'Content-Type' => 'application/xml; charset=utf-8',
    ]);
  }
}
