@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<main>
  <!-- Page Header -->
  <section class="section-py border-b border-stone-300 container-fluid">
    <h1 class="mb-3 sm:mb-4">ORDER CONFIRMED</h1>
    <p class="text-stone-600 tracking-wide text-xs sm:text-sm">Thank you for your order!</p>
  </section>

  <!-- Confirmation Content -->
  <section class="section-py container-fluid">
    <div class="max-w-2xl mx-auto">
      <!-- Success Message -->
      <div class="card p-6 sm:p-8 mb-8 bg-blue-50 border-l-4 border-l-blue-600">
        <div class="flex items-start gap-4">
          <div class="text-2xl">✓</div>
          <div>
            <h2 class="text-lg sm:text-xl font-bold text-blue-700 mb-2">Payment Received</h2>
            <p class="text-sm text-blue-600">Your order has been confirmed and is being prepared for shipment.</p>
          </div>
        </div>
      </div>

      <!-- Order Details -->
      <div class="card p-6 sm:p-8 mb-8">
        <h2 class="text-xl font-bold text-stone-900 mb-6">ORDER DETAILS</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <div>
            <h3 class="text-xs font-bold text-stone-600 mb-2 uppercase">Order Number</h3>
            <p class="text-lg font-bold text-stone-900">{{ $order->order_number }}</p>
          </div>
          <div>
            <h3 class="text-xs font-bold text-stone-600 mb-2 uppercase">Order Date</h3>
            <p class="text-lg font-bold text-stone-900">{{ $order->created_at->format('M d, Y') }}</p>
          </div>
        </div>

        <hr class="border-stone-300 mb-8">

        <h3 class="text-xs font-bold text-stone-600 mb-4 uppercase">Items Ordered</h3>
        <div class="space-y-4 mb-8">
          @foreach($order->items as $item)
          <div class="flex justify-between items-center py-3 border-b border-stone-200 last:border-0">
            <div>
              <p class="text-sm font-semibold text-stone-900">{{ $item->product_name }}</p>
              <p class="text-xs text-stone-600">
                @if($item->color)
                Color: {{ match($item->color) {
                  'black' => 'Black',
                  'navy' => 'Navy Blue',
                  'forest_green' => 'Forest Green',
                  'burgundy' => 'Burgundy',
                  'cream' => 'Cream',
                  'charcoal' => 'Charcoal Gray',
                  'white' => 'White',
                  'olive' => 'Olive Green',
                  'slate' => 'Slate Blue',
                  'brown' => 'Brown',
                  'tan' => 'Tan',
                  'gray' => 'Light Gray',
                  default => $item->color
                } }},
                @endif
                @if($item->size)
                Size: {{ match($item->size) {
                  'sm' => 'Small',
                  'md' => 'Medium',
                  'lg' => 'Large',
                  'xl' => 'Extra Large',
                  'xxl' => 'Extra Extra Large',
                  default => $item->size
                } }},
                @endif
                Quantity: {{ $item->quantity }}
              </p>
            </div>
            <p class="font-bold text-stone-900">${{ number_format($item->subtotal, 2) }}</p>
          </div>
          @endforeach
        </div>

        <hr class="border-stone-300 mb-8">

        <div class="space-y-3">
          <div class="flex justify-between items-center">
            <span class="text-stone-600">Subtotal</span>
            <span class="font-bold text-stone-900">${{ number_format($order->subtotal, 2) }}</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-stone-600">Shipping</span>
            <span class="font-bold text-stone-900">
              @if($order->shipping_cost == 0)
              FREE
              @else
              ${{ number_format($order->shipping_cost, 2) }}
              @endif
            </span>
          </div>
          <div class="flex justify-between items-center pt-3 border-t border-stone-300">
            <span class="font-bold text-stone-900">Total</span>
            <span class="text-2xl font-bold text-stone-900">${{ number_format($order->total, 2) }}</span>
          </div>
        </div>
      </div>

      <!-- Shipping Information -->
      <div class="card p-6 sm:p-8 mb-8">
        <h2 class="text-xl font-bold text-stone-900 mb-6">SHIPPING TO</h2>

        <div class="text-sm text-stone-900">
          <p class="font-semibold mb-2">{{ $order->customer_name }}</p>
          <p>{{ $order->shipping_address }}</p>
          <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
          @if($order->customer_phone)
          <p class="mt-2 text-stone-600">{{ $order->customer_phone }}</p>
          @endif
        </div>
      </div>

      <!-- Confirmation Email -->
      <div class="card p-6 sm:p-8 mb-8 bg-stone-50">
        <h3 class="text-sm font-bold text-stone-600 mb-2 uppercase">Confirmation Email</h3>
        <p class="text-sm text-stone-900">A confirmation email has been sent to <strong>{{ $order->customer_email }}</strong> with your order details and tracking information.</p>
      </div>

      <!-- Next Steps -->
      <div class="card p-6 sm:p-8 mb-8">
        <h2 class="text-lg font-bold text-stone-900 mb-4">WHAT HAPPENS NEXT?</h2>
        <ol class="space-y-3 text-sm text-stone-900 list-decimal list-inside">
          <li>We'll prepare your order for shipment within 1-2 business days</li>
          <li>You'll receive a shipping notification with tracking information</li>
          <li>Your order typically ships in 2-3 business days</li>
          <li>You can track your package using the tracking link in your email</li>
        </ol>
      </div>

      <!-- Contact Info -->
      <div class="card p-6 sm:p-8 mb-8">
        <h3 class="text-sm font-bold text-stone-600 mb-3 uppercase">Questions?</h3>
        <p class="text-sm text-stone-900 mb-4">If you have any questions about your order, please don't hesitate to contact us:</p>
        <div class="text-sm text-stone-900">
          <p class="mb-1">📧 Email: <a href="mailto:hello@toxaway.test" class="text-stone-900 hover:underline">hello@toxaway.test</a></p>
          <p>📞 Phone: <a href="tel:+18285550123" class="text-stone-900 hover:underline">(828) 555-0123</a></p>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
        <a href="/shop" class="btn-secondary text-center block">CONTINUE SHOPPING</a>
        <a href="/" class="btn-primary text-center block">BACK TO HOME</a>
      </div>
    </div>
  </section>
</main>
@endsection
