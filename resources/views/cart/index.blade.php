@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<main>
  <!-- Page Header -->
  <section class="section-py border-b border-stone-300 container-fluid">
    <h1 class="mb-3 sm:mb-4">SHOPPING CART</h1>
    <p class="text-stone-600 tracking-wide text-xs sm:text-sm">Review your items before checkout.</p>
  </section>

  @if(count($items) > 0)
  <!-- Cart Items -->
  <section class="section-py container-fluid">
    <div class="grid-2col gap-8 sm:gap-12">
      <!-- Cart Items List -->
      <div>
        <h2 class="mb-6 sm:mb-8">YOUR ITEMS</h2>
        <div class="space-y-4 sm:space-y-6">
          @foreach($items as $item)
          <div class="card p-4 sm:p-6 border-l-4 border-l-stone-900">
            <div class="flex justify-between items-start mb-3 sm:mb-4">
              <div>
                <h3 class="text-stone-900 text-xs sm:text-sm font-bold mb-1">{{ $item['product_name'] }}</h3>
                @if($item['color'])
                <p class="text-stone-600 text-xs">Color: {{ match($item['color']) {
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
                  default => $item['color']
                } }}</p>
                @endif
                @if($item['size'])
                <p class="text-stone-600 text-xs">Size: {{ match($item['size']) {
                  'sm' => 'Small',
                  'md' => 'Medium',
                  'lg' => 'Large',
                  'xl' => 'Extra Large',
                  'xxl' => 'Extra Extra Large',
                  default => $item['size']
                } }}</p>
                @endif
              </div>
              <button
                type="button"
                data-product-id="{{ $item['product_id'] }}"
                data-size="{{ $item['size'] }}"
                data-color="{{ $item['color'] }}"
                class="remove-cart-btn text-stone-600 hover:text-stone-900 transition text-xs">
                ✕
              </button>
            </div>

            <div class="flex justify-between items-end">
              <div>
                <p class="text-stone-600 text-xs mb-2">Price: <span class="font-bold text-stone-900">${{ number_format($item['price'], 2) }}</span></p>
                <div class="flex items-center gap-2">
                  <label for="qty-{{ $item['key'] }}" class="text-xs text-stone-600">Qty:</label>
                  <input
                    type="number"
                    id="qty-{{ $item['key'] }}"
                    value="{{ $item['quantity'] }}"
                    min="1"
                    max="99"
                    data-product-id="{{ $item['product_id'] }}"
                    data-size="{{ $item['size'] }}"
                    data-color="{{ $item['color'] }}"
                    class="quantity-input w-12 px-2 py-1 border border-stone-300 rounded text-xs text-stone-900 focus:outline-none focus:border-stone-900">
                </div>
              </div>
              <p class="text-lg font-bold text-stone-900">${{ number_format($item['subtotal'], 2) }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Order Summary -->
      <div>
        <div class="sticky top-24">
          <h2 class="mb-6 sm:mb-8">ORDER SUMMARY</h2>

          <div class="card p-6 sm:p-8 space-y-4 sm:space-y-6">
            <div>
              <div class="flex justify-between items-center mb-3 sm:mb-4">
                <span class="text-stone-600 text-xs sm:text-sm">Subtotal</span>
                <span class="font-bold text-stone-900">${{ number_format($total, 2) }}</span>
              </div>
              <div class="flex justify-between items-center mb-3 sm:mb-4">
                <span class="text-stone-600 text-xs sm:text-sm">Shipping</span>
                <span class="font-bold text-stone-900">
                  @if($total >= 100)
                  FREE
                  @else
                  $10.00
                  @endif
                </span>
              </div>
              <div class="border-t border-stone-300 pt-3 sm:pt-4">
                <div class="flex justify-between items-center">
                  <span class="font-bold text-stone-900">Total</span>
                  <span class="text-2xl sm:text-3xl font-bold text-stone-900">
                    ${{ number_format($total + ($total >= 100 ? 0 : 10), 2) }}
                  </span>
                </div>
              </div>
            </div>

            <a href="{{ route('order.checkout') }}" class="btn-primary w-full text-center block">PROCEED TO CHECKOUT</a>
            <a href="/shop" class="btn-secondary w-full text-center block">CONTINUE SHOPPING</a>

            @if($total >= 100)
            <p class="text-xs text-stone-600 text-center bg-stone-100 p-3 rounded">
              ✓ Free shipping on your order!
            </p>
            @else
            <p class="text-xs text-stone-600 text-center bg-stone-100 p-3 rounded">
              Free shipping on orders over $100. Add ${{ number_format(100 - $total, 2) }} more!
            </p>
            @endif
          </div>

          <!-- Trust Badges -->
          <div class="mt-6 sm:mt-8 space-y-3 text-center">
            <p class="text-xs text-stone-600">ecurSe checkout</p>
            <p class="text-xs text-stone-600">Fast shipping</p>
            <p class="text-xs text-stone-600">30-day returns</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Related Products -->
  <section class="section-py bg-stone-100 container-fluid">
    <h2 class="mb-8 sm:mb-12">COMPLETE YOUR ORDER</h2>
    <p class="text-stone-600 text-xs sm:text-sm mb-6 sm:mb-8">These items pair great with what you've selected.</p>
    <div class="grid-3col">
      <!-- Sample recommendations -->
      <div class="card">
        <div class="bg-stone-200 w-full aspect-square flex items-center justify-center text-xs text-stone-600">[Recommended Item 1]</div>
        <div class="p-4 sm:p-6">
          <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">Premium Sweater Care Kit</h3>
          <p class="text-stone-600 leading-relaxed mb-3 sm:mb-4 text-xs">Specialized cleaning and maintenance products</p>
          <div class="flex justify-between items-center mb-3 sm:mb-4 text-xs">
            <span class="font-bold">$24.99</span>
            <span class="text-stone-600">In Stock</span>
          </div>
          <button onclick="addToCart()" class="btn-primary w-full text-xs">ADD TO CART</button>
        </div>
      </div>
    </div>
  </section>
  @else
  <!-- Empty Cart -->
  <section class="section-py container-fluid">
    <div class="text-center py-16 sm:py-24">
      <div class="text-6xl sm:text-8xl mb-4 sm:mb-6"></div>
      <h2 class="mb-3 sm:mb-4 text-stone-600">YOUR CART IS EMPTY</h2>
      <p class="text-stone-600 text-xs sm:text-sm mb-8 sm:mb-12">
        Discover our collection of premium knitwear and add items to get started.
      </p>
      <a href="/shop" class="btn-primary inline-block">START SHOPPING</a>
    </div>
  </section>
  @endif
</main>

@endsection
