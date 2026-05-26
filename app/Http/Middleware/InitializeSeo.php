<?php

namespace App\Http\Middleware;

use App\Services\SeoService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InitializeSeo
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Create a SEO service instance
    $seo = new SeoService();

    // Set organization schema for all pages
    $seo->setStructuredData(SeoService::organizationSchema());

    // Share with all views
    view()->share('seo', $seo);

    return $next($request);
  }
}
