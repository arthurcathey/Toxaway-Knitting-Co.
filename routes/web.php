<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\CustomJacketController;

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

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest', 'throttle:5,1'); // 5 attempts per minute
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest', 'throttle:3,1'); // 3 attempts per minute

// Dashboard (Protected Route)
Route::get('/dashboard', function () {
  return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/shop', [ProductController::class, 'index'])->name('shop');

// Product Routes
Route::get('/shop/{product}', [ProductController::class, 'show'])->name('product.show');

// Cart Routes (Public - sessions work for all users)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

// Order Routes (Public - sessions work for all users)
Route::get('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/{order}', [OrderController::class, 'confirmation'])->name('order.confirmation');

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

// Custom Jacket Routes
Route::get('/custom-jacket', [CustomJacketController::class, 'show'])->name('custom-jacket.builder');
Route::post('/custom-jacket', [CustomJacketController::class, 'store'])->name('custom-jacket.store');

// Admin Routes (Protected)
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
  Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
  Route::resource('products', ProductAdminController::class);
  Route::resource('custom-jackets', \App\Http\Controllers\Admin\CustomJacketAdminController::class, ['only' => ['index', 'show', 'update']]);
  Route::post('custom-jackets/{customJacket}/cancel', [\App\Http\Controllers\Admin\CustomJacketAdminController::class, 'cancel'])->name('custom-jackets.cancel');
});
