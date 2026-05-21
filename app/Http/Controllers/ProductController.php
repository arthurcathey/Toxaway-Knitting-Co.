<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function index(Request $request)
  {
    $query = Product::query();

    if ($request->has('category') && $request->get('category') !== '') {
      $query->where('category', $request->get('category'));
    }

    $products = $query->get();

    return view('shop.index', compact('products'));
  }

  public function show(Product $product)
  {
    $relatedProducts = Product::where('category', $product->category)
      ->where('id', '!=', $product->id)
      ->take(3)
      ->get();

    return view('shop.show', compact('product', 'relatedProducts'));
  }
}
