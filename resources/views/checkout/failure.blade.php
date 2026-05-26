@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-stone-50 flex items-center justify-center py-12 px-4">
  <div class="max-w-md w-full text-center">
    <!-- Error Icon -->
    <div class="mb-6">
      <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </div>
    </div>

    <!-- Error Message -->
    <h1 class="text-3xl font-bold text-stone-900 mb-2">Payment Failed</h1>
    <p class="text-stone-600 mb-6">Unfortunately, your payment could not be processed.</p>

    <!-- Error Details -->
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
      <p class="text-sm text-red-800">
        <strong>Error:</strong> {{ $error }}
      </p>
    </div>

    <!-- Troubleshooting Tips -->
    <div class="bg-stone-50 rounded-lg p-4 mb-6 text-left">
      <h3 class="font-semibold text-stone-900 mb-2">Troubleshooting Tips:</h3>
      <ul class="text-sm text-stone-700 space-y-2">
        <li>• Check that your card details are correct</li>
        <li>• Verify your billing address matches your card</li>
        <li>• Ensure sufficient funds are available</li>
        <li>• Try a different payment method if available</li>
        <li>• Contact your bank if the issue persists</li>
      </ul>
    </div>

    <!-- Support Information -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
      <p class="text-sm text-stone-700">
        <strong>Need help?</strong> Our support team is here to assist you. Contact us at
        <a href="mailto:support@toxawayknitting.com" class="text-blue-600 hover:text-blue-700">support@toxawayknitting.com</a>
        or call <a href="tel:+18284555555" class="text-blue-600 hover:text-blue-700">(828) 455-5555</a>.
      </p>
    </div>

    <!-- Action Buttons -->
    <div class="space-y-3">
      <a href="{{ route('checkout.payment') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
        Try Payment Again
      </a>
      <a href="{{ route('cart') }}" class="block w-full bg-stone-200 hover:bg-stone-300 text-stone-900 font-semibold py-3 rounded-lg transition">
        Review Cart
      </a>
      <a href="{{ route('shop') }}" class="block w-full text-center text-blue-600 hover:text-blue-700 font-semibold py-3 rounded-lg transition">
        Continue Shopping
      </a>
    </div>
  </div>
</div>
@endsection
