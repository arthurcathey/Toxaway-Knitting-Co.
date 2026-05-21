@extends('layouts.app')

@section('title', 'Craftsmanship')

@section('content')
<main>
  <!-- Page Header -->
  <section class="section-py border-b border-stone-300 container-fluid">
    <h1 class="mb-3 sm:mb-4">OUR CRAFTSMANSHIP</h1>
    <p class="text-stone-600 tracking-wide text-xs sm:text-sm">How we build the world's finest knitwear.</p>
  </section>

  <!-- Process Steps -->
  <section class="section-py container-fluid">
    <h2 class="mb-8 sm:mb-12">THE PRODUCTION PROCESS</h2>

    <div class="space-y-8 sm:space-y-12">
      <!-- Step 1 -->
      <div class="grid-2col items-center pb-8 sm:pb-12 border-b border-stone-300">
        <div>
          <div class="bg-stone-200 w-full aspect-video rounded flex items-center justify-center text-xs text-stone-600">[Step 1 Visual]</div>
        </div>
        <div>
          <div class="flex items-baseline gap-3 sm:gap-4 mb-3 sm:mb-4">
            <span class="text-2xl sm:text-4xl font-bold text-stone-900">01</span>
            <h3 class="text-stone-900 text-xs sm:text-sm font-bold tracking-widest uppercase">YARN SELECTION</h3>
          </div>
          <p class="text-stone-600 leading-relaxed text-xs sm:text-sm">
            We source premium wool, merino, and alpaca fibers from certified mills. Every batch is tested for quality, strength, and durability. We reject anything that doesn't meet our standards.
          </p>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="grid-2col items-center pb-8 sm:pb-12 border-b border-stone-300">
        <div class="md:order-2 order-2">
          <div class="bg-stone-200 w-full aspect-video rounded flex items-center justify-center text-xs text-stone-600">[Step 2 Visual]</div>
        </div>
        <div class="md:order-1 order-1">
          <div class="flex items-baseline gap-3 sm:gap-4 mb-3 sm:mb-4">
            <span class="text-2xl sm:text-4xl font-bold text-stone-900">02</span>
            <h3 class="text-stone-900 text-xs sm:text-sm font-bold tracking-widest uppercase">DYEING</h3>
          </div>
          <p class="text-stone-600 leading-relaxed text-xs sm:text-sm">
            Our dyes are carefully selected for color vibrancy and permanence. We use environmentally responsible processes to color our yarn in large vats.
          </p>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center pb-12 border-b border-stone-300">
        <div>
          <div class="bg-stone-200 w-full aspect-video rounded flex items-center justify-center text-xs text-stone-600">[Step 3 Visual]</div>
        </div>
        <div>
          <div class="flex items-baseline gap-4 mb-4">
            <span class="text-3xl font-bold text-stone-900">03</span>
            <h3 class="text-lg font-bold tracking-widest uppercase">KNITTING</h3>
          </div>
          <p class="text-xs text-stone-600 leading-relaxed">
            Our computerized looms are operated by skilled technicians with 20+ years of experience. The tension, speed, and calibration are precisely controlled to create uniform panels.
          </p>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center pb-12 border-b border-stone-300">
        <div class="md:order-2">
          <div class="bg-stone-200 w-full aspect-video rounded flex items-center justify-center text-xs text-stone-600">[Step 4 Visual]</div>
        </div>
        <div class="md:order-1">
          <div class="flex items-baseline gap-4 mb-4">
            <span class="text-3xl font-bold text-stone-900">04</span>
            <h3 class="text-lg font-bold tracking-widest uppercase">BLOCKING</h3>
          </div>
          <p class="text-xs text-stone-600 leading-relaxed">
            Individual panels are steamed and blocked to exact specifications. This process sets the shape and ensures consistent sizing across all pieces.
          </p>
        </div>
      </div>

      <!-- Step 5 -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center pb-12 border-b border-stone-300">
        <div>
          <div class="bg-stone-200 w-full aspect-video rounded flex items-center justify-center text-xs text-stone-600">[Step 5 Visual]</div>
        </div>
        <div>
          <div class="flex items-baseline gap-4 mb-4">
            <span class="text-3xl font-bold text-stone-900">05</span>
            <h3 class="text-lg font-bold tracking-widest uppercase">SEAMING</h3>
          </div>
          <p class="text-xs text-stone-600 leading-relaxed">
            Hand-seaming is where magic happens. Our seamers use invisible seaming techniques to join panels with precision. Each seam is checked twice before moving forward.
          </p>
        </div>
      </div>

      <!-- Step 6 -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <div class="md:order-2">
          <div class="bg-stone-200 w-full aspect-video rounded flex items-center justify-center text-xs text-stone-600">[Step 6 Visual]</div>
        </div>
        <div class="md:order-1">
          <div class="flex items-baseline gap-4 mb-4">
            <span class="text-3xl font-bold text-stone-900">06</span>
            <h3 class="text-lg font-bold tracking-widest uppercase">FINISHING</h3>
          </div>
          <p class="text-xs text-stone-600 leading-relaxed">
            Final quality checks, pressing, labeling, and packaging. Each sweater is folded by hand and inspected one final time before shipping to you.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Materials -->
  <section class="py-16 bg-stone-100 px-6 rounded my-16">
    <h2 class="text-2xl font-bold tracking-wider mb-12">OUR MATERIALS</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
      <div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-3">MERINO WOOL</h3>
        <p class="text-xs text-stone-600 leading-relaxed mb-4">
          Fine merino wool provides superior softness, breathability, and temperature regulation. Our merino blends are sourced from certified sustainable farms.
        </p>
        <ul class="text-xs text-stone-600 space-y-1">
          <li>✓ Temperature regulating</li>
          <li>✓ Moisture wicking</li>
          <li>✓ Naturally antimicrobial</li>
          <li>✓ Sustainable & renewable</li>
        </ul>
      </div>

      <div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-3">ALPACA FIBER</h3>
        <p class="text-xs text-stone-600 leading-relaxed mb-4">
          Luxurious alpaca fiber is hypoallergenic and incredibly soft. Warmer than wool but lighter in weight. A premium choice for our finest pieces.
        </p>
        <ul class="text-xs text-stone-600 space-y-1">
          <li>✓ 7x warmer than wool</li>
          <li>✓ Hypoallergenic</li>
          <li>✓ Ultra-soft feel</li>
          <li>✓ Sustainable grazing</li>
        </ul>
      </div>

      <div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-3">COTTON BLENDS</h3>
        <p class="text-xs text-stone-600 leading-relaxed mb-4">
          Carefully selected cotton is blended with wool for breathability and comfort. Perfect for warmer weather pieces.
        </p>
        <ul class="text-xs text-stone-600 space-y-1">
          <li>✓ Breathable</li>
          <li>✓ Cool to wear</li>
          <li>✓ Easy care</li>
          <li>✓ Durable construction</li>
        </ul>
      </div>

      <div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-3">LINEN ACCENTS</h3>
        <p class="text-xs text-stone-600 leading-relaxed mb-4">
          Premium linen is used for details and accents. Linen becomes softer with every wash and ages beautifully.
        </p>
        <ul class="text-xs text-stone-600 space-y-1">
          <li>✓ Strong & durable</li>
          <li>✓ Gets softer with age</li>
          <li>✓ Highly breathable</li>
          <li>✓ Eco-friendly</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Quality Assurance -->
  <section class="py-16">
    <h2 class="text-2xl font-bold tracking-wider mb-12">QUALITY ASSURANCE</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
      <div class="border border-stone-300 p-6 bg-white">
        <div class="text-2xl font-bold text-stone-900 mb-3">✓</div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-3">Testing</h3>
        <p class="text-xs text-stone-600 leading-relaxed">Every batch of raw materials is tested for strength, color fastness, and durability before knitting begins.</p>
      </div>

      <div class="border border-stone-300 p-6 bg-white">
        <div class="text-2xl font-bold text-stone-900 mb-3">✓</div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-3">Inspection</h3>
        <p class="text-xs text-stone-600 leading-relaxed">Products are visually inspected at three critical stages: after knitting, after seaming, and before packaging.</p>
      </div>

      <div class="border border-stone-300 p-6 bg-white">
        <div class="text-2xl font-bold text-stone-900 mb-3">✓</div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-3">Durability</h3>
        <p class="text-xs text-stone-600 leading-relaxed">We conduct pilling resistance tests, shrinkage tests, and colorfastness tests to ensure long-term durability.</p>
      </div>
    </div>
  </section>
</main>
@endsection
