@extends('layouts.app')

@section('title', 'Home')

@section('content')
<main>
  <!-- Hero Section -->
  <section class="text-center section-py border-b border-stone-300 container-fluid">
    <h1 class="mb-4 sm:mb-6">Toxaway Knitting Company</h1>
    <p class="text-stone-600 mb-6 sm:mb-10 tracking-widest text-xs sm:text-sm">Crafted for durability. Built to last.</p>
    <p class="text-stone-600 mb-6 sm:mb-10 tracking-widest text-xs sm:text-sm">Heavyweight American-Made Knitwear.</p>

    <div class="flex gap-3 sm:gap-4 justify-center flex-wrap">
      <a href="/shop" class="btn-primary">SHOP SWEATERS</a>
      <a href="/custom-jacket" class="btn-secondary">BUILD CUSTOM JACKET</a>
    </div>
  </section>

  <!-- Trust Block -->
  <section class="section-py border-b border-stone-300 text-center container-fluid">
    <div class="grid-3col">
      <div>
        <h3 class="text-stone-600 mb-2 sm:mb-3">American Made</h3>
        <p class="text-stone-700 text-xs sm:text-sm">Every piece produced in North Carolina with domestic yarn.</p>
      </div>
      <div>
        <h3 class="text-stone-600 mb-2 sm:mb-3">Heritage Craft</h3>
        <p class="text-stone-700 text-xs sm:text-sm">Decades of knitting expertise in every stitch.</p>
      </div>
      <div>
        <h3 class="text-stone-600 mb-2 sm:mb-3">Lifetime Quality</h3>
        <p class="text-stone-700 text-xs sm:text-sm">Built to last generations with proper care.</p>
      </div>
    </div>
  </section>

  <!-- Featured Products -->
  <section class="section-py container-fluid">
    <h2 class="mb-8 sm:mb-12">FEATURED COLLECTION</h2>
    <div class="grid-3col">
      <div class="card p-4 sm:p-6">
        <div class="bg-stone-200 w-full aspect-square mb-4 flex items-center justify-center text-xs text-stone-600">[Heavyweight Sweater]</div>
        <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">Wool Sweater — Heavyweight</h3>
        <p class="text-stone-600 leading-relaxed mb-3 sm:mb-4 text-xs">100% merino wool. Perfect for cool weather and outdoor work.</p>
        <p class="text-xs font-bold mb-3 sm:mb-4">$89.99</p>
        <button class="btn-primary w-full">ADD TO CART</button>
      </div>

      <div class="card p-4 sm:p-6">
        <div class="bg-stone-200 w-full aspect-square mb-4 flex items-center justify-center text-xs text-stone-600">[Riding Sweater]</div>
        <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">Riding Sweater — Merino</h3>
        <p class="text-stone-600 leading-relaxed mb-3 sm:mb-4 text-xs">Designed for equestrian enthusiasts. Breathable and durable.</p>
        <p class="text-xs font-bold mb-3 sm:mb-4">$129.99</p>
        <button class="btn-primary w-full">ADD TO CART</button>
      </div>

      <div class="card p-4 sm:p-6">
        <div class="bg-stone-200 w-full aspect-square mb-4 flex items-center justify-center text-xs text-stone-600">[Custom Jacket]</div>
        <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">Custom Varsity Jacket</h3>
        <p class="text-stone-600 leading-relaxed mb-3 sm:mb-4 text-xs">Fully personalized design. Consultations available.</p>
        <p class="text-xs font-bold mb-3 sm:mb-4">QUOTE</p>
        <a href="/custom-jacket" class="btn-primary block w-full text-center">REQUEST QUOTE</a>
      </div>
    </div>
  </section>

  <!-- Process Section -->
  <section class="section-py bg-stone-100 mx-4 sm:mx-0 sm:my-12 md:mx-6 lg:mx-8 rounded">
    <div class="container-fluid">
      <h2 class="mb-8 sm:mb-12 text-center">THE TOXAWAY PROCESS</h2>
      <div class="grid-4col">
        <div class="text-center">
          <div class="text-2xl sm:text-4xl font-bold text-stone-900 mb-2 sm:mb-3">1</div>
          <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">Design</h3>
          <p class="text-stone-700 text-xs">Sketch your custom jacket or choose a preset.</p>
        </div>
        <div class="text-center">
          <div class="text-2xl sm:text-4xl font-bold text-stone-900 mb-2 sm:mb-3">2</div>
          <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">Quote</h3>
          <p class="text-stone-700 text-xs">Receive a detailed quote within 24 hours.</p>
        </div>
        <div class="text-center">
          <div class="text-2xl sm:text-4xl font-bold text-stone-900 mb-2 sm:mb-3">3</div>
          <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">Craft</h3>
          <p class="text-stone-700 text-xs">Our artisans hand-craft your unique piece.</p>
        </div>
        <div class="text-center">
          <div class="text-2xl sm:text-4xl font-bold text-stone-900 mb-2 sm:mb-3">4</div>
          <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">Deliver</h3>
          <p class="text-stone-700 text-xs">Your finished jacket ships within 6 weeks.</p>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
