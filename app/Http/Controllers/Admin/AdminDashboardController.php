<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
  public function index()
  {
    $totalProducts = Product::count();
    $totalUsers = User::count();
    $inStockProducts = Product::where('in_stock', true)->count();

    return view('admin.dashboard', compact('totalProducts', 'totalUsers', 'inStockProducts'));
  }
}
