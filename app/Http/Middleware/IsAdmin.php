<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
  /**
   * Handle an incoming request.
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (Auth::check() && Auth::user()->is_admin) {
      return $next($request);
    }

    $userId = Auth::id();
    $userEmail = Auth::user()?->email ?? 'unauthenticated';
    Log::warning('Unauthorized admin access attempt', [
      'user_id' => $userId,
      'user_email' => $userEmail,
      'ip_address' => $request->ip(),
      'path' => $request->path(),
      'method' => $request->method(),
      'timestamp' => now(),
    ]);

    if ($request->expectsJson()) {
      return response()->json([
        'error' => 'Unauthorized. Admin access required.',
      ], 403);
    }

    return redirect('/')->with('error', 'You do not have permission to access this resource.');
  }
}
