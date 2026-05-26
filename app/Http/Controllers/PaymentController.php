<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\StripePaymentService;
use App\Services\CartService;
use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
  private StripePaymentService $stripe;
  private CartService $cartService;

  public function __construct(StripePaymentService $stripe, CartService $cartService)
  {
    $this->stripe = $stripe;
    $this->cartService = $cartService;
  }

  /**
   * Show payment form
   */
  public function index()
  {
    // Get cart items from CartService (session-based)
    $cart = $this->cartService->getCart();

    if (empty($cart)) {
      return redirect()->route('shop')->with('error', 'Your cart is empty');
    }

    $cartItems = [];
    $total = 0;

    foreach ($cart as $item) {
      $product = Product::find($item['product_id']);
      if ($product) {
        $subtotal = $product->price * $item['quantity'];
        $cartItems[] = (object)[
          'product' => $product,
          'quantity' => $item['quantity'],
          'size' => $item['size'],
          'subtotal' => $subtotal,
        ];
        $total += $subtotal;
      }
    }

    $total += 15; // Add default shipping

    return view('checkout.payment', [
      'cartItems' => $cartItems,
      'total' => $total,
      'stripe_public_key' => config('services.stripe.public'),
    ]);
  }

  /**
   * Process payment
   */
  public function process(Request $request)
  {
    try {
      $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'zip' => 'required|string|max:20',
        'country' => 'required|string|max:100',
        'payment_method_id' => 'required|string',
      ]);

      // Get cart items from CartService
      $cart = $this->cartService->getCart();

      if (empty($cart)) {
        return response()->json([
          'success' => false,
          'error' => 'Your cart is empty',
        ], 400);
      }

      $subtotal = 0;
      $cartItems = [];

      foreach ($cart as $item) {
        $product = Product::find($item['product_id']);
        if ($product) {
          $subtotal += $product->price * $item['quantity'];
          $cartItems[] = [
            'product' => $product,
            'quantity' => $item['quantity'],
            'size' => $item['size'],
          ];
        }
      }

      $shipping = 15.00; // Default shipping
      $total = $subtotal + $shipping;

      DB::beginTransaction();

      try {
        // Create order
        $order = Order::create([
          'user_id' => Auth::id(),
          'total_amount' => $total,
          'subtotal' => $subtotal,
          'shipping_cost' => $shipping,
          'tax' => 0,
          'status' => 'pending',
          'full_name' => $validated['full_name'],
          'email' => $validated['email'],
          'phone' => $validated['phone'],
          'shipping_address' => $validated['address'],
          'shipping_city' => $validated['city'],
          'shipping_state' => $validated['state'],
          'shipping_zip' => $validated['zip'],
          'shipping_country' => $validated['country'],
        ]);

        // Create order items
        foreach ($cartItems as $item) {
          OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['product']->id,
            'quantity' => $item['quantity'],
            'price' => $item['product']->price,
          ]);
        }

        // Process payment with Stripe
        $paymentResult = $this->stripe->createCharge(
          $validated['payment_method_id'],
          (int)($total * 100), // Convert to cents
          'usd',
          [
            'order_id' => $order->id,
            'customer_email' => $validated['email'],
          ]
        );

        if (!$paymentResult['success']) {
          DB::rollBack();
          return response()->json([
            'success' => false,
            'error' => $paymentResult['error'] ?? 'Payment processing failed',
          ], 422);
        }

        // Update order with payment details
        $order->update([
          'status' => 'confirmed',
          'stripe_charge_id' => $paymentResult['charge_id'],
          'payment_method' => 'stripe',
          'paid_at' => now(),
        ]);

        // Clear cart
        $this->cartService->clearCart();

        // Send confirmation email
        try {
          Mail::to($validated['email'])->send(new OrderConfirmation($order, $validated['email']));
        } catch (\Exception $e) {
          Log::warning('Failed to send order confirmation: ' . $e->getMessage());
        }

        DB::commit();

        return response()->json([
          'success' => true,
          'order_id' => $order->id,
          'message' => 'Payment successful! Your order has been confirmed.',
        ]);
      } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Payment processing error: ' . $e->getMessage());

        return response()->json([
          'success' => false,
          'error' => 'An error occurred while processing your payment',
        ], 500);
      }
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json([
        'success' => false,
        'errors' => $e->errors(),
      ], 422);
    }
  }

  /**
   * Payment success page
   */
  public function success(Request $request)
  {
    $orderId = $request->query('order_id');

    if (!$orderId) {
      return redirect()->route('shop')->with('error', 'Order not found');
    }

    $order = Order::findOrFail($orderId);

    // Verify order belongs to current user or was just created
    if (Auth::check() && $order->user_id !== Auth::id()) {
      return redirect()->route('shop')->with('error', 'Unauthorized');
    }

    return view('checkout.success', ['order' => $order]);
  }

  /**
   * Payment failure page
   */
  public function failure(Request $request)
  {
    $error = $request->query('error', 'Payment processing failed');

    return view('checkout.failure', [
      'error' => $error,
      'cartTotal' => session('cart_total', 0),
    ]);
  }

  /**
   * Handle Stripe webhook
   */
  public function webhook(Request $request)
  {
    $payload = $request->getContent();
    $signature = $request->header('Stripe-Signature');

    if (!StripePaymentService::verifyWebhookSignature($payload, $signature)) {
      return response('Invalid signature', 403);
    }

    $event = json_decode($payload, true);

    try {
      switch ($event['type']) {
        case 'charge.succeeded':
          $this->handleChargeSucceeded($event['data']['object']);
          break;

        case 'charge.failed':
          $this->handleChargeFailed($event['data']['object']);
          break;

        case 'charge.refunded':
          $this->handleChargeRefunded($event['data']['object']);
          break;
      }

      return response('Webhook processed', 200);
    } catch (\Exception $e) {
      Log::error('Stripe webhook error: ' . $e->getMessage());
      return response('Webhook error', 500);
    }
  }

  /**
   * Handle successful charge
   */
  private function handleChargeSucceeded(array $charge)
  {
    $orderId = $charge['metadata']['order_id'] ?? null;

    if (!$orderId) {
      Log::warning('Stripe charge succeeded but no order_id in metadata');
      return;
    }

    $order = Order::find($orderId);
    if ($order) {
      $order->update([
        'status' => 'confirmed',
        'paid_at' => now(),
      ]);

      Log::info("Order {$orderId} marked as confirmed via webhook");
    }
  }

  /**
   * Handle failed charge
   */
  private function handleChargeFailed(array $charge)
  {
    $orderId = $charge['metadata']['order_id'] ?? null;

    if (!$orderId) {
      Log::warning('Stripe charge failed but no order_id in metadata');
      return;
    }

    $order = Order::find($orderId);
    if ($order) {
      $order->update(['status' => 'failed']);
      Log::info("Order {$orderId} marked as failed via webhook");
    }
  }

  /**
   * Handle refunded charge
   */
  private function handleChargeRefunded(array $charge)
  {
    $orderId = $charge['metadata']['order_id'] ?? null;

    if (!$orderId) {
      Log::warning('Stripe charge refunded but no order_id in metadata');
      return;
    }

    $order = Order::find($orderId);
    if ($order) {
      $order->update(['status' => 'refunded']);
      Log::info("Order {$orderId} marked as refunded via webhook");
    }
  }
}
