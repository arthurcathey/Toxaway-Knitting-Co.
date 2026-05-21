<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
  /**
   * Get current cart contents from session.
   */
  public function index(Request $request): JsonResponse
  {
    $cart = $request->session()->get('cart', []);

    $total = 0;
    $items = [];

    foreach ($cart as $productId => $quantity) {
      $product = \App\Models\Product::find($productId);
      if ($product) {
        $itemTotal = $product->price * $quantity;
        $total += $itemTotal;
        $items[] = [
          'product_id' => $product->id,
          'name' => $product->name,
          'price' => (float) $product->price,
          'quantity' => $quantity,
          'subtotal' => (float) $itemTotal,
        ];
      }
    }

    return response()->json([
      'items' => $items,
      'item_count' => count($items),
      'total_quantity' => array_sum($cart),
      'total_price' => (float) $total,
    ]);
  }

  /**
   * Add a product to cart.
   */
  public function add(Request $request): JsonResponse
  {
    $validated = $request->validate([
      'product_id' => 'required|integer|exists:products,id',
      'quantity' => 'required|integer|min:1|max:100',
    ]);

    $product = \App\Models\Product::find($validated['product_id']);

    // Check stock
    if ($product->quantity_available < $validated['quantity']) {
      return response()->json([
        'message' => 'Insufficient stock available',
        'available' => $product->quantity_available,
      ], 422);
    }

    $cart = $request->session()->get('cart', []);
    $productId = $validated['product_id'];

    // Add or update quantity
    if (isset($cart[$productId])) {
      $cart[$productId] += $validated['quantity'];
    } else {
      $cart[$productId] = $validated['quantity'];
    }

    $request->session()->put('cart', $cart);

    return response()->json([
      'message' => 'Product added to cart',
      'product' => $product->name,
      'quantity' => $cart[$productId],
    ], 201);
  }

  /**
   * Update product quantity in cart.
   */
  public function update(Request $request, int $productId): JsonResponse
  {
    $validated = $request->validate([
      'quantity' => 'required|integer|min:0|max:100',
    ]);

    $cart = $request->session()->get('cart', []);

    if (!isset($cart[$productId])) {
      return response()->json(['message' => 'Product not in cart'], 404);
    }

    if ($validated['quantity'] == 0) {
      unset($cart[$productId]);
      $request->session()->put('cart', $cart);
      return response()->json(['message' => 'Product removed from cart']);
    }

    $product = \App\Models\Product::find($productId);
    if ($product->quantity_available < $validated['quantity']) {
      return response()->json([
        'message' => 'Insufficient stock available',
        'available' => $product->quantity_available,
      ], 422);
    }

    $cart[$productId] = $validated['quantity'];
    $request->session()->put('cart', $cart);

    return response()->json([
      'message' => 'Cart updated',
      'quantity' => $cart[$productId],
    ]);
  }

  /**
   * Remove product from cart.
   */
  public function remove(Request $request, int $productId): JsonResponse
  {
    $cart = $request->session()->get('cart', []);

    if (!isset($cart[$productId])) {
      return response()->json(['message' => 'Product not in cart'], 404);
    }

    unset($cart[$productId]);
    $request->session()->put('cart', $cart);

    return response()->json(['message' => 'Product removed from cart']);
  }

  /**
   * Clear entire cart.
   */
  public function clear(Request $request): JsonResponse
  {
    $request->session()->forget('cart');

    return response()->json(['message' => 'Cart cleared']);
  }
}
