@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-stone-50">
  <div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-stone-900 mb-8">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Payment Form -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6">
          <form id="payment-form" class="space-y-6">
            @csrf

            <!-- Order Summary -->
            <div class="bg-stone-50 p-4 rounded-lg mb-6">
              <h2 class="text-lg font-semibold text-stone-900 mb-4">Order Summary</h2>
              <div class="space-y-2 mb-4">
                @foreach ($cartItems as $item)
                <div class="flex justify-between text-sm text-stone-700">
                  <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                  <span>${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                </div>
                @endforeach
              </div>
              <div class="border-t border-stone-200 pt-4 space-y-2">
                <div class="flex justify-between text-sm text-stone-700">
                  <span>Subtotal</span>
                  <span>${{ number_format($total - 15, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-stone-700">
                  <span>Shipping</span>
                  <span>$15.00</span>
                </div>
                <div class="flex justify-between font-semibold text-stone-900 pt-2 border-t border-stone-200">
                  <span>Total</span>
                  <span class="text-blue-600">${{ number_format($total, 2) }}</span>
                </div>
              </div>
            </div>

            <!-- Billing & Shipping Information -->
            <fieldset class="space-y-4">
              <legend class="text-lg font-semibold text-stone-900">Billing & Shipping Information</legend>

              <div>
                <label for="full_name" class="block text-sm font-medium text-stone-700 mb-1">Full Name *</label>
                <input type="text" id="full_name" name="full_name" required
                  class="w-full px-4 py-2 border border-stone-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="John Doe">
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Email *</label>
                  <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border border-stone-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="john@example.com">
                </div>
                <div>
                  <label for="phone" class="block text-sm font-medium text-stone-700 mb-1">Phone *</label>
                  <input type="tel" id="phone" name="phone" required
                    class="w-full px-4 py-2 border border-stone-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="(555) 123-4567">
                </div>
              </div>

              <div>
                <label for="address" class="block text-sm font-medium text-stone-700 mb-1">Address *</label>
                <input type="text" id="address" name="address" required
                  class="w-full px-4 py-2 border border-stone-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="123 Main Street">
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label for="city" class="block text-sm font-medium text-stone-700 mb-1">City *</label>
                  <input type="text" id="city" name="city" required
                    class="w-full px-4 py-2 border border-stone-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Asheville">
                </div>
                <div>
                  <label for="state" class="block text-sm font-medium text-stone-700 mb-1">State *</label>
                  <input type="text" id="state" name="state" required
                    class="w-full px-4 py-2 border border-stone-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="NC">
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label for="zip" class="block text-sm font-medium text-stone-700 mb-1">ZIP Code *</label>
                  <input type="text" id="zip" name="zip" required
                    class="w-full px-4 py-2 border border-stone-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="28801">
                </div>
                <div>
                  <label for="country" class="block text-sm font-medium text-stone-700 mb-1">Country *</label>
                  <input type="text" id="country" name="country" value="United States" required
                    class="w-full px-4 py-2 border border-stone-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
              </div>
            </fieldset>

            <!-- Payment Information -->
            <fieldset class="space-y-4">
              <legend class="text-lg font-semibold text-stone-900">Payment Information</legend>

              <div>
                <label for="card-element" class="block text-sm font-medium text-stone-700 mb-1">Card Details *</label>
                <div id="card-element" class="px-4 py-2 border border-stone-300 rounded-lg bg-white"></div>
                <div id="card-errors" class="text-red-600 text-sm mt-2"></div>
              </div>
            </fieldset>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
              <span id="button-text">Pay ${{ number_format($total, 2) }}</span>
              <div id="spinner" class="hidden spinner"></div>
            </button>

            <p class="text-xs text-stone-500 text-center">
              Your payment is secure and encrypted. We never store your card information.
            </p>
          </form>
        </div>
      </div>

      <!-- Order Details Sidebar -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
          <h2 class="text-lg font-semibold text-stone-900 mb-4">Order Details</h2>

          <div class="space-y-4">
            <div class="text-sm text-stone-600">
              <p class="font-medium text-stone-900 mb-2">Items</p>
              @foreach ($cartItems as $item)
              <div class="flex justify-between py-1">
                <span>{{ substr($item->product->name, 0, 20) }}...</span>
                <span>{{ $item->quantity }}</span>
              </div>
              @endforeach
            </div>

            <div class="border-t border-stone-200 pt-4 text-sm text-stone-600">
              <p class="font-medium text-stone-900 mb-2">Support</p>
              <p>Have questions? Contact us at:</p>
              <p class="text-blue-600 hover:text-blue-700"><a href="mailto:support@toxawayknitting.com">support@toxawayknitting.com</a></p>
              <p class="text-blue-600 hover:text-blue-700"><a href="tel:+18284555555">(828) 455-5555</a></p>
            </div>

            <div class="border-t border-stone-200 pt-4">
              <a href="{{ route('cart') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">← Return to cart</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>

<script>
  const stripe = Stripe('{{ $stripe_public_key }}');
  const elements = stripe.elements();
  const cardElement = elements.create('card');

  cardElement.mount('#card-element');

  // Handle card errors
  cardElement.addEventListener('change', (event) => {
    const displayError = document.getElementById('card-errors');
    if (event.error) {
      displayError.textContent = event.error.message;
    } else {
      displayError.textContent = '';
    }
  });

  // Handle form submission
  const form = document.getElementById('payment-form');
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const submitButton = form.querySelector('button[type="submit"]');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');

    submitButton.disabled = true;
    spinner.classList.remove('hidden');
    buttonText.textContent = 'Processing...';

    // Create payment method
    const {
      paymentMethod
    } = await stripe.createPaymentMethod({
      type: 'card',
      card: cardElement,
      billing_details: {
        name: document.getElementById('full_name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        address: {
          line1: document.getElementById('address').value,
          city: document.getElementById('city').value,
          state: document.getElementById('state').value,
          postal_code: document.getElementById('zip').value,
          country: 'US',
        },
      },
    });

    if (paymentMethod.error) {
      document.getElementById('card-errors').textContent = paymentMethod.error.message;
      submitButton.disabled = false;
      spinner.classList.add('hidden');
      buttonText.textContent = 'Pay ${{ number_format($total, 2) }}';
      return;
    }

    // Submit payment to backend
    const response = await fetch('{{ route("payment.process") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: JSON.stringify({
        full_name: document.getElementById('full_name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        address: document.getElementById('address').value,
        city: document.getElementById('city').value,
        state: document.getElementById('state').value,
        zip: document.getElementById('zip').value,
        country: document.getElementById('country').value,
        payment_method_id: paymentMethod.paymentMethod.id,
      }),
    });

    const result = await response.json();

    spinner.classList.add('hidden');

    if (result.success) {
      // Redirect to success page
      window.location.href = `{{ route('checkout.success') }}?order_id=${result.order_id}`;
    } else {
      document.getElementById('card-errors').textContent = result.error || 'Payment failed. Please try again.';
      submitButton.disabled = false;
      buttonText.textContent = 'Pay ${{ number_format($total, 2) }}';
    }
  });
</script>

<style>
  .spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
</style>
@endsection
