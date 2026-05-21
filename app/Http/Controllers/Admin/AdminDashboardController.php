<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\CustomJacketRequest;

class AdminDashboardController extends Controller
{
  public function index()
  {
    $totalProducts = Product::count();
    $totalUsers = User::count();
    $inStockProducts = Product::where('in_stock', true)->count();

    // Custom jacket statistics
    $totalRequests = CustomJacketRequest::count();
    $pendingRequests = CustomJacketRequest::where('status', 'pending')->count();
    $quotedRequests = CustomJacketRequest::where('status', 'quoted')->count();
    $completedRequests = CustomJacketRequest::where('status', 'completed')->count();

    return view('admin.dashboard', compact(
      'totalProducts',
      'totalUsers',
      'inStockProducts',
      'totalRequests',
      'pendingRequests',
      'quotedRequests',
      'completedRequests'
    ));
  }
}
