@extends('layouts.app')

@section('title', 'Our Heritage')

@section('content')
<main>
  <!-- Page Header -->
  <section class="section-py border-b border-stone-300 container-fluid">
    <h1 class="mb-3 sm:mb-4">OUR HERITAGE</h1>
    <p class="text-stone-600 tracking-wide text-xs sm:text-sm">A century of American craftsmanship.</p>
  </section>

  <!-- Timeline -->
  <section class="section-py container-fluid">
    <div class="space-y-12 sm:space-y-16">
      <!-- Era 1 -->
      <div class="flex gap-4 sm:gap-8 md:gap-16">
        <div class="w-16 sm:w-24 flex-shrink-0">
          <div class="text-xl sm:text-2xl font-bold text-stone-900">1924</div>
          <div class="text-xs text-stone-600 mt-1 sm:mt-2">FOUNDED</div>
        </div>
        <div class="flex-1 pb-8 sm:pb-12 border-b border-stone-300">
          <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">The Beginning</h3>
          <p class="text-stone-600 leading-relaxed text-xs sm:text-sm">
            Toxaway Knitting Company was founded in the mountains of North Carolina by three Welsh immigrant artisans. They brought with them centuries of European knitting traditions.
          </p>
        </div>
      </div>

      <!-- Era 2 -->
      <div class="flex gap-4 sm:gap-8 md:gap-16">
        <div class="w-16 sm:w-24 flex-shrink-0">
          <div class="text-xl sm:text-2xl font-bold text-stone-900">1950s</div>
          <div class="text-xs text-stone-600 mt-1 sm:mt-2">GOLDEN AGE</div>
        </div>
        <div class="flex-1 pb-8 sm:pb-12 border-b border-stone-300">
          <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">Post-War Expansion</h3>
          <p class="text-stone-600 leading-relaxed text-xs sm:text-sm">
            During the post-war boom, Toxaway expanded production to supply American textile mills. Our sweaters became standard issue for outdoor workers across the Southeast.
          </p>
        </div>
      </div>

      <!-- Era 3 -->
      <div class="flex gap-4 sm:gap-8 md:gap-16">
        <div class="w-16 sm:w-24 flex-shrink-0">
          <div class="text-xl sm:text-2xl font-bold text-stone-900">1980s</div>
          <div class="text-xs text-stone-600 mt-1 sm:mt-2">EVOLUTION</div>
        </div>
        <div class="flex-1 pb-8 sm:pb-12 border-b border-stone-300">
          <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">The Digital Transition</h3>
          <p class="text-stone-600 leading-relaxed text-xs sm:text-sm">
            While other American mills closed, Toxaway invested in precision machinery while maintaining hand-finishing techniques. We stayed true to our craft.
          </p>
        </div>
      </div>

      <!-- Era 4 -->
      <div class="flex gap-4 sm:gap-8 md:gap-16">
        <div class="w-16 sm:w-24 flex-shrink-0">
          <div class="text-xl sm:text-2xl font-bold text-stone-900">2020s</div>
          <div class="text-xs text-stone-600 mt-1 sm:mt-2">TODAY</div>
        </div>
        <div class="flex-1">
          <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">American Made Revival</h3>
          <p class="text-stone-600 leading-relaxed text-xs sm:text-sm">
            In an era of outsourced manufacturing, Toxaway remains committed to American production. Four generations later, we're stronger than ever.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="section-py bg-stone-100 mx-4 sm:mx-0 sm:my-12 md:mx-6 lg:mx-8 rounded text-center">
    <div class="container-fluid">
      <div class="grid-3col">
        <div>
          <div class="text-2xl sm:text-4xl font-bold text-stone-900 mb-2 sm:mb-3">100+</div>
          <p class="text-xs sm:text-sm text-stone-600">Years of Heritage</p>
        </div>
        <div>
          <div class="text-2xl sm:text-4xl font-bold text-stone-900 mb-2 sm:mb-3">50K+</div>
          <p class="text-xs sm:text-sm text-stone-600">Sweaters Hand-Crafted</p>
        </div>
        <div>
          <div class="text-2xl sm:text-4xl font-bold text-stone-900 mb-2 sm:mb-3">4</div>
          <p class="text-xs sm:text-sm text-stone-600">Generations Family-Owned</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Values -->
  <section class="section-py container-fluid">
    <h2 class="mb-8 sm:mb-12">OUR VALUES</h2>
    <div class="grid-2col">
      <div class="border-l-4 border-stone-900 pl-4 sm:pl-6">
        <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">QUALITY OVER QUANTITY</h3>
        <p class="text-stone-600 leading-relaxed text-xs sm:text-sm">We produce fewer pieces, but each one is built to last. No shortcuts. No compromises.</p>
      </div>
      <div class="border-l-4 border-stone-900 pl-4 sm:pl-6">
        <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">AMERICAN MADE</h3>
        <p class="text-stone-600 leading-relaxed text-xs sm:text-sm">Every thread, stitch, and seam is produced right here in North Carolina. American jobs for American workers.</p>
      </div>
      <div class="border-l-4 border-stone-900 pl-4 sm:pl-6">
        <h3 class="text-stone-900 mb-2 sm:mb-3 text-xs sm:text-sm">CRAFT MASTERY</h3>
        <p class="text-xs text-stone-600 leading-relaxed">Our artisans train for years to perfect their craft. Skill matters. Experience shows.</p>
      </div>
      <div class="border-l-4 border-stone-900 pl-6">
        <h3 class="text-sm font-bold tracking-widest uppercase mb-3">SUSTAINABILITY</h3>
        <p class="text-xs text-stone-600 leading-relaxed">We produce durable goods built to last generations. The most sustainable piece is one you never replace.</p>
      </div>
    </div>
  </section>
</main>
@endsection
