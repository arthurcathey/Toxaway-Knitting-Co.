@extends('layouts.app')

@section('content')
<main class="container-fluid section-py">
  <div class="mx-auto max-w-md">
    <div class="card">
      <h1 class="mb-6 text-center text-2xl font-bold">Create Account</h1>

      @if ($errors->any())
      <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-600">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" required
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
          @error('name')
          <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
          @error('email')
          <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" id="password" name="password" required
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
          @error('password')
          <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-6">
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
          @error('password_confirmation')
          <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>

        <button type="submit" class="btn-primary w-full">
          Create Account
        </button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600">
        Already have an account?
        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">Login</a>
      </p>
    </div>
  </div>
</main>
@endsection
