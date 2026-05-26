@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<main>
  <!-- Page Header -->
  <section class="section-py border-b border-stone-300 container-fluid">
    <h1 class="mb-3 sm:mb-4">CHECKOUT</h1>
    <p class="text-stone-600 tracking-wide text-xs sm:text-sm">Complete your order</p>
  </section>

  <!-- Checkout Form -->
  <section class="section-py container-fluid">
    <div class="grid-2col gap-8 sm:gap-12">
      <!-- Checkout Form -->
      <div>
        <h2 class="mb-6 sm:mb-8">SHIPPING INFORMATION</h2>

        <form action="{{ route('order.store') }}" method="POST" class="space-y-4 sm:space-y-6">
          @csrf

          <!-- Name -->
          <div>
            <label for="customer_name" class="block text-xs sm:text-sm text-stone-600 mb-2">FULL NAME *</label>
            <input
              type="text"
              id="customer_name"
              name="customer_name"
              required
              class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:border-stone-900 {{ $errors->has('customer_name') ? 'border-red-500' : '' }}"
              value="{{ old('customer_name') }}">
            @if($errors->has('customer_name'))
            <p class="text-red-600 text-xs mt-1">{{ $errors->first('customer_name') }}</p>
            @endif
          </div>

          <!-- Email -->
          <div>
            <label for="customer_email" class="block text-xs sm:text-sm text-stone-600 mb-2">EMAIL ADDRESS *</label>
            <input
              type="email"
              id="customer_email"
              name="customer_email"
              required
              class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:border-stone-900 {{ $errors->has('customer_email') ? 'border-red-500' : '' }}"
              value="{{ old('customer_email') }}">
            @if($errors->has('customer_email'))
            <p class="text-red-600 text-xs mt-1">{{ $errors->first('customer_email') }}</p>
            @endif
          </div>

          <!-- Phone -->
          <div>
            <label for="customer_phone" class="block text-xs sm:text-sm text-stone-600 mb-2">PHONE NUMBER</label>
            <input
              type="tel"
              id="customer_phone"
              name="customer_phone"
              class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:border-stone-900"
              value="{{ old('customer_phone') }}">
          </div>

          <hr class="border-stone-300 my-6 sm:my-8">

          <!-- Payment Information -->
          <h3 class="text-stone-900 font-semibold mb-4 sm:mb-6 text-sm">PAYMENT INFORMATION</h3>

          <!-- Cardholder Name -->
          <div>
            <label for="cardholder_name" class="block text-xs sm:text-sm text-stone-600 mb-2">CARDHOLDER NAME *</label>
            <input
              type="text"
              id="cardholder_name"
              name="cardholder_name"
              required
              class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:border-stone-900 {{ $errors->has('cardholder_name') ? 'border-red-500' : '' }}"
              value="{{ old('cardholder_name') }}">
            @if($errors->has('cardholder_name'))
            <p class="text-red-600 text-xs mt-1">{{ $errors->first('cardholder_name') }}</p>
            @endif
          </div>

          <!-- Card Number -->
          <div>
            <label for="card_number" class="block text-xs sm:text-sm text-stone-600 mb-2">CARD NUMBER *</label>
            <input
              type="text"
              id="card_number"
              name="card_number"
              placeholder="1234 5678 9012 3456"
              required
              maxlength="19"
              class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:border-stone-900 {{ $errors->has('card_number') ? 'border-red-500' : '' }}"
              value="{{ old('card_number') }}">
            @if($errors->has('card_number'))
            <p class="text-red-600 text-xs mt-1">{{ $errors->first('card_number') }}</p>
            @endif
          </div>

          <!-- Expiration & CVV -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label for="card_expiry" class="block text-xs sm:text-sm text-stone-600 mb-2">EXPIRATION DATE *</label>
              <input
                type="text"
                id="card_expiry"
                name="card_expiry"
                placeholder="MM/YY"
                required
                maxlength="5"
                class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:border-stone-900 {{ $errors->has('card_expiry') ? 'border-red-500' : '' }}"
                value="{{ old('card_expiry') }}">
              @if($errors->has('card_expiry'))
              <p class="text-red-600 text-xs mt-1">{{ $errors->first('card_expiry') }}</p>
              @endif
            </div>
            <div>
              <label for="card_cvv" class="block text-xs sm:text-sm text-stone-600 mb-2">CVV *</label>
              <input
                type="text"
                id="card_cvv"
                name="card_cvv"
                placeholder="123"
                required
                maxlength="4"
                class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:border-stone-900 {{ $errors->has('card_cvv') ? 'border-red-500' : '' }}"
                value="{{ old('card_cvv') }}">
              @if($errors->has('card_cvv'))
              <p class="text-red-600 text-xs mt-1">{{ $errors->first('card_cvv') }}</p>
              @endif
            </div>
          </div>

          <hr class="border-stone-300 my-6 sm:my-8">

          <!-- Address -->
          <div>
            <label for="shipping_address" class="block text-xs sm:text-sm text-stone-600 mb-2">STREET ADDRESS *</label>
            <input
              type="text"
              id="shipping_address"
              name="shipping_address"
              required
              class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:border-stone-900 {{ $errors->has('shipping_address') ? 'border-red-500' : '' }}"
              value="{{ old('shipping_address') }}">
            @if($errors->has('shipping_address'))
            <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_address') }}</p>
            @endif
          </div>

          <!-- City -->
          <div>
            <label for="shipping_city" class="block text-xs sm:text-sm text-stone-600 mb-2">CITY *</label>
            <input
              type="text"
              id="shipping_city"
              name="shipping_city"
              required
              class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:border-stone-900 {{ $errors->has('shipping_city') ? 'border-red-500' : '' }}"
              value="{{ old('shipping_city') }}">
            @if($errors->has('shipping_city'))
            <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_city') }}</p>
            @endif
          </div>

          <!-- State & Zip -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label for="shipping_state" class="block text-xs sm:text-sm text-stone-600 mb-2">STATE *</label>
              <input
                type="text"
                id="shipping_state"
                name="shipping_state"
                required
                placeholder="NC"
                class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:border-stone-900 {{ $errors->has('shipping_state') ? 'border-red-500' : '' }}"
                value="{{ old('shipping_state') }}">
              @if($errors->has('shipping_state'))
              <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_state') }}</p>
              @endif
            </div>
            <div>
              <label for="shipping_zip" class="block text-xs sm:text-sm text-stone-600 mb-2">ZIP CODE *</label>
              <input
                type="text"
                id="shipping_zip"
                name="shipping_zip"
                required
                class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:border-stone-900 {{ $errors->has('shipping_zip') ? 'border-red-500' : '' }}"
                value="{{ old('shipping_zip') }}">
              @if($errors->has('shipping_zip'))
              <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_zip') }}</p>
              @endif
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4 mt-8">
            <a href="/cart" class="btn-secondary text-center block">BACK TO CART</a>
            <button type="submit" class="btn-primary">PLACE ORDER</button>
          </div>
        </form>
      </div>

      <!-- Order Summary -->
      <div>
        <div class="sticky top-24">
          <h2 class="mb-6 sm:mb-8">ORDER SUMMARY</h2>

          <div class="card p-6 sm:p-8 space-y-4 sm:space-y-6">
            <div class="space-y-3 sm:space-y-4">
              <h3 class="text-xs sm:text-sm font-bold text-stone-900 mb-4">ITEMS</h3>
              @foreach($items as $item)
              <div class="flex justify-between items-start text-xs sm:text-sm">
                <div>
                  <p class="font-semibold text-stone-900">{{ $item['product_name'] }}</p>
                  <p class="text-stone-600">Size: {{ $item['size'] }}, Qty: {{ $item['quantity'] }}</p>
                </div>
                <p class="font-semibold text-stone-900">${{ number_format($item['subtotal'], 2) }}</p>
              </div>
              @endforeach
            </div>

            <div class="border-t border-stone-300 pt-4 sm:pt-6 space-y-3 sm:space-y-4">
              <div class="flex justify-between items-center text-xs sm:text-sm">
                <span class="text-stone-600">Subtotal</span>
                <span class="font-bold text-stone-900">${{ number_format($subtotal, 2) }}</span>
              </div>
              <div class="flex justify-between items-center text-xs sm:text-sm">
                <span class="text-stone-600">Shipping</span>
                <span class="font-bold text-stone-900">
                  @if($shipping_cost == 0)
                  FREE
                  @else
                  ${{ number_format($shipping_cost, 2) }}
                  @endif
                </span>
              </div>
              <div class="border-t border-stone-300 pt-3 sm:pt-4">
                <div class="flex justify-between items-center">
                  <span class="font-bold text-stone-900">Total</span>
                  <span class="text-2xl sm:text-3xl font-bold text-stone-900">${{ number_format($total, 2) }}</span>
                </div>
              </div>
            </div>

            @if($subtotal >= 100)
            <p class="text-xs text-stone-600 text-center bg-stone-100 p-3 rounded">
              ✓ Free shipping on your order!
            </p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
