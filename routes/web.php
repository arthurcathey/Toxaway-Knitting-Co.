<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Pages
Route::get('/', function () {
  return view('home');
})->name('home');

Route::get('/shop', [ProductController::class, 'index'])->name('shop');

// Product Routes
Route::get('/shop/{product}', [ProductController::class, 'show'])->name('product.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

Route::get('/heritage', function () {
  return view('heritage');
})->name('heritage');

Route::get('/craftsmanship', function () {
  return view('craftsmanship');
})->name('craftsmanship');

Route::get('/contact', function () {
  return view('contact');
})->name('contact');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
  $validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email',
    'phone' => 'nullable|string',
    'subject' => 'required|string',
    'message' => 'required|string|min:10',
  ]);

  // TODO: Send email notification
  // TODO: Save to database (create ContactRequest model)

  return redirect('/contact')->with('success', 'Thank you for your message! We\'ll get back to you soon.');
})->name('contact.store');

// Custom Jacket Routes (Phase 4)
Route::get('/custom-jacket', function () {
  return view('custom-jacket.builder');
})->name('custom-jacket.builder');

Route::post('/custom-jacket', function () {
  // TODO: Save custom jacket request to database
  // TODO: Send admin notification
  // TODO: Send customer confirmation
})->name('custom-jacket.store');

// Filament Admin Routes (handled by Filament package)
// Visit /admin once Filament is installed
