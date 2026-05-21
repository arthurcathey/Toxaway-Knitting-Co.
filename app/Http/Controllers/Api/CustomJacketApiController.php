<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomJacketRequestResource;
use App\Mail\CustomJacketConfirmation;
use App\Mail\CustomJacketQuoteRequested;
use App\Models\CustomJacketRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CustomJacketApiController extends Controller
{
  /**
   * List authenticated user's custom jacket requests.
   */
  public function index(): ResourceCollection
  {
    $requests = CustomJacketRequest::where('user_id', Auth::id())
      ->orderBy('created_at', 'desc')
      ->paginate(10);

    return CustomJacketRequestResource::collection($requests);
  }

  /**
   * Get a specific custom jacket request.
   *
   * @throws AuthorizationException
   */
  public function show(CustomJacketRequest $customJacket): CustomJacketRequestResource
  {
    // Users can only view their own requests
    if ($customJacket->user_id !== Auth::id() && !Auth::user()->is_admin) {
      throw new AuthorizationException('Not authorized to view this request.');
    }

    return new CustomJacketRequestResource($customJacket);
  }

  /**
   * Create a new custom jacket request.
   *
   * @throws ValidationException
   */
  public function store(Request $request): JsonResponse
  {
    $validated = $request->validate([
      'full_name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'phone' => 'required|string|max:20',
      'base_style' => 'required|in:Varsity Jacket,Letterman,Bomber,Windbreaker',
      'primary_color' => 'required|in:Black,Navy Blue,Forest Green,Burgundy,Cream,Charcoal Gray',
      'secondary_color' => 'required|in:Black,Navy Blue,Forest Green,Burgundy,Cream,Charcoal Gray',
      'material' => 'required|in:Wool Blend,Fleece,Cotton,Polyester,Leather',
      'front_text' => 'nullable|string|max:50',
      'custom_details' => 'nullable|string|max:1000',
      'inspiration_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    // Sanitize text fields
    $validated['full_name'] = strip_tags($validated['full_name']);
    $validated['email'] = strip_tags($validated['email']);
    $validated['phone'] = strip_tags($validated['phone']);
    $validated['front_text'] = strip_tags($validated['front_text'] ?? '');
    $validated['custom_details'] = strip_tags($validated['custom_details'] ?? '');

    // Handle file upload
    if ($request->hasFile('inspiration_image')) {
      $file = $request->file('inspiration_image');
      $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
      $validated['inspiration_image'] = $file->storeAs('custom-jackets', $filename, 'public');
    }

    // Associate with authenticated user if logged in
    $validated['user_id'] = Auth::id();

    // Create the request
    $customJacket = CustomJacketRequest::create($validated);

    // Send emails
    try {
      Mail::to($customJacket->email)->send(new CustomJacketConfirmation($customJacket));
      Mail::to(config('mail.from.address'))->send(new CustomJacketQuoteRequested($customJacket));
    } catch (\Exception $e) {
      Log::error('Failed to send custom jacket emails', ['error' => $e->getMessage()]);
    }

    return response()->json([
      'message' => 'Custom jacket request submitted successfully',
      'data' => new CustomJacketRequestResource($customJacket),
    ], 201);
  }
}
