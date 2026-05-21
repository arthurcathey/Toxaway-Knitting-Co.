<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductApiController extends Controller
{
  /**
   * Get all products with optional filtering and search.
   *
   * @queryParam search string Search by product name
   * @queryParam in_stock boolean Filter by stock status (1 or 0)
   * @queryParam sort string Sort field (name, price, created_at)
   * @queryParam order string Sort order (asc or desc)
   * @queryParam per_page integer Items per page (default: 15)
   */
  public function index(Request $request): ResourceCollection
  {
    $query = Product::query();

    // Search
    if ($request->filled('search')) {
      $query->where('name', 'like', '%' . $request->search . '%')
        ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    // Filter by stock
    if ($request->filled('in_stock')) {
      if ($request->in_stock == 1) {
        $query->where('quantity_available', '>', 0);
      } else {
        $query->where('quantity_available', '<=', 0);
      }
    }

    // Sorting
    $sort = $request->get('sort', 'created_at');
    $order = $request->get('order', 'desc');
    $allowedSorts = ['name', 'price', 'created_at', 'quantity_available'];

    if (in_array($sort, $allowedSorts)) {
      $query->orderBy($sort, $order === 'asc' ? 'asc' : 'desc');
    }

    $perPage = min($request->get('per_page', 15), 100);
    $products = $query->paginate($perPage);

    return ProductResource::collection($products);
  }

  /**
   * Get a single product by ID.
   */
  public function show(int $id): ProductResource
  {
    $product = Product::findOrFail($id);
    return new ProductResource($product);
  }
}
