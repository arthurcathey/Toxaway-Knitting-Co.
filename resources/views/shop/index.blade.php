@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<main>
  <!-- Page Header -->
  <section class="section-py border-b border-stone-300 container-fluid">
    <h1 class="mb-3 sm:mb-4">OUR COLLECTION</h1>
    <p class="text-stone-600 tracking-wide text-xs sm:text-sm">Premium heavyweight knitwear. All American-made.</p>
  </section>

  <!-- Category Filter -->
  <section class="py-4 sm:py-6 border-b border-stone-300 container-fluid">
    <div class="flex gap-3 sm:gap-4 flex-wrap text-xs">
      <a href="/shop" class="font-bold tracking-widest text-stone-900 pb-2 border-b-2 border-stone-900">ALL</a>
      <a href="/shop?category=sweaters" class="tracking-widest text-stone-600 pb-2 hover:text-stone-900 transition">SWEATERS</a>
      <a href="/shop?category=riding" class="tracking-widest text-stone-600 pb-2 hover:text-stone-900 transition">RIDING WEAR</a>
      <a href="/shop?category=custom" class="tracking-widest text-stone-600 pb-2 hover:text-stone-900 transition">CUSTOM</a>
    </div>
  </section>

  <!-- Products Grid -->
  <section class="section-py container-fluid">
    <div class="grid-3col">
      @forelse($products as $product)
      <div class="card">
        <div class="bg-stone-200 w-full aspect-square flex items-center justify-center text-xs text-stone-600">[{{ $product->name }}]</div>
        <div class="p-4 sm:p-6">
          <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">{{ $product->name }}</h3>
          <p class="text-stone-600 leading-relaxed mb-3 sm:mb-4 text-xs">
            {{ Str::limit($product->description, 80) }}
          </p>
          <div class="flex justify-between items-center mb-3 sm:mb-4 text-xs">
            @if($product->price > 0)
            <span class="font-bold">${{ number_format($product->price, 2) }}</span>
            @else
            <span class="font-bold">CUSTOM QUOTE</span>
            @endif
            <span class="text-stone-600">{{ $product->in_stock ? 'In Stock' : 'Out of Stock' }}</span>
          </div>
          <div class="space-y-2">
            @if($product->category === 'custom')
            <a href="/custom-jacket" class="btn-primary w-full text-center block text-xs">START BUILDER</a>
            <a href="/shop/{{ $product->slug }}" class="btn-secondary w-full text-center block text-xs">LEARN MORE</a>
            @else
            <button
              type="button"
              data-add-to-cart="{{ $product->id }}"
              class="btn-primary w-full text-xs">
              ADD TO CART
            </button>
            <a href="/shop/{{ $product->slug }}" class="btn-secondary w-full text-center block text-xs">VIEW DETAILS</a>
            @endif
          </div>
        </div>
      </div>
      @empty
      <div class="col-span-full text-center py-12">
        <p class="text-stone-600 text-xs sm:text-sm">No products found</p>
      </div>
      @endforelse
    </div>
  </section>

  <!-- CTA Section -->
  <section class="section-py bg-stone-900 text-stone-50 mx-4 sm:mx-0 sm:my-12 md:mx-6 lg:mx-8 rounded text-center">
    <div class="container-fluid">
      <h2 class="mb-3 sm:mb-4 text-stone-50">NOT SURE WHAT YOU NEED?</h2>
      <p class="text-xs sm:text-sm text-stone-200 mb-6 sm:mb-8">Contact our team for personalized recommendations and sizing guidance.</p>
      <a href="/contact" class="btn border-2 border-stone-50 text-stone-50 hover:bg-stone-50 hover:text-stone-900 inline-block">GET IN TOUCH</a>
    </div>
  </section>
</main>

<script>
  function addToCart(productId) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
          product_id: productId,
          quantity: 1,
        }),
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Added to cart! You now have ' + data.cartCount + ' item(s).');
          updateCartCount(data.cartCount);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Failed to add to cart. Please try again.');
      });
  }

  function updateCartCount(count) {
    const cartLink = document.querySelector('[data-cart-count]');
    if (cartLink) {
      cartLink.setAttribute('data-cart-count', count);
    }
  }
</script>

@endsection
