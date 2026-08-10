@extends('layouts.app')

@section('title', $product->name)

@section('content')
<main>
  <!-- Page Header -->
  <section class="section-py border-b border-stone-300 container-fluid">
    <div class="mb-4 sm:mb-6">
      <a href="/shop" class="text-xs sm:text-sm text-stone-600 hover:text-stone-900 transition">← BACK TO SHOP</a>
    </div>
    <h1 class="mb-3 sm:mb-4">{{ $product->name }}</h1>
    <p class="text-stone-600 tracking-wide text-xs sm:text-sm">{{ $product->category }}</p>
  </section>

  <!-- Product Details -->
  <section class="section-py container-fluid">
    <div class="grid-2col gap-8 sm:gap-12">
      <!-- Product Image -->
      <div>
        @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover rounded mb-4 sm:mb-6" loading="lazy" decoding="async">
        @else
        <div class="bg-stone-200 w-full aspect-square rounded flex items-center justify-center text-xs text-stone-600 mb-4 sm:mb-6">
          [{{ $product->name }}]
        </div>
        @endif
        @if($product->category === 'custom')
        <p class="text-xs sm:text-sm text-stone-600">Custom items are built to order. Contact us for personalized consultation.</p>
        @else
        <div class="flex gap-2 text-xs">
          <span class="px-3 py-2 bg-stone-100 rounded text-stone-700">In Stock</span>
          <span class="px-3 py-2 bg-stone-100 rounded text-stone-700">Ships in 2-3 days</span>
        </div>
        @endif
      </div>

      <!-- Product Info -->
      <div>
        <div class="mb-8">
          @if($product->price > 0)
          <div class="text-3xl sm:text-4xl font-bold text-stone-900 mb-2">
            ${{ number_format($product->price, 2) }}
          </div>
          @else
          <div class="text-2xl sm:text-3xl font-bold text-stone-600 mb-2">
            Custom Quote
          </div>
          @endif
          <p class="text-stone-600 text-xs sm:text-sm">All prices include standard shipping to continental US</p>
        </div>

        <!-- Description -->
        <div class="mb-8 sm:mb-12 pb-8 sm:pb-12 border-b border-stone-300">
          <h2 class="mb-4 sm:mb-6">PRODUCT DETAILS</h2>
          <p class="text-stone-600 leading-relaxed text-xs sm:text-sm">
            {{ $product->description }}
          </p>
        </div>

        <!-- Add to Cart -->
        <div class="mb-8 sm:mb-12">
          @if($product->category === 'custom')
          <a href="/custom-jacket" class="btn-primary w-full text-center block mb-3 sm:mb-4">DESIGN YOUR OWN</a>
          <button type="button" onclick="requestConsultation()" class="btn-secondary w-full">REQUEST CONSULTATION</button>
          @else
          <!-- Color Selection -->
          @if($product->colors && count($product->colors) > 0)
          <div class="mb-4">
            <label for="color-{{ $product->id }}" class="block text-xs sm:text-sm text-stone-600 mb-2">COLOR</label>
            <select
              id="color-{{ $product->id }}"
              class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-stone-900 focus:ring-offset-2">
              <option value="">Select a color</option>
              @foreach($product->colors as $color)
              <option value="{{ $color }}">
                {{ match($color) {
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
                  default => $color
                } }}
              </option>
              @endforeach
            </select>
          </div>
          @endif
          @if($product->sizes && count($product->sizes) > 0)
          <div class="mb-4">
            <label for="size-{{ $product->id }}" class="block text-xs sm:text-sm text-stone-600 mb-2">SIZE</label>
            <select
              id="size-{{ $product->id }}"
              class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-stone-900 focus:ring-offset-2">
              <option value="">Select a size</option>
              @foreach($product->sizes as $size)
              <option value="{{ $size }}">
                {{ match($size) {
                  'sm' => 'Small',
                  'md' => 'Medium',
                  'lg' => 'Large',
                  'xl' => 'Extra Large',
                  'xxl' => 'Extra Extra Large',
                  default => $size
                } }}
              </option>
              @endforeach
            </select>
          </div>
          @endif
          <div class="mb-4">
            <label for="quantity-{{ $product->id }}" class="block text-xs sm:text-sm text-stone-600 mb-2">QUANTITY</label>
            <input
              type="number"
              id="quantity-{{ $product->id }}"
              min="1"
              max="99"
              value="1"
              class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-stone-300 rounded text-stone-900 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-stone-900 focus:ring-offset-2">
          </div>
          <button
            type="button"
            data-add-to-cart="{{ $product->id }}"
            class="btn-primary w-full">
            ADD TO CART
          </button>
          <p class="text-xs text-stone-600 mt-3 sm:mt-4 text-center">
            Free shipping on orders over $100
          </p>
          @endif
        </div>

        <!-- Additional Info -->
        <div class="space-y-6 sm:space-y-8 pt-8 sm:pt-12 border-t border-stone-300">
          <div>
            <h3 class="text-xs sm:text-sm font-bold text-stone-900 mb-2">CARE INSTRUCTIONS</h3>
            <p class="text-xs sm:text-sm text-stone-600">
              Hand wash in cool water with mild detergent. Lay flat to dry. Do not bleach or dry clean. Reshape while damp if needed.
            </p>
          </div>

          <div>
            <h3 class="text-xs sm:text-sm font-bold text-stone-900 mb-2">RETURNS & EXCHANGES</h3>
            <p class="text-xs sm:text-sm text-stone-600">
              30-day satisfaction guarantee. Free returns on unopened items. Contact our team for any issues.
            </p>
          </div>

          <div>
            <h3 class="text-xs sm:text-sm font-bold text-stone-900 mb-2">NEED HELP?</h3>
            <p class="text-xs sm:text-sm text-stone-600">
              <a href="/contact" class="text-stone-900 hover:underline">Contact us</a> for sizing guidance, material questions, or bulk orders.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Related Products -->
  <section class="section-py bg-stone-100 container-fluid">
    <h2 class="mb-8 sm:mb-12">YOU MIGHT ALSO LIKE</h2>
    <div class="grid-3col">
      @foreach($relatedProducts as $related)
      <div class="card">
        <div class="bg-stone-200 w-full aspect-square flex items-center justify-center text-xs text-stone-600">[{{ $related->name }}]</div>
        <div class="p-4 sm:p-6">
          <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">{{ $related->name }}</h3>
          <p class="text-stone-600 leading-relaxed mb-3 sm:mb-4 text-xs">
            {{ Str::limit($related->description, 60) }}
          </p>
          <div class="flex justify-between items-center mb-3 sm:mb-4 text-xs">
            <span class="font-bold">${{ number_format($related->price, 2) }}</span>
            <span class="text-stone-600">In Stock</span>
          </div>
          <div class="space-y-2">
            <a href="/shop/{{ $related->slug }}" class="btn-primary w-full text-center block text-xs">SELECT OPTIONS</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>
</main>
