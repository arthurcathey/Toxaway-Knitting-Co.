@extends('layouts.app')

@section('title', 'Custom Jacket Request - Admin')

@section('content')
<main class="container-fluid section-py px-6 py-16">
  <div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
      <a href="{{ route('admin.custom-jackets.index') }}" class="text-blue-600 hover:underline text-sm font-semibold mb-4 inline-block">← Back to Requests</a>
      <h1 class="text-4xl font-bold mb-2">Custom Jacket Request #{{ $request->id }}</h1>
      <div class="flex items-center gap-4 flex-wrap">
        <span class="px-3 py-1 text-sm font-semibold rounded {{ \App\Http\Controllers\Admin\CustomJacketAdminController::getStatusBadgeClass($request->status) }}">
          {{ \App\Http\Controllers\Admin\CustomJacketAdminController::getStatusLabel($request->status) }}
        </span>
        <span class="text-sm text-stone-600">Submitted {{ $request->created_at->diffForHumans() }}</span>
      </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
    <div class="mb-8 p-4 bg-blue-50 border border-blue-300 text-blue-700 rounded-lg">
      {{ session('success') }}
    </div>
    @endif

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Left Column: Request Details -->
      <div class="lg:col-span-2 space-y-8">
        <!-- Customer Information -->
        <div class="card">
          <h2 class="text-xl font-bold mb-6 pb-4 border-b-2 border-stone-200">Customer Information</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Full Name</label>
              <p class="text-lg font-semibold text-stone-900">{{ $request->full_name }}</p>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Email</label>
              <p class="text-lg">
                <a href="mailto:{{ $request->email }}" class="text-blue-600 hover:underline font-semibold">{{ $request->email }}</a>
              </p>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Phone</label>
              <p class="text-lg font-semibold text-stone-900">{{ $request->phone }}</p>
            </div>
            @if ($request->user_id)
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Account</label>
              <p class="text-lg font-semibold text-stone-900">Registered User (ID: {{ $request->user_id }})</p>
            </div>
            @endif
          </div>
        </div>

        <!-- Design Specifications -->
        <div class="card">
          <h2 class="text-xl font-bold mb-6 pb-4 border-b-2 border-stone-200">Design Specifications</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Base Style</label>
              <p class="text-lg font-semibold text-stone-900">{{ $request->base_style }}</p>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Material</label>
              <p class="text-lg font-semibold text-stone-900">{{ $request->material }}</p>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Primary Color (Body)</label>
              <div class="flex items-center gap-3">
                @php
                $colorClasses = match($request->primary_color) {
                'Black' => 'bg-black',
                'Navy Blue' => 'bg-blue-900',
                'Slate Blue' => 'bg-blue-700',
                'Burgundy' => 'bg-red-900',
                'Cream' => 'bg-yellow-50',
                'Charcoal Gray' => 'bg-gray-700',
                default => 'bg-gray-400',
                };
                @endphp
                <div class="w-8 h-8 rounded border-2 border-stone-300 {{ $colorClasses }}"></div>
                <p class="text-lg font-semibold text-stone-900">{{ $request->primary_color }}</p>
              </div>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Secondary Color (Sleeves)</label>
              <div class="flex items-center gap-3">
                @php
                $secondaryClasses = match($request->secondary_color) {
                'Black' => 'bg-black',
                'Navy Blue' => 'bg-blue-900',
                'Slate Blue' => 'bg-blue-700',
                'Burgundy' => 'bg-red-900',
                'Cream' => 'bg-yellow-50',
                'Charcoal Gray' => 'bg-gray-700',
                default => 'bg-gray-400',
                };
                @endphp
                <div class="w-8 h-8 rounded border-2 border-stone-300 {{ $secondaryClasses }}"></div>
                <p class="text-lg font-semibold text-stone-900">{{ $request->secondary_color }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Sizing -->
        <div class="card">
          <h2 class="text-xl font-bold mb-6 pb-4 border-b-2 border-stone-200">Sizing</h2>
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-3">Selected Sizes</label>
            @if ($request->sizes && count($request->sizes) > 0)
            <div class="flex flex-wrap gap-2">
              @foreach ($request->sizes as $size)
              <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded">
                {{ match($size) {
                  'sm' => 'Small',
                  'md' => 'Medium',
                  'lg' => 'Large',
                  'xl' => 'Extra Large',
                  'xxl' => 'Extra Extra Large',
                  default => $size
                } }}
              </span>
              @endforeach
            </div>
            @else
            <p class="text-stone-600 text-sm italic">No sizes specified</p>
            @endif
          </div>
        </div>

        <!-- Personalization -->
        <div class="card">
          <h2 class="text-xl font-bold mb-6 pb-4 border-b-2 border-stone-200">Personalization</h2>
          <div class="space-y-6">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Front Text</label>
              <p class="text-lg font-semibold text-stone-900">{{ $request->front_text }}</p>
            </div>
            @if ($request->custom_details)
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Custom Details</label>
              <p class="text-sm text-stone-700 whitespace-pre-wrap">{{ $request->custom_details }}</p>
            </div>
            @endif
            @if ($request->inspiration_image)
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Reference Image</label>
              <a href="{{ asset('storage/' . $request->inspiration_image) }}" target="_blank" class="inline-block">
                <img src="{{ asset('storage/' . $request->inspiration_image) }}" alt="Reference" class="max-w-xs rounded border border-stone-300 hover:border-stone-500">
              </a>
            </div>
            @endif
          </div>
        </div>

        <!-- Timeline -->
        @if ($request->quoted_at || $request->approved_at)
        <div class="card">
          <h2 class="text-xl font-bold mb-6 pb-4 border-b-2 border-stone-200">Timeline</h2>
          <div class="space-y-4">
            <div class="flex gap-4">
              <div class="text-center">
                <div class="w-3 h-3 bg-blue-500 rounded-full mx-auto mb-2"></div>
              </div>
              <div>
                <p class="text-xs font-bold uppercase tracking-wider text-stone-600">Submitted</p>
                <p class="text-sm text-stone-700">{{ $request->created_at->format('F j, Y \a\t g:i A') }}</p>
              </div>
            </div>
            @if ($request->quoted_at)
            <div class="flex gap-4">
              <div class="text-center">
                <div class="w-3 h-3 bg-blue-500 rounded-full mx-auto mb-2"></div>
              </div>
              <div>
                <p class="text-xs font-bold uppercase tracking-wider text-stone-600">Quoted</p>
                <p class="text-sm text-stone-700">{{ $request->quoted_at->format('F j, Y \a\t g:i A') }}</p>
              </div>
            </div>
            @endif
            @if ($request->approved_at)
            <div class="flex gap-4">
              <div class="text-center">
                <div class="w-3 h-3 bg-purple-500 rounded-full mx-auto mb-2"></div>
              </div>
              <div>
                <p class="text-xs font-bold uppercase tracking-wider text-stone-600">Approved</p>
                <p class="text-sm text-stone-700">{{ $request->approved_at->format('F j, Y \a\t g:i A') }}</p>
              </div>
            </div>
            @endif
          </div>
        </div>
        @endif
      </div>

      <!-- Right Column: Admin Actions -->
      <div class="space-y-6">
        <!-- Quote Form -->
        <div class="card">
          <h2 class="text-lg font-bold mb-4 pb-3 border-b-2 border-stone-200">Update Status</h2>
          <form action="{{ route('admin.custom-jackets.update', $request) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Status -->
            <div>
              <label for="status" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Status</label>
              <select id="status" name="status" required
                class="w-full px-3 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900">
                <option value="pending" @selected($request->status === 'pending')>Pending Review</option>
                <option value="quoted" @selected($request->status === 'quoted')>Quote Sent</option>
                <option value="approved" @selected($request->status === 'approved')>Approved</option>
                <option value="in_production" @selected($request->status === 'in_production')>In Production</option>
                <option value="completed" @selected($request->status === 'completed')>Completed</option>
                <option value="cancelled" @selected($request->status === 'cancelled')>Cancelled</option>
              </select>
            </div>

            <!-- Price -->
            <div>
              <label for="quoted_price" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Quote Price</label>
              <div class="flex items-center">
                <span class="text-lg font-semibold text-stone-600">$</span>
                <input type="number" id="quoted_price" name="quoted_price" step="0.01" min="0"
                  value="{{ $request->quoted_price }}" placeholder="0.00"
                  class="flex-1 px-3 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900 ml-1">
              </div>
            </div>

            <!-- Admin Notes -->
            <div>
              <label for="admin_notes" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Admin Notes</label>
              <textarea id="admin_notes" name="admin_notes" rows="4" placeholder="Add internal notes about this order..."
                class="w-full px-3 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900">{{ $request->admin_notes }}</textarea>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full px-4 py-2 bg-stone-900 text-stone-50 text-xs font-bold tracking-widest uppercase hover:bg-stone-800 transition">
              Update Request
            </button>
          </form>
        </div>

        <!-- Current Info -->
        <div class="card">
          <h2 class="text-lg font-bold mb-4 pb-3 border-b-2 border-stone-200">Current Info</h2>
          <div class="space-y-3 text-sm">
            @if ($request->quoted_price)
            <div>
              <p class="text-xs font-bold text-stone-600 uppercase tracking-wider mb-1">Quoted Price</p>
              <p class="text-lg font-bold text-blue-600">${{ number_format($request->quoted_price, 2) }}</p>
            </div>
            @endif
            @if ($request->quoted_at)
            <div>
              <p class="text-xs font-bold text-stone-600 uppercase tracking-wider mb-1">Quote Date</p>
              <p class="text-stone-700">{{ $request->quoted_at->format('M d, Y') }}</p>
            </div>
            @endif
            @if ($request->approved_at)
            <div>
              <p class="text-xs font-bold text-stone-600 uppercase tracking-wider mb-1">Approval Date</p>
              <p class="text-stone-700">{{ $request->approved_at->format('M d, Y') }}</p>
            </div>
            @endif
          </div>
        </div>

        <!-- Actions -->
        <div class="card">
          <h2 class="text-lg font-bold mb-4 pb-3 border-b-2 border-stone-200">Actions</h2>
          <div class="space-y-2">
            <a href="mailto:{{ $request->email }}?subject=Custom%20Jacket%20Quote%20-%20ID%20%23{{ $request->id }}"
              class="w-full px-4 py-2 bg-blue-600 text-white text-xs font-bold tracking-widest uppercase hover:bg-blue-700 transition text-center rounded inline-block">
              Email Customer
            </a>
            @if ($request->status !== 'cancelled')
            <form action="{{ route('admin.custom-jackets.cancel', $request) }}" method="POST" class="w-full" data-confirm-delete="Are you sure you want to cancel this request?">
              @csrf
              <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white text-xs font-bold tracking-widest uppercase hover:bg-red-700 transition">
                Cancel Request
              </button>
            </form>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
