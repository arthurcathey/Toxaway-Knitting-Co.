<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
  /**
   * Get cart items for current user (session or database)
   */
  public function getCart()
  {
    if (Auth::check()) {
      return $this->getUserCart();
    }
    return $this->getSessionCart();
  }

  /**
   * Get user's database cart
   */
  public function getUserCart()
  {
    return CartItem::where('user_id', Auth::id())
      ->get()
      ->mapWithKeys(function ($item) {
        $key = $item->product_id . '-' . ($item->size ?? '') . '-' . ($item->color ?? '');
        return [$key => [
          'product_id' => $item->product_id,
          'product_name' => $item->product_name,
          'price' => (float) $item->price,
          'quantity' => $item->quantity,
          'size' => $item->size,
          'color' => $item->color,
        ]];
      })
      ->toArray();
  }

  /**
   * Get guest session cart
   */
  public function getSessionCart()
  {
    return Session::get('cart', []);
  }

  /**
   * Get total cart count
   */
  public function getCartCount()
  {
    $cart = $this->getCart();
    return array_sum(array_column($cart, 'quantity'));
  }

  /**
   * Add item to cart
   */
  public function addToCart($productId, $quantity, $size, $color, $productName, $price)
  {
    if (Auth::check()) {
      $this->addToUserCart($productId, $quantity, $size, $color, $productName, $price);
    } else {
      $this->addToSessionCart($productId, $quantity, $size, $color, $productName, $price);
    }
  }

  /**
   * Add item to user database cart
   */
  public function addToUserCart($productId, $quantity, $size, $color, $productName, $price)
  {
    $key = $productId . '-' . ($size ?? '') . '-' . ($color ?? '');

    // Build query to find existing item with proper null handling
    $query = CartItem::where('user_id', Auth::id())
      ->where('product_id', $productId);

    if ($size === null) {
      $query->whereNull('size');
    } else {
      $query->where('size', $size);
    }

    if ($color === null) {
      $query->whereNull('color');
    } else {
      $query->where('color', $color);
    }

    $existing = $query->first();

    if ($existing) {
      $existing->update(['quantity' => $existing->quantity + $quantity]);
    } else {
      CartItem::create([
        'user_id' => Auth::id(),
        'product_id' => $productId,
        'product_name' => $productName,
        'price' => $price,
        'quantity' => $quantity,
        'size' => $size,
        'color' => $color,
      ]);
    }
  }

  /**
   * Add item to session cart
   */
  public function addToSessionCart($productId, $quantity, $size, $color, $productName, $price)
  {
    $cart = Session::get('cart', []);
    $key = $productId . '-' . ($size ?? '') . '-' . ($color ?? '');

    if (isset($cart[$key])) {
      $cart[$key]['quantity'] += $quantity;
    } else {
      $cart[$key] = [
        'product_id' => $productId,
        'product_name' => $productName,
        'price' => (float) $price,
        'quantity' => $quantity,
        'size' => $size,
        'color' => $color,
      ];
    }

    Session::put('cart', $cart);
  }

  /**
   * Remove item from cart
   */
  public function removeFromCart($productId, $size, $color)
  {
    if (Auth::check()) {
      $query = CartItem::where('user_id', Auth::id())
        ->where('product_id', $productId);

      // Handle null values properly with IS NULL instead of = NULL
      if ($size === null) {
        $query->whereNull('size');
      } else {
        $query->where('size', $size);
      }

      if ($color === null) {
        $query->whereNull('color');
      } else {
        $query->where('color', $color);
      }

      $query->delete();
    } else {
      $cart = Session::get('cart', []);
      $key = $productId . '-' . ($size ?? '') . '-' . ($color ?? '');
      unset($cart[$key]);
      Session::put('cart', $cart);
    }
  }

  /**
   * Update cart item quantity
   */
  public function updateQuantity($productId, $size, $color, $quantity)
  {
    if (Auth::check()) {
      if ($quantity <= 0) {
        $this->removeFromCart($productId, $size, $color);
      } else {
        $query = CartItem::where('user_id', Auth::id())
          ->where('product_id', $productId);

        // Handle null values properly
        if ($size === null) {
          $query->whereNull('size');
        } else {
          $query->where('size', $size);
        }

        if ($color === null) {
          $query->whereNull('color');
        } else {
          $query->where('color', $color);
        }

        $query->update(['quantity' => $quantity]);
      }
    } else {
      $cart = Session::get('cart', []);
      $key = $productId . '-' . ($size ?? '') . '-' . ($color ?? '');
      if ($quantity <= 0) {
        unset($cart[$key]);
      } else {
        $cart[$key]['quantity'] = $quantity;
      }
      Session::put('cart', $cart);
    }
  }

  /**
   * Clear cart
   */
  public function clearCart()
  {
    if (Auth::check()) {
      CartItem::where('user_id', Auth::id())->delete();
    } else {
      Session::forget('cart');
    }
  }

  /**
   * Merge session cart to user cart (called on login)
   */
  public function mergeSessionCartToUser()
  {
    $sessionCart = Session::get('cart', []);

    foreach ($sessionCart as $item) {
      $this->addToUserCart(
        $item['product_id'],
        $item['quantity'],
        $item['size'] ?? null,
        $item['color'] ?? null,
        $item['product_name'],
        $item['price']
      );
    }

    // Clear session cart after merging
    Session::forget('cart');
  }

  /**
   * Clear session cart (called on logout)
   */
  public function clearSessionCart()
  {
    Session::forget('cart');
  }
}
