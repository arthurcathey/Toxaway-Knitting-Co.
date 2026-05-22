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
        $key = $item->product_id . '-' . $item->size;
        return [$key => [
          'product_id' => $item->product_id,
          'product_name' => $item->product_name,
          'price' => (float) $item->price,
          'quantity' => $item->quantity,
          'size' => $item->size,
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
  public function addToCart($productId, $quantity, $size, $productName, $price)
  {
    if (Auth::check()) {
      $this->addToUserCart($productId, $quantity, $size, $productName, $price);
    } else {
      $this->addToSessionCart($productId, $quantity, $size, $productName, $price);
    }
  }

  /**
   * Add item to user database cart
   */
  public function addToUserCart($productId, $quantity, $size, $productName, $price)
  {
    $key = $productId . '-' . $size;
    $existing = CartItem::where('user_id', Auth::id())
      ->where('product_id', $productId)
      ->where('size', $size)
      ->first();

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
      ]);
    }
  }

  /**
   * Add item to session cart
   */
  public function addToSessionCart($productId, $quantity, $size, $productName, $price)
  {
    $cart = Session::get('cart', []);
    $key = $productId . '-' . $size;

    if (isset($cart[$key])) {
      $cart[$key]['quantity'] += $quantity;
    } else {
      $cart[$key] = [
        'product_id' => $productId,
        'product_name' => $productName,
        'price' => (float) $price,
        'quantity' => $quantity,
        'size' => $size,
      ];
    }

    Session::put('cart', $cart);
  }

  /**
   * Remove item from cart
   */
  public function removeFromCart($productId, $size)
  {
    if (Auth::check()) {
      CartItem::where('user_id', Auth::id())
        ->where('product_id', $productId)
        ->where('size', $size)
        ->delete();
    } else {
      $cart = Session::get('cart', []);
      $key = $productId . '-' . $size;
      unset($cart[$key]);
      Session::put('cart', $cart);
    }
  }

  /**
   * Update cart item quantity
   */
  public function updateQuantity($productId, $size, $quantity)
  {
    if (Auth::check()) {
      if ($quantity <= 0) {
        $this->removeFromCart($productId, $size);
      } else {
        CartItem::where('user_id', Auth::id())
          ->where('product_id', $productId)
          ->where('size', $size)
          ->update(['quantity' => $quantity]);
      }
    } else {
      $cart = Session::get('cart', []);
      $key = $productId . '-' . $size;
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
        $item['size'],
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
