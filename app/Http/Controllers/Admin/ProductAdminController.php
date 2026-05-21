<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductAdminController extends Controller
{
  public function index()
  {
    $products = Product::all();
    return view('admin.products.index', compact('products'));
  }

  public function create()
  {
    return view('admin.products.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'slug' => 'required|string|unique:products|max:255',
      'description' => 'required|string',
      'price' => 'required|numeric|min:0',
      'category' => 'required|string',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
      'in_stock' => 'boolean',
    ]);

    // Handle file upload
    if ($request->hasFile('image')) {
      $path = $request->file('image')->store('products', 'public');
      $validated['image'] = $path;
    }

    Product::create($validated);

    return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
  }

  public function edit(Product $product)
  {
    return view('admin.products.edit', compact('product'));
  }

  public function update(Request $request, Product $product)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
      'description' => 'required|string',
      'price' => 'required|numeric|min:0',
      'category' => 'required|string',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
      'in_stock' => 'boolean',
    ]);

    // Handle file upload
    if ($request->hasFile('image')) {
      // Delete old image if it exists
      if ($product->image) {
        Storage::disk('public')->delete($product->image);
      }
      $path = $request->file('image')->store('products', 'public');
      $validated['image'] = $path;
    }

    $product->update($validated);

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
  }

  public function destroy(Product $product)
  {
    // Delete image file if it exists
    if ($product->image) {
      Storage::disk('public')->delete($product->image);
    }
    $product->delete();
    return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
  }
}
