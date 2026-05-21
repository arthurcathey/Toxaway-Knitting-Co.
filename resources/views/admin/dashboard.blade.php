@extends('layouts.app')

@section('content')
<main class="container-fluid section-py px-6 py-16">
  <div class="max-w-6xl mx-auto">
    <div class="mb-12">
      <h1 class="text-4xl font-bold mb-2">Admin Dashboard</h1>
      <p class="text-stone-600">Manage your Toxaway store and orders</p>
    </div>

    @if (session('success'))
    <div class="mb-12 rounded-lg bg-green-50 p-4 text-green-600">
      {{ session('success') }}
    </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
      <div class="card">
        <div class="text-sm text-stone-600 mb-1">Total Products</div>
        <div class="text-3xl font-bold text-stone-900">{{ $totalProducts }}</div>
      </div>
      <div class="card">
        <div class="text-sm text-stone-600 mb-1">In Stock</div>
        <div class="text-3xl font-bold text-green-600">{{ $inStockProducts }}</div>
      </div>
      <div class="card">
        <div class="text-sm text-stone-600 mb-1">Total Users</div>
        <div class="text-3xl font-bold text-stone-900">{{ $totalUsers }}</div>
      </div>
      <div class="card">
        <div class="text-sm text-stone-600 mb-1">Total Registered</div>
        <div class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</div>
      </div>
    </div>

    <!-- Custom Jacket Stats -->
    <div class="mb-12">
      <h2 class="text-2xl font-bold mb-6">Custom Jacket Orders</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('admin.custom-jackets.index') }}" class="card hover:ring-2 hover:ring-stone-900 transition cursor-pointer">
          <div class="text-sm text-stone-600 mb-1">Total Requests</div>
          <div class="text-3xl font-bold text-stone-900">{{ $totalRequests }}</div>
        </a>
        <a href="{{ route('admin.custom-jackets.index', ['status' => 'pending']) }}" class="card hover:ring-2 hover:ring-yellow-500 transition cursor-pointer">
          <div class="text-sm text-yellow-600 mb-1">Pending</div>
          <div class="text-3xl font-bold text-yellow-700">{{ $pendingRequests }}</div>
        </a>
        <a href="{{ route('admin.custom-jackets.index', ['status' => 'quoted']) }}" class="card hover:ring-2 hover:ring-blue-500 transition cursor-pointer">
          <div class="text-sm text-blue-600 mb-1">Quoted</div>
          <div class="text-3xl font-bold text-blue-700">{{ $quotedRequests }}</div>
        </a>
        <a href="{{ route('admin.custom-jackets.index', ['status' => 'completed']) }}" class="card hover:ring-2 hover:ring-green-500 transition cursor-pointer">
          <div class="text-sm text-green-600 mb-1">Completed</div>
          <div class="text-3xl font-bold text-green-700">{{ $completedRequests }}</div>
        </a>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
      <h2 class="text-xl font-bold mb-6">Quick Actions</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <a href="{{ route('admin.products.index') }}" class="btn-primary block text-center">
          Manage Products
        </a>
        <a href="{{ route('admin.products.create') }}" class="btn-secondary block text-center">
          Add New Product
        </a>
        <a href="{{ route('admin.custom-jackets.index') }}" class="btn-primary block text-center">
          View Jacket Requests
        </a>
        <a href="{{ route('admin.custom-jackets.index', ['status' => 'pending']) }}" class="btn-secondary block text-center">
          @if ($pendingRequests > 0)
          Pending Requests ({{ $pendingRequests }})
          @else
          View All Requests
          @endif
        </a>
      </div>
    </div>
  </div>
</main>
@endsection
