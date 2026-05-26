<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
  public function index(Request $request): View
  {
    $query = Product::query();

    if ($request->has('category') && $request->get('category') !== '') {
      $query->where('category', $request->get('category'));
    }

    $products = $query->get();

    view()->share(
      'seo',
      (new SeoService())
        ->setTitle('Shop | Toxaway Knitting Co.')
        ->setDescription('Browse our collection of premium handmade knitwear. Handcrafted sweaters, custom jackets, and more made with meticulous attention to craft.')
        ->setUrl(route('shop'))
        ->setKeywords(['knitwear', 'handmade sweaters', 'custom jackets', 'wool clothing', 'American made'])
        ->setStructuredData(SeoService::organizationSchema())
    );

    return view('shop.index', compact('products'));
  }

  public function show(Product $product): View
  {
    $relatedProducts = Product::where('category', $product->category)
      ->where('id', '!=', $product->id)
      ->take(3)
      ->get();

    view()->share(
      'seo',
      (new SeoService())
        ->setTitle($product->name . ' | Toxaway Knitting Co.')
        ->setDescription($product->description ?? 'Shop this premium handmade ' . $product->name . ' from Toxaway Knitting Co.')
        ->setUrl(route('product.show', $product->slug))
        ->setImage(asset('images/products/' . ($product->image ?? 'placeholder.png')))
        ->setKeywords(array_merge(
          [$product->name, $product->category, 'handmade', 'knitwear'],
          explode(',', $product->category)
        ))
        ->setType('product')
        ->setStructuredData(SeoService::productSchema($product))
    );

    return view('shop.show', compact('product', 'relatedProducts'));
  }
}
