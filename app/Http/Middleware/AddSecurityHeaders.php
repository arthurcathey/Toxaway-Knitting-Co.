<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddSecurityHeaders
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $response = $next($request);

    // Prevent MIME type sniffing
    $response->header('X-Content-Type-Options', 'nosniff');

    // Prevent clickjacking attacks (only allow framing from same origin)
    $response->header('X-Frame-Options', 'SAMEORIGIN');

    // Enable XSS protection in legacy browsers
    $response->header('X-XSS-Protection', '1; mode=block');

    // Control referrer information
    $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

    // Prevent sensitive data in HTTP header
    $response->header('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

    // Strict Transport Security (HSTS) - only if on HTTPS
    if ($request->secure()) {
      $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    }

    return $response;
  }
}
