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
use App\Http\Controllers\SitemapController;

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
  view()->share(
    'seo',
    (new \App\Services\SeoService())
      ->setTitle('Toxaway Knitting Co. | Handmade American Knitwear')
      ->setDescription('Premium, heavyweight, American-made knitwear with meticulous attention to craft. Shop handcrafted sweaters and custom jackets made to last.')
      ->setUrl(config('app.url'))
      ->setKeywords(['handmade knitwear', 'American made', 'sweaters', 'custom jackets', 'wool clothing'])
      ->setType('website')
      ->setStructuredData(\App\Services\SeoService::organizationSchema())
  );
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
  view()->share(
    'seo',
    (new \App\Services\SeoService())
      ->setTitle('Our Heritage | Toxaway Knitting Co.')
      ->setDescription('Learn about our brand story and commitment to American-made knitwear crafted with meticulous attention to detail and quality.')
      ->setUrl(route('heritage'))
      ->setKeywords(['heritage', 'American made', 'brand story', 'knitwear', 'craft'])
      ->setStructuredData(\App\Services\SeoService::organizationSchema())
  );
  return view('heritage');
})->name('heritage');

Route::get('/craftsmanship', function () {
  view()->share(
    'seo',
    (new \App\Services\SeoService())
      ->setTitle('Our Craftsmanship | Toxaway Knitting Co.')
      ->setDescription('Discover our meticulous approach to knitwear production, materials sourcing, and quality control that makes Toxaway sweaters exceptional.')
      ->setUrl(route('craftsmanship'))
      ->setKeywords(['craftsmanship', 'quality', 'knitwear production', 'materials', 'handmade'])
      ->setStructuredData(\App\Services\SeoService::organizationSchema())
  );
  return view('craftsmanship');
})->name('craftsmanship');

Route::get('/contact', function () {
  view()->share(
    'seo',
    (new \App\Services\SeoService())
      ->setTitle('Contact Us | Toxaway Knitting Co.')
      ->setDescription('Have questions? Get in touch with our team for sizing help, custom orders, or general inquiries about our handmade knitwear.')
      ->setUrl(route('contact'))
      ->setKeywords(['contact', 'support', 'customer service', 'inquiries'])
      ->setStructuredData(\App\Services\SeoService::organizationSchema())
  );
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

  // Send notification email to admin
  try {
    \Mail::to(config('mail.from.address', 'admin@toxawayknitting.com'))->send(
      new \App\Mail\ContactNotification(
        $validated['name'],
        $validated['email'],
        $validated['phone'] ?? '',
        $validated['subject'],
        $validated['message']
      )
    );
  } catch (\Exception $e) {
    \Log::warning('Failed to send contact notification email: ' . $e->getMessage());
  }

  return redirect('/contact')->with('success', 'Thank you for your message! We\'ll get back to you soon.');
})->name('contact.store');

// Custom Jacket Routes
Route::get('/custom-jacket', [CustomJacketController::class, 'show'])->name('custom-jacket.builder');
Route::post('/custom-jacket', [CustomJacketController::class, 'store'])->name('custom-jacket.store');

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Admin Routes (Protected)
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
  Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
  Route::resource('products', ProductAdminController::class);
  Route::resource('custom-jackets', \App\Http\Controllers\Admin\CustomJacketAdminController::class, ['only' => ['index', 'show', 'update']]);
  Route::post('custom-jackets/{customJacket}/cancel', [\App\Http\Controllers\Admin\CustomJacketAdminController::class, 'cancel'])->name('custom-jackets.cancel');
});
