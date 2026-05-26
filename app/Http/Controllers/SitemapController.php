<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
  public function index()
  {
    $products = Product::where('in_stock', true)->get();

    $xml = view('sitemap.index', compact('products'))->render();

    return Response::make($xml, 200, [
      'Content-Type' => 'application/xml; charset=utf-8',
    ]);
  }
}
