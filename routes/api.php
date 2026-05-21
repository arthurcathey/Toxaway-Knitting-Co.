<?php

use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CustomJacketApiController;
use App\Http\Controllers\Api\CartApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
  // Public health check
  Route::get('health', fn() => response()->json(['status' => 'ok']));

  // Public Products API - no authentication required
  Route::prefix('products')->group(function () {
    Route::get('/', [ProductApiController::class, 'index'])->middleware('throttle:60,1');
    Route::get('{id}', [ProductApiController::class, 'show'])->middleware('throttle:60,1');
  });

  // Protected Custom Jacket API - requires authentication
  Route::middleware('auth:sanctum')->prefix('custom-jackets')->group(function () {
    Route::get('/', [CustomJacketApiController::class, 'index'])->middleware('throttle:120,1');
    Route::get('{customJacket}', [CustomJacketApiController::class, 'show'])->middleware('throttle:120,1');
    Route::post('/', [CustomJacketApiController::class, 'store'])->middleware('throttle:5,1');
  });

  // Authenticated user info
  Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return response()->json([
      'id' => $request->user()->id,
      'name' => $request->user()->name,
      'email' => $request->user()->email,
      'is_admin' => $request->user()->is_admin,
    ]);
  });
});

// NOTE: Cart API removed - Use existing web routes at /cart instead
// Cart session-based functionality works via traditional web routes
