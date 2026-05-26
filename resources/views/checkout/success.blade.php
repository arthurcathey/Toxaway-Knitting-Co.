@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-stone-50 flex items-center justify-center py-12 px-4">
  <div class="max-w-md w-full text-center">
    <!-- Success Icon -->
    <div class="mb-6">
      <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
    </div>

    <!-- Success Message -->
    <h1 class="text-3xl font-bold text-stone-900 mb-2">Order Confirmed!</h1>
    <p class="text-stone-600 mb-6">Thank you for your purchase. Your order has been successfully processed.</p>

    <!-- Order Details -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 text-left">
      <div class="space-y-3">
        <div class="flex justify-between">
          <span class="text-stone-600">Order Number:</span>
          <span class="font-semibold text-stone-900">#{{ $order->id }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-stone-600">Order Date:</span>
          <span class="font-semibold text-stone-900">{{ $order->created_at->format('M d, Y') }}</span>
        </div>
        <div class="flex justify-between border-t border-stone-200 pt-3 mt-3">
          <span class="text-stone-600">Total Amount:</span>
          <span class="font-semibold text-blue-600 text-lg">${{ number_format($order->total_amount, 2) }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-stone-600">Status:</span>
          <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
            {{ ucfirst($order->status) }}
          </span>
        </div>
      </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <h2 class="text-lg font-semibold text-stone-900 mb-4 text-left">Order Items</h2>
      <div class="space-y-2 text-left">
        @foreach ($order->items as $item)
        <div class="flex justify-between text-sm text-stone-700 pb-2 border-b border-stone-100">
          <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
          <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Shipping Information -->
    <div class="bg-stone-50 rounded-lg p-4 mb-6 text-left">
      <h3 class="font-semibold text-stone-900 mb-2">Shipping Address</h3>
      <p class="text-sm text-stone-600">
        {{ $order->full_name }}<br>
        {{ $order->shipping_address }}<br>
        {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
        {{ $order->shipping_country }}
      </p>
    </div>

    <!-- Next Steps -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
      <p class="text-sm text-stone-700">
        <strong>What's next?</strong> A confirmation email has been sent to <strong>{{ $order->email }}</strong>.
        You can track your order status there. If you have any questions, contact us at
        <a href="mailto:support@toxawayknitting.com" class="text-blue-600 hover:text-blue-700">support@toxawayknitting.com</a>.
      </p>
    </div>

    <!-- Action Buttons -->
    <div class="space-y-3">
      <a href="{{ route('shop') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
        Continue Shopping
      </a>
      @if (Auth::check())
      <a href="{{ route('dashboard') }}" class="block w-full bg-stone-200 hover:bg-stone-300 text-stone-900 font-semibold py-3 rounded-lg transition">
        View My Orders
      </a>
      @endif
      <a href="{{ route('home') }}" class="block w-full text-center text-blue-600 hover:text-blue-700 font-semibold py-3 rounded-lg transition">
        Return Home
      </a>
    </div>
  </div>
</div>
@endsection
