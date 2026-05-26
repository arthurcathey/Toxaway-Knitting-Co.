<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
  protected $cartService;

  public function __construct(CartService $cartService)
  {
    $this->cartService = $cartService;
  }

  public function index()
  {
    $cart = $this->cartService->getCart();
    $total = 0;
    $items = [];

    foreach ($cart as $key => $item) {
      $items[] = [
        'key' => $key,
        'product_id' => $item['product_id'],
        'product_name' => $item['product_name'],
        'price' => $item['price'],
        'quantity' => $item['quantity'],
        'size' => $item['size'],
        'subtotal' => $item['price'] * $item['quantity'],
      ];
      $total += $item['price'] * $item['quantity'];
    }

    return view('cart.index', compact('items', 'total', 'cart'));
  }

  public function add(Request $request)
  {
    $validated = $request->validate([
      'product_id' => 'required|exists:products,id',
      'quantity' => 'required|integer|min:1|max:99',
      'size' => 'required|string',
    ]);

    $product = Product::find($validated['product_id']);
    if (!$product) {
      return response()->json(['success' => false, 'message' => 'Product not found'], 404);
    }

    $this->cartService->addToCart(
      $validated['product_id'],
      $validated['quantity'],
      $validated['size'],
      $product->name,
      $product->price
    );

    $cartCount = $this->cartService->getCartCount();

    return response()->json([
      'success' => true,
      'message' => 'Product added to cart',
      'cartCount' => $cartCount,
    ]);
  }

  public function remove(Request $request)
  {
    $validated = $request->validate([
      'product_id' => 'required|exists:products,id',
      'size' => 'required|string',
    ]);

    $this->cartService->removeFromCart($validated['product_id'], $validated['size']);
    $cartCount = $this->cartService->getCartCount();

    return response()->json([
      'success' => true,
      'message' => 'Product removed from cart',
      'cartCount' => $cartCount,
    ]);
  }

  public function update(Request $request)
  {
    $validated = $request->validate([
      'product_id' => 'required|exists:products,id',
      'size' => 'required|string',
      'quantity' => 'required|integer|min:0|max:99',
    ]);

    $this->cartService->updateQuantity(
      $validated['product_id'],
      $validated['size'],
      $validated['quantity']
    );

    $cartCount = $this->cartService->getCartCount();

    return response()->json([
      'success' => true,
      'message' => 'Cart updated',
      'cartCount' => $cartCount,
    ]);
  }

  /**
   * Get the current cart count without rendering the full cart page.
   * Useful for initializing the cart count on page load.
   */
  public function count()
  {
    $cartCount = $this->cartService->getCartCount();
    return response()->json(['cartCount' => $cartCount]);
  }
}
