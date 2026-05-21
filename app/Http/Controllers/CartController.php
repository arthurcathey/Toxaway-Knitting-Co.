<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
  public function index()
  {
    $cart = session()->get('cart', []);
    $total = 0;
    $items = [];

    foreach ($cart as $productId => $quantity) {
      $product = Product::find($productId);
      if ($product) {
        $items[] = [
          'product' => $product,
          'quantity' => $quantity,
          'subtotal' => $product->price * $quantity,
        ];
        $total += $product->price * $quantity;
      }
    }

    return view('cart.index', compact('items', 'total', 'cart'));
  }

  public function add(Request $request)
  {
    $validated = $request->validate([
      'product_id' => 'required|exists:products,id',
      'quantity' => 'required|integer|min:1|max:99',
    ]);

    $cart = session()->get('cart', []);
    $productId = $validated['product_id'];
    $quantity = $validated['quantity'];

    if (isset($cart[$productId])) {
      $cart[$productId] += $quantity;
    } else {
      $cart[$productId] = $quantity;
    }

    session()->put('cart', $cart);

    return response()->json([
      'success' => true,
      'message' => 'Product added to cart',
      'cartCount' => array_sum($cart),
    ]);
  }

  public function remove(Request $request)
  {
    $validated = $request->validate([
      'product_id' => 'required|exists:products,id',
    ]);

    $cart = session()->get('cart', []);
    unset($cart[$validated['product_id']]);
    session()->put('cart', $cart);

    return response()->json([
      'success' => true,
      'message' => 'Product removed from cart',
      'cartCount' => array_sum($cart),
    ]);
  }

  public function update(Request $request)
  {
    $validated = $request->validate([
      'product_id' => 'required|exists:products,id',
      'quantity' => 'required|integer|min:0|max:99',
    ]);

    $cart = session()->get('cart', []);
    $productId = $validated['product_id'];

    if ($validated['quantity'] <= 0) {
      unset($cart[$productId]);
    } else {
      $cart[$productId] = $validated['quantity'];
    }

    session()->put('cart', $cart);

    return response()->json([
      'success' => true,
      'message' => 'Cart updated',
      'cartCount' => array_sum($cart),
    ]);
  }
}
