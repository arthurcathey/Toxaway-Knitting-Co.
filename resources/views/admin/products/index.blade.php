@extends('layouts.app')

@section('content')
<main class="container-fluid section-py px-6 py-16">
  <div class="max-w-6xl mx-auto">
    <div class="mb-12 flex justify-between items-center">
      <div>
        <h1 class="text-4xl font-bold mb-2">Products</h1>
        <p class="text-gray-600">Manage your product inventory</p>
      </div>
      <a href="{{ route('admin.products.create') }}" class="btn-primary">
        Add New Product
      </a>
    </div>

    @if (session('success'))
    <div class="mb-12 rounded-lg bg-green-50 p-4 text-green-600">
      {{ session('success') }}
    </div>
    @endif

    @if ($products->count() > 0)
    <div class="card overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="border-b border-gray-200">
          <tr>
            <th class="text-left px-4 py-3 font-semibold">Name</th>
            <th class="text-left px-4 py-3 font-semibold">Category</th>
            <th class="text-left px-4 py-3 font-semibold">Price</th>
            <th class="text-left px-4 py-3 font-semibold">Stock</th>
            <th class="text-left px-4 py-3 font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($products as $product)
          <tr class="border-b border-gray-100 hover:bg-gray-50">
            <td class="px-4 py-3">
              <a href="{{ route('product.show', $product) }}" class="text-blue-600 hover:text-blue-700">
                {{ $product->name }}
              </a>
            </td>
            <td class="px-4 py-3 text-gray-600">{{ $product->category }}</td>
            <td class="px-4 py-3 font-semibold">${{ number_format($product->price, 2) }}</td>
            <td class="px-4 py-3">
              <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $product->in_stock ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $product->in_stock ? 'In Stock' : 'Out of Stock' }}
              </span>
            </td>
            <td class="px-4 py-3 space-x-2">
              <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                Edit
              </a>
              <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-700 font-semibold text-sm">
                  Delete
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @else
    <div class="card text-center py-12">
      <p class="text-gray-600 mb-4">No products yet</p>
      <a href="{{ route('admin.products.create') }}" class="btn-primary">
        Create Your First Product
      </a>
    </div>
    @endif
  </div>
</main>
@endsection
