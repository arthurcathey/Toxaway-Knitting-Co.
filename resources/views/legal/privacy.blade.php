@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-stone-50 py-12 px-4">
  <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-sm p-8">
    <h1 class="text-4xl font-bold text-stone-900 mb-8">Privacy Policy</h1>

    <div class="prose prose-stone max-w-none space-y-6 text-stone-700">
      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">Introduction</h2>
        <p>
          Toxaway Knitting Co. ("we" or "us" or "our") respects the privacy of our users ("user" or "you"). This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">1. Information We Collect</h2>
        <p>We may collect information about you in a variety of ways. The information we may collect on the website includes:</p>

        <h3 class="text-xl font-semibold text-stone-800 mt-4 mb-2">Personal Data</h3>
        <p>Personally identifiable information, such as your name, shipping address, email address, and telephone number, that you voluntarily give to us when you register with the website or when you choose to participate in various activities related to the website.</p>

        <h3 class="text-xl font-semibold text-stone-800 mt-4 mb-2">Financial Data</h3>
        <p>Financial information, such as funds associated with your account or payment method that we use to process your transactions. We do not store your full credit card information on our servers.</p>

        <h3 class="text-xl font-semibold text-stone-800 mt-4 mb-2">Data From Cookies</h3>
        <p>Information collected from you automatically through our website, including your IP address, browser type, operating system, referring URLs, and pages visited.</p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">2. Use of Your Information</h2>
        <p>Having accurate information about you permits us to provide you with a smooth, efficient, and customized experience. Specifically, we may use information collected about you via the website to:</p>
        <ul class="list-disc list-inside space-y-2 ml-4">
          <li>Process your transactions and send related information</li>
          <li>Email you regarding your order status or customer service issues</li>
          <li>Fulfill and manage your orders</li>
          <li>Generate a personal profile about you so that we can better understand your needs</li>
          <li>Increase the efficiency and operation of the website</li>
          <li>Monitor and analyze usage and trends to improve your experience with the website</li>
        </ul>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">3. Disclosure of Your Information</h2>
        <p>
          We may share your information with third parties only in the ways that are described in this Privacy Policy. We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information unless we provide you with advance notice. This does not include website hosting partners and other parties who assist us in operating our website, conducting our business, or servicing you, provided that those parties agree to keep this information confidential.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">4. Security of Your Information</h2>
        <p>
          We use administrative, technical, and physical security measures to protect your personal information. However, no method of transmission over the Internet or electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your personal information, we cannot guarantee its absolute security.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">5. Contact Us</h2>
        <p>
          If you have questions or comments about this Privacy Policy, please <a href="{{ route('contact') }}" class="text-blue-600 hover:underline">contact us</a>.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">6. Changes to this Policy</h2>
        <p>
          Toxaway Knitting Co. reserves the right to modify this Privacy Policy at any time. Changes and clarifications will take effect immediately upon their posting to the website. If we make material changes to this policy, we will notify you here that it has been updated.
        </p>
      </section>
    </div>

    <div class="mt-12 pt-8 border-t border-stone-200">
      <p class="text-stone-600 text-sm">Last updated: {{ date('F d, Y') }}</p>
    </div>
  </div>
</div>
@endsection
