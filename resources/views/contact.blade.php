@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<main>
  <!-- Page Header -->
  <section class="section-py border-b border-stone-300 container-fluid">
    <h1 class="mb-3 sm:mb-4">GET IN TOUCH</h1>
    <p class="text-stone-600 tracking-wide text-xs sm:text-sm">We'd love to hear from you. Reach out anytime.</p>
  </section>

  <!-- Contact Info & Form -->
  <section class="section-py container-fluid">
    <div class="grid-2col gap-8 sm:gap-12 md:gap-16">
      <!-- Info -->
      <div>
        <h2 class="mb-6 sm:mb-8">CONTACT INFORMATION</h2>

        <div class="space-y-6 sm:space-y-8">
          <!-- Email -->
          <div>
            <h3 class="text-stone-600 mb-2 text-xs sm:text-sm">EMAIL</h3>
            <a href="mailto:hello@toxaway.test" class="text-sm font-mono hover:underline">hello@toxaway.test</a>
            <p class="text-xs text-stone-600 mt-2">Response time: within 24 hours</p>
          </div>

          <!-- Phone -->
          <div>
            <h3 class="text-stone-600 mb-2 text-xs sm:text-sm">PHONE</h3>
            <a href="tel:+18285550123" class="text-sm font-mono hover:underline">(828) 555-0123</a>
            <p class="text-xs text-stone-600 mt-2">Monday – Friday, 9am – 5pm EST</p>
          </div>

          <!-- Address -->
          <div>
            <h3 class="text-stone-600 mb-2 text-xs sm:text-sm">MAILING ADDRESS</h3>
            <p class="text-xs text-stone-700">
              Toxaway Knitting Company<br>
              123 Craft Lane<br>
              Brevard, NC 28712<br>
              USA
            </p>
          </div>

          <!-- Hours -->
          <div>
            <h3 class="text-stone-600 mb-2 text-xs sm:text-sm">BUSINESS HOURS</h3>
            <ul class="text-xs text-stone-700 space-y-1">
              <li>Monday – Friday: 9:00 AM – 5:00 PM EST</li>
              <li>Saturday: 10:00 AM – 2:00 PM EST</li>
              <li>Sunday: Closed</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div>
        <h2 class="mb-6 sm:mb-8">SEND US A MESSAGE</h2>

        <form action="/contact" method="POST" class="space-y-6">
          @csrf

          <!-- Name -->
          <div>
            <label for="name" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Name</label>
            <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900" placeholder="Your name">
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Email</label>
            <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900" placeholder="your@email.com">
          </div>

          <!-- Phone -->
          <div>
            <label for="phone" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Phone (Optional)</label>
            <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900" placeholder="(555) 123-4567">
          </div>

          <!-- Subject -->
          <div>
            <label for="subject" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Subject</label>
            <select id="subject" name="subject" required class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900">
              <option value="">Select a subject...</option>
              <option value="order">Order Question</option>
              <option value="custom">Custom Jacket Inquiry</option>
              <option value="sizing">Sizing Help</option>
              <option value="returns">Returns & Exchanges</option>
              <option value="wholesale">Wholesale Inquiry</option>
              <option value="other">Other</option>
            </select>
          </div>

          <!-- Message -->
          <div>
            <label for="message" class="block text-xs font-bold tracking-widest uppercase text-stone-600 mb-2">Message</label>
            <textarea id="message" name="message" rows="6" required class="w-full px-4 py-2 border border-stone-300 text-xs focus:outline-none focus:border-stone-900" placeholder="Your message..."></textarea>
          </div>

          <!-- Submit -->
          <button type="submit" class="w-full px-4 py-3 bg-stone-900 text-stone-50 text-xs font-bold tracking-widest hover:bg-stone-800 transition">SEND MESSAGE</button>
        </form>

        @if ($errors->any())
        <div class="mt-4 p-4 bg-red-100 border border-red-300 text-red-700 text-xs">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="mt-4 p-4 bg-blue-100 border border-blue-300 text-blue-700 text-xs">
          {{ session('success') }}
        </div>
        @endif
      </div>
  </section>

  <!-- FAQ Section -->
  <section class="py-16 bg-stone-100 px-6 rounded my-16">
    <h2 class="text-2xl font-bold tracking-wider mb-12">FREQUENTLY ASKED QUESTIONS</h2>

    <div class="space-y-8">
      <div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-2">What's your return policy?</h3>
        <p class="text-xs text-stone-600">We offer 30-day returns on all products. Items must be unworn and in original packaging.</p>
      </div>

      <div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-2">How long does shipping take?</h3>
        <p class="text-xs text-stone-600">Standard shipping is 5-7 business days within the US. Express shipping available for an additional fee.</p>
      </div>

      <div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-2">How do I care for my sweater?</h3>
        <p class="text-xs text-stone-600">Hand wash in cool water with gentle detergent. Lay flat to dry. We recommend washing sparingly to preserve the fiber integrity.</p>
      </div>

      <div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-2">Do you offer custom orders?</h3>
        <p class="text-xs text-stone-600">Yes! Check out our custom varsity jacket builder, or contact us for other custom requests.</p>
      </div>

      <div>
        <h3 class="text-sm font-bold tracking-widest uppercase mb-2">What payment methods do you accept?</h3>
        <p class="text-xs text-stone-600">We accept all major credit cards, PayPal, and digital wallets (Apple Pay, Google Pay).</p>
      </div>
    </div>
  </section>
</main>
@endsection
