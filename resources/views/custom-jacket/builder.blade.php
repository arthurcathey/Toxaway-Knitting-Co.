@extends('layouts.app')

@section('title', 'Custom Varsity Jacket')

@section('content')
<main class="container-fluid section-py px-6 py-16">
  <div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-16 text-center">
      <h1 class="text-4xl font-bold mb-4">CUSTOM VARSITY JACKET</h1>
      <p class="text-stone-600">Hand-crafted to your exact specifications. Personalized. Durable. Built to last.</p>
    </div>

    <!-- Success Message -->
    @if (session('success'))
    <div class="mb-8 p-4 bg-green-50 border border-green-300 text-green-700 rounded-lg">
      {{ session('success') }}
    </div>
    @endif

    <!-- Process Overview -->
    <div class="mb-16">
      <h2 class="text-2xl font-bold mb-4">The Process</h2>
      <p class="text-stone-600 mb-8">Custom varsity jackets are the cornerstone of Toxaway's heritage. Each jacket celebrates personal achievement and community identity. Our step-by-step ordering flow ensures your vision becomes reality.</p>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="card">
          <div class="text-4xl font-bold text-stone-300 mb-2">01</div>
          <h3 class="text-sm font-bold tracking-widest uppercase mb-3">Choose Style</h3>
          <p class="text-xs text-stone-600">Select base design: classic varsity fit, cut, and weight. Available in multiple silhouettes.</p>
        </div>
        <div class="card">
          <div class="text-4xl font-bold text-stone-300 mb-2">02</div>
          <h3 class="text-sm font-bold tracking-widest uppercase mb-3">Color & Materials</h3>
          <p class="text-xs text-stone-600">Pick body colors, sleeves, and materials. Premium wools, linens, and leather options.</p>
        </div>
        <div class="card">
          <div class="text-4xl font-bold text-stone-300 mb-2">03</div>
          <h3 class="text-sm font-bold tracking-widest uppercase mb-3">Personalization</h3>
          <p class="text-xs text-stone-600">Upload reference images or artwork. Add name, year, school, or club embroidery.</p>
        </div>
        <div class="card">
          <div class="text-4xl font-bold text-stone-300 mb-2">04</div>
          <h3 class="text-sm font-bold tracking-widest uppercase mb-3">Sizing</h3>
          <p class="text-xs text-stone-600">Provide detailed measurements using our comprehensive guide for exact fit.</p>
        </div>
        <div class="card">
          <div class="text-4xl font-bold text-stone-300 mb-2">05</div>
          <h3 class="text-sm font-bold tracking-widest uppercase mb-3">Quote & Timeline</h3>
          <p class="text-xs text-stone-600">Receive personalized quote. 8-10 week production with progress updates.</p>
        </div>
        <div class="card">
          <div class="text-4xl font-bold text-stone-300 mb-2">06</div>
          <h3 class="text-sm font-bold tracking-widest uppercase mb-3">Delivery</h3>
          <p class="text-xs text-stone-600">Your finished jacket ships with tracking. Lifetime customer support included.</p>
        </div>
      </div>
    </div>

    <!-- Order Form -->
    <div class="mb-16">
      <h2 class="text-2xl font-bold mb-4">Start Your Custom Order</h2>
      <p class="text-stone-600 mb-8">Fill out this form to begin your custom varsity jacket journey. We'll review your specifications and send a detailed quote within 2-3 business days.</p>

      <div class="card">
        <form id="jacketForm" action="{{ route('custom-jacket.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- Contact Information -->
          <fieldset class="mb-8">
            <legend class="text-sm font-bold tracking-widest uppercase text-stone-900 mb-6">Contact Information</legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div>
                <label for="full_name" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Full Name *</label>
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                  class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900 @error('full_name') border-red-500 @enderror">
                @error('full_name')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label for="email" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Email Address *</label>
                <input type="email" id="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required
                  class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900 @error('email') border-red-500 @enderror">
                @error('email')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <div>
              <label for="phone" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Phone Number *</label>
              <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900 @error('phone') border-red-500 @enderror">
              @error('phone')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </fieldset>

          <!-- Design Selection -->
          <fieldset class="mb-8">
            <legend class="text-sm font-bold tracking-widest uppercase text-stone-900 mb-6">Design Selection</legend>

            <div class="mb-6">
              <label for="base_style" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Base Style *</label>
              <select id="base_style" name="base_style" required
                class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900 @error('base_style') border-red-500 @enderror">
                <option value="">-- Select Style --</option>
                <option value="Classic Varsity Cut" @selected(old('base_style')==='Classic Varsity Cut' )>Classic Varsity Cut</option>
                <option value="Oversized Fit" @selected(old('base_style')==='Oversized Fit' )>Oversized Fit</option>
                <option value="Fitted Silhouette" @selected(old('base_style')==='Fitted Silhouette' )>Fitted Silhouette</option>
                <option value="Cropped Length" @selected(old('base_style')==='Cropped Length' )>Cropped Length</option>
              </select>
              @error('base_style')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div>
                <label for="primary_color" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Primary Color (Body) *</label>
                <select id="primary_color" name="primary_color" required
                  class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900 @error('primary_color') border-red-500 @enderror">
                  <option value="">-- Select Color --</option>
                  <option value="Black" @selected(old('primary_color')==='Black' )>Black</option>
                  <option value="Navy Blue" @selected(old('primary_color')==='Navy Blue' )>Navy Blue</option>
                  <option value="Forest Green" @selected(old('primary_color')==='Forest Green' )>Forest Green</option>
                  <option value="Burgundy" @selected(old('primary_color')==='Burgundy' )>Burgundy</option>
                  <option value="Cream" @selected(old('primary_color')==='Cream' )>Cream</option>
                  <option value="Charcoal Gray" @selected(old('primary_color')==='Charcoal Gray' )>Charcoal Gray</option>
                </select>
                @error('primary_color')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label for="secondary_color" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Secondary Color (Sleeves) *</label>
                <select id="secondary_color" name="secondary_color" required
                  class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900 @error('secondary_color') border-red-500 @enderror">
                  <option value="">-- Select Color --</option>
                  <option value="Black" @selected(old('secondary_color')==='Black' )>Black</option>
                  <option value="Navy Blue" @selected(old('secondary_color')==='Navy Blue' )>Navy Blue</option>
                  <option value="Forest Green" @selected(old('secondary_color')==='Forest Green' )>Forest Green</option>
                  <option value="Burgundy" @selected(old('secondary_color')==='Burgundy' )>Burgundy</option>
                  <option value="Cream" @selected(old('secondary_color')==='Cream' )>Cream</option>
                  <option value="Charcoal Gray" @selected(old('secondary_color')==='Charcoal Gray' )>Charcoal Gray</option>
                </select>
                @error('secondary_color')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <div>
              <label for="material" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Material Selection *</label>
              <select id="material" name="material" required
                class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900 @error('material') border-red-500 @enderror">
                <option value="">-- Select Material --</option>
                <option value="Wool (100%)" @selected(old('material')==='Wool (100%)' )>Wool (100%)</option>
                <option value="Wool Blend (80/20)" @selected(old('material')==='Wool Blend (80/20)' )>Wool Blend (80/20)</option>
                <option value="Linen Blend" @selected(old('material')==='Linen Blend' )>Linen Blend</option>
                <option value="Leather Sleeves" @selected(old('material')==='Leather Sleeves' )>Leather Sleeves</option>
              </select>
              @error('material')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </fieldset>

          <!-- Sizing -->
          <fieldset class="mb-8">
            <legend class="text-sm font-bold tracking-widest uppercase text-stone-900 mb-6">Sizing</legend>

            <div class="mb-6">
              <label class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-3">Available Sizes *</label>
              <div class="space-y-2">
                @foreach(['sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large', 'xl' => 'Extra Large', 'xxl' => 'Extra Extra Large'] as $size => $label)
                <div class="flex items-center">
                  <input type="checkbox" id="size_{{ $size }}" name="sizes[]" value="{{ $size }}"
                    {{ in_array($size, old('sizes', [])) ? 'checked' : '' }}
                    class="h-4 w-4 rounded border-gray-300">
                  <label for="size_{{ $size }}" class="ml-2 text-xs text-stone-700">{{ $label }}</label>
                </div>
                @endforeach
              </div>
              @error('sizes')
              <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <p class="text-xs text-stone-600">Select the size(s) you need for your custom jacket. You can choose multiple sizes if ordering for a group.</p>
          </fieldset>

          <!-- Personalization -->
          <fieldset class="mb-8">
            <legend class="text-sm font-bold tracking-widest uppercase text-stone-900 mb-6">Personalization</legend>

            <div class="mb-6">
              <label for="front_text" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Front Letters/Text *</label>
              <input type="text" id="front_text" name="front_text" value="{{ old('front_text') }}" maxlength="50" placeholder="e.g., Your School or Club Name" required
                class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900 @error('front_text') border-red-500 @enderror">
              @error('front_text')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-6">
              <label for="custom_details" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Custom Details (Optional)</label>
              <textarea id="custom_details" name="custom_details" rows="6" maxlength="1000"
                class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900 @error('custom_details') border-red-500 @enderror"
                placeholder="Describe patches, sleeve designs, year, or other preferences...">{{ old('custom_details') }}</textarea>
              @error('custom_details')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="inspiration_image" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Reference Image (Optional)</label>
              <input type="file" id="inspiration_image" name="inspiration_image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900 @error('inspiration_image') border-red-500 @enderror">
              <p class="mt-1 text-xs text-stone-600">Supported formats: JPEG, PNG, GIF, WebP (Max 5MB)</p>
              @error('inspiration_image')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </fieldset>

          <!-- Errors Summary -->
          @if ($errors->any())
          <div class="mb-8 p-4 bg-red-50 border border-red-300 rounded-lg">
            <h3 class="text-sm font-bold text-red-600 mb-2">Please fix the following errors:</h3>
            <ul class="text-xs text-red-600">
              @foreach ($errors->all() as $error)
              <li>• {{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <!-- Submit Buttons -->
          <div class="flex gap-4">
            <button type="submit" class="flex-1 px-6 py-3 bg-stone-900 text-stone-50 text-xs font-bold tracking-widest uppercase hover:bg-stone-800 transition">
              Get Quote
            </button>
            <button type="reset" class="flex-1 px-6 py-3 border-2 border-stone-900 text-stone-900 text-xs font-bold tracking-widest uppercase hover:bg-stone-50 transition">
              Clear Form
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Timeline -->
    <div class="mb-16">
      <h2 class="text-2xl font-bold mb-8">Timeline & Expectations</h2>

      <div class="space-y-6">
        <div class="flex gap-6 pb-6 border-b border-stone-300">
          <div class="text-sm font-bold text-stone-600 flex-shrink-0 min-w-24">Days 1–3</div>
          <div class="text-xs text-stone-600"><strong>Quote Submission:</strong> Submit your form. Our team reviews specifications and sends detailed price quote via email.</div>
        </div>

        <div class="flex gap-6 pb-6 border-b border-stone-300">
          <div class="text-sm font-bold text-stone-600 flex-shrink-0 min-w-24">Days 4–7</div>
          <div class="text-xs text-stone-600"><strong>Approval & Payment:</strong> Review quote, approve design, and submit 50% deposit to begin production.</div>
        </div>

        <div class="flex gap-6 pb-6 border-b border-stone-300">
          <div class="text-sm font-bold text-stone-600 flex-shrink-0 min-w-24">Weeks 2–9</div>
          <div class="text-xs text-stone-600"><strong>Production:</strong> Your custom jacket is hand-crafted. You'll receive progress photos at the 50% mark.</div>
        </div>

        <div class="flex gap-6 pb-6 border-b border-stone-300">
          <div class="text-sm font-bold text-stone-600 flex-shrink-0 min-w-24">Week 10</div>
          <div class="text-xs text-stone-600"><strong>Quality Check & Finish:</strong> Final inspection, fitting photograph, and shipment preparation. Final payment due before shipping.</div>
        </div>

        <div class="flex gap-6">
          <div class="text-sm font-bold text-stone-600 flex-shrink-0 min-w-24">Week 11</div>
          <div class="text-xs text-stone-600"><strong>Shipping:</strong> Your jacket ships via insured carrier. Tracking provided. Arrives within 5–7 business days.</div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Load Custom Jacket Form Validations -->
@vite(['resources/js/custom-jacket-form.js'])
@endsection
