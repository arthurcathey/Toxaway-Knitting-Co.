function removeFromCart(productId, size) {
  if (confirm('Remove this item from your cart?')) {
    fetch(window.cartConfig.removeUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': window.cartConfig.csrfToken,
      },
      body: JSON.stringify({
        product_id: productId,
        size: size,
      }),
    })
      .then(response => response.json())
      .then(data => {
        localStorage.setItem('cartCount', data.cartCount);
        if (typeof updateCartCount === 'function') {
          updateCartCount(data.cartCount);
        }
        location.reload();
      })
      .catch(error => console.error('Error:', error));
  }
}

function updateQuantity(productId, size, quantity) {
  fetch(window.cartConfig.updateUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': window.cartConfig.csrfToken,
    },
    body: JSON.stringify({
      product_id: productId,
      size: size,
      quantity: parseInt(quantity),
    }),
  })
    .then(response => response.json())
    .then(data => {
      localStorage.setItem('cartCount', data.cartCount);
      if (typeof updateCartCount === 'function') {
        updateCartCount(data.cartCount);
      }
      location.reload();
    })
    .catch(error => console.error('Error:', error));
}

function addToCart(productId) {
  const sizeSelect = document.getElementById(`size-${productId}`);
  
  // Check if a size selector exists and if a size has been selected
  if (sizeSelect && !sizeSelect.value) {
    alert('Please select a size before adding to cart.');
    return;
  }

  const size = sizeSelect ? sizeSelect.value : '';
  const quantityInput = document.getElementById(`quantity-${productId}`);
  const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;

  fetch(window.cartConfig.addUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': window.cartConfig.csrfToken,
    },
    body: JSON.stringify({
      product_id: productId,
      quantity: quantity,
      size: size,
    }),
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        localStorage.setItem('cartCount', data.cartCount);
        alert('Added to cart! You now have ' + data.cartCount + ' item(s).');
        if (typeof updateCartCount === 'function') {
          updateCartCount(data.cartCount);
        }
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Failed to add to cart. Please try again.');
    });
}

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-add-to-cart]').forEach(button => {
    button.addEventListener('click', (e) => {
      const productId = button.getAttribute('data-add-to-cart');
      addToCart(productId);
    });
  });

  document.querySelectorAll('[data-remove-from-cart]').forEach(button => {
    button.addEventListener('click', (e) => {
      const productId = button.getAttribute('data-remove-from-cart');
      removeFromCart(productId);
    });
  });

  // Handle remove cart button clicks with both product_id and size
  document.querySelectorAll('.remove-cart-btn').forEach(button => {
    button.addEventListener('click', function() {
      const productId = this.dataset.productId;
      const size = this.dataset.size;
      removeFromCart(productId, size);
    });
  });

  document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', (e) => {
      const productId = input.getAttribute('data-product-id');
      const size = input.getAttribute('data-size');
      const quantity = input.value;
      updateQuantity(productId, size, quantity);
    });
  });
});
