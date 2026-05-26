@extends('layouts.app')

@section('content')
<main class="container-fluid section-py px-6 py-16">
  <div class="max-w-2xl mx-auto">
    <h1 class="text-4xl font-bold mb-12">Edit Product</h1>

    @if ($errors->any())
    <div class="mb-12 rounded-lg bg-red-50 p-4 text-red-600">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="card">
      <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-6">
          <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
          <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none @error('name') border-red-500 @enderror">
          @error('name')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-6">
          <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">URL Slug *</label>
          <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" required
            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none @error('slug') border-red-500 @enderror">
          @error('slug')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div>
            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price ($) *</label>
            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none @error('price') border-red-500 @enderror">
            @error('price')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
            <input type="text" id="category" name="category" value="{{ old('category', $product->category) }}" required
              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none @error('category') border-red-500 @enderror">
            @error('category')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="mb-6">
          <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
          <textarea id="description" name="description" rows="5" required
            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
          @error('description')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-6">
          <label class="block text-sm font-semibold text-gray-700 mb-3">Available Sizes</label>
          <div class="space-y-2">
            @foreach(['sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large', 'xl' => 'Extra Large', 'xxl' => 'Extra Extra Large'] as $size => $label)
            <div class="flex items-center">
              <input type="checkbox" id="size_{{ $size }}" name="sizes[]" value="{{ $size }}"
                {{ in_array($size, old('sizes', $product->sizes ?? [])) ? 'checked' : '' }}
                class="h-4 w-4 rounded border-gray-300">
              <label for="size_{{ $size }}" class="ml-2 text-sm text-gray-700">{{ $label }}</label>
            </div>
            @endforeach
          </div>
          @error('sizes')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-6">
          <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Product Image</label>
          @if ($product->image)
          <div class="mb-4">
            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-lg border border-gray-300" loading="lazy" decoding="async">
          </div>
          @endif
          <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none @error('image') border-red-500 @enderror">
          <p class="mt-1 text-sm text-gray-500">Supported formats: JPEG, PNG, GIF, WebP (Max 2MB). Leave empty to keep current image.</p>
          @error('image')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-6 flex items-center">
          <input type="checkbox" id="in_stock" name="in_stock" value="1" {{ old('in_stock', $product->in_stock) ? 'checked' : '' }}
            class="h-4 w-4 rounded border-gray-300">
          <label for="in_stock" class="ml-2 text-sm text-gray-700">In Stock</label>
        </div>

        <div class="space-y-2">
          <button type="submit" class="btn-primary w-full">
            Save Changes
          </button>
          <a href="{{ route('admin.products.index') }}" class="btn-secondary block text-center">
            Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
</main>
@endsection
