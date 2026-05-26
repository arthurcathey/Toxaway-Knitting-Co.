<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $response = $next($request);

    // Prevent clickjacking (frame injection)
    $response->header('X-Frame-Options', 'SAMEORIGIN');

    // Prevent MIME type sniffing - browser must respect declared Content-Type
    $response->header('X-Content-Type-Options', 'nosniff');

    // Enable XSS protection in older browsers
    $response->header('X-XSS-Protection', '1; mode=block');

    // Content Security Policy - Disabled in development (Vite IPv6 incompatible), strict in production
    if (!app()->environment('local', 'development')) {
      // Production - strict CSP
      $response->header(
        'Content-Security-Policy',
        "default-src 'self'; " .
          "script-src 'self' 'unsafe-inline' https://js.stripe.com https://cdn.jsdelivr.net; " .
          "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
          "img-src 'self' data: https:; " .
          "font-src 'self' data: https://cdn.jsdelivr.net; " .
          "connect-src 'self' https://api.stripe.com https://m.stripe.com; " .
          "frame-src https://js.stripe.com https://stripe.com; " .
          "upgrade-insecure-requests"
      );
    }

    // Referrer Policy - Don't send referrer to cross-origin sites
    $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

    // Permissions Policy (formerly Feature Policy)
    $response->header(
      'Permissions-Policy',
      'camera=(), microphone=(), geolocation=(), usb=(), magnetometer=(), gyroscope=(), accelerometer=()'
    );

    // Enforce HTTPS in production
    if (app()->environment('production')) {
      $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
    }

    return $response;
  }
}
