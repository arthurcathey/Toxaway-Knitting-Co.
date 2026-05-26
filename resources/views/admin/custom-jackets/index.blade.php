@extends('layouts.app')

@section('title', 'Custom Jacket Requests - Admin')

@section('content')
<main class="container-fluid section-py px-6 py-16">
  <div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-4xl font-bold mb-2">Custom Jacket Requests</h1>
      <p class="text-stone-600">Manage and quote custom varsity jacket orders</p>
    </div>

    <!-- Success Message -->
    @if (session('success'))
    <div class="mb-8 p-4 bg-blue-50 border border-blue-300 text-blue-700 rounded-lg">
      {{ session('success') }}
    </div>
    @endif

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
      <a href="{{ route('admin.custom-jackets.index') }}" class="card {{ $currentStatus === '' ? 'ring-2 ring-stone-900' : '' }} hover:ring-2 hover:ring-stone-900 transition cursor-pointer">
        <div class="text-2xl font-bold text-stone-900">{{ $stats['total'] }}</div>
        <div class="text-xs font-semibold text-stone-600 uppercase tracking-wider">Total</div>
      </a>

      <a href="{{ route('admin.custom-jackets.index', ['status' => 'pending']) }}" class="card {{ $currentStatus === 'pending' ? 'ring-2 ring-yellow-500' : '' }} hover:ring-2 hover:ring-yellow-500 transition cursor-pointer">
        <div class="text-2xl font-bold text-yellow-700">{{ $stats['pending'] }}</div>
        <div class="text-xs font-semibold text-yellow-600 uppercase tracking-wider">Pending</div>
      </a>

      <a href="{{ route('admin.custom-jackets.index', ['status' => 'quoted']) }}" class="card {{ $currentStatus === 'quoted' ? 'ring-2 ring-blue-500' : '' }} hover:ring-2 hover:ring-blue-500 transition cursor-pointer">
        <div class="text-2xl font-bold text-blue-700">{{ $stats['quoted'] }}</div>
        <div class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Quoted</div>
      </a>

      <a href="{{ route('admin.custom-jackets.index', ['status' => 'approved']) }}" class="card {{ $currentStatus === 'approved' ? 'ring-2 ring-purple-500' : '' }} hover:ring-2 hover:ring-purple-500 transition cursor-pointer">
        <div class="text-2xl font-bold text-purple-700">{{ $stats['approved'] }}</div>
        <div class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Approved</div>
      </a>

      <a href="{{ route('admin.custom-jackets.index', ['status' => 'in_production']) }}" class="card {{ $currentStatus === 'in_production' ? 'ring-2 ring-indigo-500' : '' }} hover:ring-2 hover:ring-indigo-500 transition cursor-pointer">
        <div class="text-2xl font-bold text-indigo-700">{{ $stats['in_production'] }}</div>
        <div class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Prod</div>
      </a>

      <a href="{{ route('admin.custom-jackets.index', ['status' => 'completed']) }}" class="card {{ $currentStatus === 'completed' ? 'ring-2 ring-blue-500' : '' }} hover:ring-2 hover:ring-blue-500 transition cursor-pointer">
        <div class="text-2xl font-bold text-blue-700">{{ $stats['completed'] }}</div>
        <div class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Done</div>
      </a>

      <a href="{{ route('admin.custom-jackets.index', ['status' => 'cancelled']) }}" class="card {{ $currentStatus === 'cancelled' ? 'ring-2 ring-red-500' : '' }} hover:ring-2 hover:ring-red-500 transition cursor-pointer">
        <div class="text-2xl font-bold text-red-700">{{ $stats['cancelled'] }}</div>
        <div class="text-xs font-semibold text-red-600 uppercase tracking-wider">Cancel</div>
      </a>
    </div>

    <!-- Filters & Search -->
    <div class="card mb-8">
      <form method="GET" action="{{ route('admin.custom-jackets.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Search -->
          <div>
            <label for="search" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Search by Name/Email</label>
            <input type="text" id="search" name="search" value="{{ $searchTerm }}" placeholder="John Doe, john@example.com"
              class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900">
          </div>

          <!-- Sort -->
          <div>
            <label for="sort" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Sort By</label>
            <select id="sort" name="sort" class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900">
              <option value="created_at" @selected($sortBy==='created_at' )>Newest First</option>
              <option value="created_at" @selected($sortBy==='created_at' && $sortOrder==='asc' )>Oldest First</option>
              <option value="full_name" @selected($sortBy==='full_name' )>Name A-Z</option>
              <option value="status" @selected($sortBy==='status' )>Status</option>
            </select>
          </div>

          <!-- Actions -->
          <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 px-4 py-2 bg-stone-900 text-stone-50 text-xs font-bold tracking-widest uppercase hover:bg-stone-800 transition">
              Filter
            </button>
            <a href="{{ route('admin.custom-jackets.index') }}" class="flex-1 px-4 py-2 border-2 border-stone-900 text-stone-900 text-xs font-bold tracking-widest uppercase hover:bg-stone-50 transition text-center">
              Reset
            </a>
          </div>
        </div>
      </form>
    </div>

    <!-- Requests Table -->
    @if ($requests->count() > 0)
    <div class="card overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b-2 border-stone-300">
            <th class="text-left py-3 px-4 font-bold text-xs uppercase tracking-widest text-stone-600">Name</th>
            <th class="text-left py-3 px-4 font-bold text-xs uppercase tracking-widest text-stone-600">Email</th>
            <th class="text-left py-3 px-4 font-bold text-xs uppercase tracking-widest text-stone-600">Style</th>
            <th class="text-center py-3 px-4 font-bold text-xs uppercase tracking-widest text-stone-600">Status</th>
            <th class="text-right py-3 px-4 font-bold text-xs uppercase tracking-widest text-stone-600">Price</th>
            <th class="text-center py-3 px-4 font-bold text-xs uppercase tracking-widest text-stone-600">Date</th>
            <th class="text-center py-3 px-4 font-bold text-xs uppercase tracking-widest text-stone-600">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($requests as $request)
          <tr class="border-b border-stone-200 hover:bg-stone-50 transition">
            <td class="py-3 px-4">
              <div class="font-semibold text-stone-900">{{ $request->full_name }}</div>
            </td>
            <td class="py-3 px-4">
              <a href="mailto:{{ $request->email }}" class="text-blue-600 hover:underline">{{ $request->email }}</a>
            </td>
            <td class="py-3 px-4 text-xs text-stone-600">
              {{ $request->base_style }}<br>
              <span class="text-xs">{{ $request->primary_color }} / {{ $request->secondary_color }}</span>
            </td>
            <td class="py-3 px-4 text-center">
              <span class="px-2 py-1 text-xs font-semibold rounded {{ \App\Http\Controllers\Admin\CustomJacketAdminController::getStatusBadgeClass($request->status) }}">
                {{ \App\Http\Controllers\Admin\CustomJacketAdminController::getStatusLabel($request->status) }}
              </span>
            </td>
            <td class="py-3 px-4 text-right">
              @if ($request->quoted_price)
              <span class="font-semibold text-stone-900">${{ number_format($request->quoted_price, 2) }}</span>
              @else
              <span class="text-xs text-stone-400">—</span>
              @endif
            </td>
            <td class="py-3 px-4 text-center text-xs text-stone-600">
              {{ $request->created_at->format('M d, Y') }}
            </td>
            <td class="py-3 px-4 text-center">
              <a href="{{ route('admin.custom-jackets.show', $request) }}" class="text-blue-600 hover:underline font-semibold text-xs">
                View
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="mt-6 px-4">
        {{ $requests->links() }}
      </div>
    </div>
    @else
    <div class="card text-center py-12">
      <p class="text-stone-600 mb-4">No custom jacket requests found.</p>
      @if ($currentStatus !== '')
      <p class="text-sm text-stone-500">Try clearing the status filter or searching with different criteria.</p>
      @endif
    </div>
    @endif
  </div>
</main>
@endsection
