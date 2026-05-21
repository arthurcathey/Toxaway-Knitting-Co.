@extends('layouts.app')

@section('content')
<main class="container-fluid section-py px-6 py-16">
  <div class="max-w-6xl mx-auto">
    <div class="mb-12">
      <h1 class="text-4xl font-bold mb-2">Admin Dashboard</h1>
      <p class="text-gray-600">Manage your Toxaway store</p>
    </div>

    @if (session('success'))
    <div class="mb-12 rounded-lg bg-green-50 p-4 text-green-600">
      {{ session('success') }}
    </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
      <div class="card">
        <div class="text-sm text-gray-600 mb-1">Total Products</div>
        <div class="text-3xl font-bold text-stone-900">{{ $totalProducts }}</div>
      </div>
      <div class="card">
        <div class="text-sm text-gray-600 mb-1">In Stock</div>
        <div class="text-3xl font-bold text-green-600">{{ $inStockProducts }}</div>
      </div>
      <div class="card">
        <div class="text-sm text-gray-600 mb-1">Total Users</div>
        <div class="text-3xl font-bold text-stone-900">{{ $totalUsers }}</div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
      <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
      <div class="space-y-2">
        <a href="{{ route('admin.products.index') }}" class="btn-primary block text-center">
          Manage Products
        </a>
        <a href="{{ route('admin.products.create') }}" class="btn-secondary block text-center">
          Add New Product
        </a>
      </div>
    </div>
  </div>
</main>
@endsection
