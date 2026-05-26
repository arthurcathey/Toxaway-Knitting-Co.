@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-stone-50 py-12 px-4">
  <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-sm p-8">
    <h1 class="text-4xl font-bold text-stone-900 mb-8">Shipping Information</h1>

    <div class="space-y-8">
      <section>
        <h2 class="text-2xl font-bold text-stone-900 mb-4">Shipping Methods</h2>
        <div class="space-y-4">
          <div class="border border-stone-200 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-stone-900 mb-2">Standard Shipping</h3>
            <p class="text-stone-700">5-7 business days</p>
            <p class="text-stone-600 text-sm">Free on orders over $100</p>
          </div>
          <div class="border border-stone-200 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-stone-900 mb-2">Express Shipping</h3>
            <p class="text-stone-700">2-3 business days</p>
            <p class="text-stone-600 text-sm">$15.00</p>
          </div>
          <div class="border border-stone-200 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-stone-900 mb-2">Overnight Shipping</h3>
            <p class="text-stone-700">1 business day</p>
            <p class="text-stone-600 text-sm">$35.00</p>
          </div>
        </div>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mb-4">Processing Time</h2>
        <p class="text-stone-700 mb-3">
          All orders are carefully hand-packed to ensure quality. Standard processing time is 2-3 business days before your order ships. During peak seasons or for custom orders, processing may take longer.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mb-4">Domestic Shipping (US)</h2>
        <p class="text-stone-700 mb-3">
          We ship to all 50 states using USPS, UPS, or FedEx. Orders typically arrive within the timeframe specified for your chosen shipping method. Tracking information will be provided via email once your order ships.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mb-4">International Shipping</h2>
        <p class="text-stone-700 mb-3">
          We currently offer international shipping to select countries. International orders may be subject to customs duties and taxes. Shipping times vary by destination, typically 10-21 business days.
        </p>
        <p class="text-stone-700">
          Please <a href="{{ route('contact') }}" class="text-blue-600 hover:underline">contact us</a> for international shipping quotes.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mb-4">Tracking Your Order</h2>
        <p class="text-stone-700 mb-3">
          Once your order ships, you will receive a tracking number via email. You can use this number to track your package with the carrier's website.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mb-4">Damaged or Lost Packages</h2>
        <p class="text-stone-700 mb-3">
          All packages are insured. If your package arrives damaged or is lost, please contact us within 48 hours of delivery with photos of the damage. We will work with the carrier to resolve the issue and send you a replacement or refund.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mb-4">Returns and Exchanges</h2>
        <p class="text-stone-700 mb-3">
          We offer a 30-day return policy on all products. Items must be unworn, unwashed, and in original condition with tags attached. Return shipping is free with a prepaid label. We'll process refunds within 5-10 business days of receiving your return.
        </p>
      </section>

      <section class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h2 class="text-lg font-semibold text-stone-900 mb-3">Questions?</h2>
        <p class="text-stone-700 mb-4">
          If you have any questions about shipping or your order, we're here to help.
        </p>
        <a href="{{ route('contact') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
          Contact Support
        </a>
      </section>
    </div>

    <div class="mt-12 pt-8 border-t border-stone-200">
      <p class="text-stone-600 text-sm">Last updated: {{ date('F d, Y') }}</p>
    </div>
  </div>
</div>
@endsection
