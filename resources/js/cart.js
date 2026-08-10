function removeFromCart(productId, size, color) {
  if (confirm('Remove this item from your cart?')) {
    // Normalize empty strings to null
    const normalizedSize = size || null;
    const normalizedColor = color || null;
    
    console.log('Removing from cart:', { productId, size: normalizedSize, color: normalizedColor });
    
    fetch(window.cartConfig.removeUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': window.cartConfig.csrfToken,
      },
      body: JSON.stringify({
        product_id: parseInt(productId),
        size: normalizedSize,
        color: normalizedColor,
      }),
    })
      .then(response => {
        if (!response.ok) {
          return response.text().then(text => {
            console.error('Server response:', text);
            try {
              const data = JSON.parse(text);
              throw new Error(data.message || 'Failed to remove item');
            } catch (e) {
              throw new Error('Server error: ' + text.substring(0, 100));
            }
          });
        }
        return response.json();
      })
      .then(data => {
        localStorage.setItem('cartCount', data.cartCount);
        if (typeof updateCartCount === 'function') {
          updateCartCount(data.cartCount);
        }
        location.reload();
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Failed to remove item: ' + error.message);
      });
  }
}

function updateQuantity(productId, size, color, quantity) {
  // Normalize empty strings to null
  const normalizedSize = size || null;
  const normalizedColor = color || null;
  
  console.log('Updating quantity:', { productId, size: normalizedSize, color: normalizedColor, quantity });
  
  fetch(window.cartConfig.updateUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': window.cartConfig.csrfToken,
    },
    body: JSON.stringify({
      product_id: parseInt(productId),
      size: normalizedSize,
      color: normalizedColor,
      quantity: parseInt(quantity),
    }),
  })
    .then(response => {
      if (!response.ok) {
        return response.text().then(text => {
          console.error('Server response:', text);
          try {
            const data = JSON.parse(text);
            throw new Error(data.message || 'Failed to update quantity');
          } catch (e) {
            throw new Error('Server error: ' + text.substring(0, 100));
          }
        });
      }
      return response.json();
    })
    .then(data => {
      localStorage.setItem('cartCount', data.cartCount);
      if (typeof updateCartCount === 'function') {
        updateCartCount(data.cartCount);
      }
      location.reload();
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Failed to update quantity: ' + error.message);
    });
}

function addToCart(productId) {
  const sizeSelect = document.getElementById(`size-${productId}`);
  const colorSelect = document.getElementById(`color-${productId}`);
  
  // Check if a color selector exists and if a color has been selected
  if (colorSelect && !colorSelect.value) {
    alert('Please select a color before adding to cart.');
    return;
  }

  // Check if a size selector exists and if a size has been selected
  if (sizeSelect && !sizeSelect.value) {
    alert('Please select a size before adding to cart.');
    return;
  }

  const size = sizeSelect ? sizeSelect.value : '';
  const color = colorSelect ? colorSelect.value : '';
  const quantityInput = document.getElementById(`quantity-${productId}`);
  const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;

  fetch(window.cartConfig.addUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': window.cartConfig.csrfToken,
    },
    body: JSON.stringify({
      product_id: productId,
      quantity: quantity,
      size: size,
      color: color,
    }),
  })
    .then(response => {
      if (!response.ok) {
        return response.text().then(text => {
          try {
            const data = JSON.parse(text);
            throw new Error(data.message || data.error || 'Failed to add to cart');
          } catch (e) {
            throw new Error('Server error: ' + text.substring(0, 100));
          }
        });
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        localStorage.setItem('cartCount', data.cartCount);
        alert('Added to cart! You now have ' + data.cartCount + ' item(s).');
        if (typeof updateCartCount === 'function') {
          updateCartCount(data.cartCount);
        }
      } else {
        alert(data.message || 'Failed to add to cart. Please try again.');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Failed to add to cart. Please try again. Error: ' + error.message);
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

// Expose functions globally for use in HTML event handlers and other scripts
window.removeFromCart = removeFromCart;
window.updateQuantity = updateQuantity;
window.addToCart = addToCart;
