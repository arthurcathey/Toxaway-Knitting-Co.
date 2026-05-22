<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  protected $cartService;

  public function __construct(CartService $cartService)
  {
    $this->cartService = $cartService;
  }

  public function showLoginForm()
  {
    return view('auth.login');
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:6',
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
      $request->session()->regenerate();

      // Merge guest cart to user account
      $this->cartService->mergeSessionCartToUser();

      return redirect()->intended(route('dashboard'));
    }

    return back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
  }

  public function logout(Request $request)
  {
    // Clear user cart and session cart
    $this->cartService->clearSessionCart();

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
  }
}
