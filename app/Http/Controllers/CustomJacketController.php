<?php

namespace App\Http\Controllers;

use App\Models\CustomJacketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\CustomJacketQuoteRequested;
use App\Mail\CustomJacketConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomJacketController extends Controller
{
  /**
   * Show the custom jacket builder form.
   */
  public function show()
  {
    return view('custom-jacket.builder');
  }

  /**
   * Store a new custom jacket request.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'full_name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'phone' => 'required|string|max:20',
      'base_style' => 'required|string|in:Classic Varsity Cut,Oversized Fit,Fitted Silhouette,Cropped Length',
      'primary_color' => 'required|string|in:Black,Navy Blue,Forest Green,Burgundy,Cream,Charcoal Gray',
      'secondary_color' => 'required|string|in:Black,Navy Blue,Forest Green,Burgundy,Cream,Charcoal Gray',
      'material' => 'required|string|in:Wool (100%),Wool Blend (80/20),Linen Blend,Leather Sleeves',
      'sizes' => 'nullable|array',
      'sizes.*' => 'in:sm,md,lg,xl,xxl',
      'front_text' => 'required|string|max:255',
      'custom_details' => 'nullable|string|max:2000',
      'inspiration_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
    ]);

    $validated['front_text'] = strip_tags($validated['front_text']);
    $validated['custom_details'] = strip_tags($validated['custom_details'] ?? '');
    $validated['sizes'] = !empty($validated['sizes']) ? $validated['sizes'] : null;

    if ($request->hasFile('inspiration_image')) {
      $filename = time() . '_' . Str::random(10) . '.' . $request->file('inspiration_image')->getClientOriginalExtension();
      $path = $request->file('inspiration_image')->storeAs('custom-jackets', $filename, 'public');
      $validated['inspiration_image'] = $path;
    }

    if (Auth::check()) {
      $validated['user_id'] = Auth::id();
    }

    $customJacket = CustomJacketRequest::create($validated);

    try {
      Mail::to($validated['email'])->send(new CustomJacketConfirmation($customJacket));

      $adminEmail = config('mail.from.address');
      Mail::to($adminEmail)->send(new CustomJacketQuoteRequested($customJacket));
    } catch (\Exception $e) {
      Log::error('Failed to send custom jacket emails: ' . $e->getMessage());
    }

    return redirect()->route('custom-jacket.builder')
      ->with('success', 'Thank you for your custom jacket request! We\'ll review your specifications and send a quote within 2-3 business days.');
  }
}
