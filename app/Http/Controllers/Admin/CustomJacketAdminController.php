<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomJacketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CustomJacketAdminController extends Controller
{
  /**
   * Display a listing of custom jacket requests.
   */
  public function index(Request $request)
  {
    $query = CustomJacketRequest::query();

    // Filter by status
    if ($request->has('status') && $request->status !== '') {
      $query->where('status', $request->status);
    }

    // Search by name or email
    if ($request->has('search') && $request->search !== '') {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('full_name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%");
      });
    }

    // Sort options
    $sortBy = $request->get('sort', 'created_at');
    $sortOrder = $request->get('order', 'desc');

    if (in_array($sortBy, ['created_at', 'status', 'full_name'])) {
      $query->orderBy($sortBy, $sortOrder);
    }

    // Pagination
    $requests = $query->paginate(15);

    // Statistics
    $stats = [
      'total' => CustomJacketRequest::count(),
      'pending' => CustomJacketRequest::where('status', 'pending')->count(),
      'quoted' => CustomJacketRequest::where('status', 'quoted')->count(),
      'approved' => CustomJacketRequest::where('status', 'approved')->count(),
      'in_production' => CustomJacketRequest::where('status', 'in_production')->count(),
      'completed' => CustomJacketRequest::where('status', 'completed')->count(),
      'cancelled' => CustomJacketRequest::where('status', 'cancelled')->count(),
    ];

    return view('admin.custom-jackets.index', [
      'requests' => $requests,
      'stats' => $stats,
      'currentStatus' => $request->get('status', ''),
      'searchTerm' => $request->get('search', ''),
      'sortBy' => $sortBy,
      'sortOrder' => $sortOrder,
    ]);
  }

  /**
   * Display the specified custom jacket request.
   */
  public function show(CustomJacketRequest $customJacket)
  {
    return view('admin.custom-jackets.show', ['request' => $customJacket]);
  }

  /**
   * Update the specified custom jacket request.
   */
  public function update(Request $request, CustomJacketRequest $customJacket)
  {
    $validated = $request->validate([
      'status' => 'required|string|in:pending,quoted,approved,in_production,completed,cancelled',
      'quoted_price' => 'nullable|numeric|min:0',
      'admin_notes' => 'nullable|string|max:2000',
    ]);

    // Track if this is the first quote
    $isFirstQuote = $customJacket->status === 'pending' && $validated['status'] === 'quoted';

    // Update the request
    $customJacket->update($validated);

    // Set quoted_at timestamp if transitioning to quoted
    if ($isFirstQuote) {
      $customJacket->update(['quoted_at' => now()]);
    }

    // Set approved_at timestamp if transitioning to approved
    if ($customJacket->status === 'quoted' && $validated['status'] === 'approved') {
      $customJacket->update(['approved_at' => now()]);
    }

    Log::info('Custom jacket request updated', [
      'request_id' => $customJacket->id,
      'admin_id' => Auth::id(),
      'new_status' => $validated['status'],
      'quoted_price' => $validated['quoted_price'],
    ]);

    return redirect()->route('admin.custom-jackets.show', $customJacket)
      ->with('success', 'Custom jacket request updated successfully.');
  }

  /**
   * Cancel a custom jacket request.
   */
  public function cancel(CustomJacketRequest $customJacket)
  {
    $customJacket->update([
      'status' => 'cancelled',
      'admin_notes' => ($customJacket->admin_notes ?? '') . "\n\n[" . now()->format('Y-m-d H:i') . "] Cancelled by admin"
    ]);

    Log::info('Custom jacket request cancelled', [
      'request_id' => $customJacket->id,
      'admin_id' => Auth::id(),
    ]);

    return redirect()->route('admin.custom-jackets.index')
      ->with('success', 'Custom jacket request cancelled.');
  }

  /**
   * Get status badge classes.
   */
  public static function getStatusBadgeClass($status)
  {
    return match ($status) {
      'pending' => 'bg-yellow-100 text-yellow-800',
      'quoted' => 'bg-blue-100 text-blue-800',
      'approved' => 'bg-purple-100 text-purple-800',
      'in_production' => 'bg-indigo-100 text-indigo-800',
      'completed' => 'bg-green-100 text-green-800',
      'cancelled' => 'bg-red-100 text-red-800',
      default => 'bg-gray-100 text-gray-800',
    };
  }

  /**
   * Get status label.
   */
  public static function getStatusLabel($status)
  {
    return match ($status) {
      'pending' => 'Pending Review',
      'quoted' => 'Quote Sent',
      'approved' => 'Approved',
      'in_production' => 'In Production',
      'completed' => 'Completed',
      'cancelled' => 'Cancelled',
      default => ucfirst($status),
    };
  }

  /**
   * Get color hex code for display.
   */
  public static function getColorHex($colorName)
  {
    return match ($colorName) {
      'Black' => '#000000',
      'Navy Blue' => '#001f3f',
      'Forest Green' => '#228b22',
      'Burgundy' => '#800020',
      'Cream' => '#fffdd0',
      'Charcoal Gray' => '#36454f',
      default => '#808080',
    };
  }
}
