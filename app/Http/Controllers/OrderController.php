<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  protected $cartService;

  public function __construct(CartService $cartService)
  {
    $this->cartService = $cartService;
  }

  public function checkout()
  {
    $cart = $this->cartService->getCart();

    if (empty($cart)) {
      return redirect('/shop')->with('error', 'Your cart is empty.');
    }

    $items = [];
    $subtotal = 0;

    foreach ($cart as $item) {
      $items[] = [
        'product_name' => $item['product_name'],
        'size' => $item['size'],
        'price' => $item['price'],
        'quantity' => $item['quantity'],
        'subtotal' => $item['price'] * $item['quantity'],
      ];
      $subtotal += $item['price'] * $item['quantity'];
    }

    $shipping_cost = $subtotal >= 100 ? 0 : 10;
    $total = $subtotal + $shipping_cost;

    return view('checkout.form', compact('items', 'subtotal', 'shipping_cost', 'total'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'customer_name' => 'required|string|max:255',
      'customer_email' => 'required|email',
      'customer_phone' => 'nullable|string|max:20',
      'shipping_address' => 'required|string|max:255',
      'shipping_city' => 'required|string|max:100',
      'shipping_state' => 'required|string|max:50',
      'shipping_zip' => 'required|string|max:20',
    ]);

    $cart = $this->cartService->getCart();

    if (empty($cart)) {
      return redirect('/shop')->with('error', 'Your cart is empty.');
    }

    // Calculate totals
    $subtotal = 0;
    foreach ($cart as $item) {
      $subtotal += $item['price'] * $item['quantity'];
    }

    $shipping_cost = $subtotal >= 100 ? 0 : 10;
    $total = $subtotal + $shipping_cost;

    // Create order
    $order = Order::create([
      'order_number' => 'ORD-' . now()->format('YmdHis') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
      'customer_name' => $validated['customer_name'],
      'customer_email' => $validated['customer_email'],
      'customer_phone' => $validated['customer_phone'],
      'shipping_address' => $validated['shipping_address'],
      'shipping_city' => $validated['shipping_city'],
      'shipping_state' => $validated['shipping_state'],
      'shipping_zip' => $validated['shipping_zip'],
      'subtotal' => $subtotal,
      'shipping_cost' => $shipping_cost,
      'total' => $total,
      'status' => 'confirmed',
    ]);

    // Create order items
    foreach ($cart as $item) {
      OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $item['product_id'],
        'product_name' => $item['product_name'],
        'price' => $item['price'],
        'quantity' => $item['quantity'],
        'subtotal' => $item['price'] * $item['quantity'],
      ]);
    }

    // Clear cart
    $this->cartService->clearCart();

    return redirect()->route('order.confirmation', $order)->with('success', 'Order placed successfully!');
  }

  public function confirmation(Order $order)
  {
    return view('checkout.confirmation', compact('order'));
  }
}
