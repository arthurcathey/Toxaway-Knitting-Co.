@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-stone-50 py-12 px-4">
  <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-sm p-8">
    <h1 class="text-4xl font-bold text-stone-900 mb-8">Terms of Service</h1>
    
    <div class="prose prose-stone max-w-none space-y-6 text-stone-700">
      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">1. Agreement to Terms</h2>
        <p>
          By accessing and using the Toxaway Knitting Co. website and services, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">2. Use License</h2>
        <p>
          Permission is granted to temporarily download one copy of the materials (information or software) on Toxaway Knitting Co.'s website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
        </p>
        <ul class="list-disc list-inside space-y-2 ml-4">
          <li>Modifying or copying the materials</li>
          <li>Using the materials for any commercial purpose or for any public display</li>
          <li>Attempting to decompile or reverse engineer any software contained on the website</li>
          <li>Removing any copyright or other proprietary notations from the materials</li>
          <li>Transferring the materials to another person or "mirroring" the materials on any other server</li>
        </ul>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">3. Disclaimer</h2>
        <p>
          The materials on Toxaway Knitting Co.'s website are provided on an 'as is' basis. Toxaway Knitting Co. makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">4. Limitations</h2>
        <p>
          In no event shall Toxaway Knitting Co. or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on Toxaway Knitting Co.'s website, even if Toxaway Knitting Co. or an authorized representative has been notified orally or in writing of the possibility of such damage.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">5. Accuracy of Materials</h2>
        <p>
          The materials appearing on Toxaway Knitting Co.'s website could include technical, typographical, or photographic errors. Toxaway Knitting Co. does not warrant that any of the materials on its website are accurate, complete, or current. Toxaway Knitting Co. may make changes to the materials contained on its website at any time without notice.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">6. Materials and Links</h2>
        <p>
          Toxaway Knitting Co. has not reviewed all of the sites linked to its website and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by Toxaway Knitting Co. of the site. Use of any such linked website is at the user's own risk.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">7. Modifications</h2>
        <p>
          Toxaway Knitting Co. may revise these terms of service for its website at any time without notice. By using this website, you are agreeing to be bound by the then current version of these terms of service.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">8. Governing Law</h2>
        <p>
          These terms and conditions are governed by and construed in accordance with the laws of the United States, and you irrevocably submit to the exclusive jurisdiction of the courts in that location.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-stone-900 mt-8 mb-4">9. Contact Information</h2>
        <p>
          If you have any questions about these Terms of Service, please <a href="{{ route('contact') }}" class="text-blue-600 hover:underline">contact us</a>.
        </p>
      </section>
    </div>

    <div class="mt-12 pt-8 border-t border-stone-200">
      <p class="text-stone-600 text-sm">Last updated: {{ date('F d, Y') }}</p>
    </div>
  </div>
</div>
@endsection
