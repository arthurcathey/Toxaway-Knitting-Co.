function removeFromCart(productId) {
  if (confirm('Remove this item from your cart?')) {
    fetch(window.cartConfig.removeUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': window.cartConfig.csrfToken,
      },
      body: JSON.stringify({
        product_id: productId,
      }),
    })
      .then(() => location.reload())
      .catch(error => console.error('Error:', error));
  }
}

function updateQuantity(productId, quantity) {
  fetch(window.cartConfig.updateUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': window.cartConfig.csrfToken,
    },
    body: JSON.stringify({
      product_id: productId,
      quantity: parseInt(quantity),
    }),
  })
    .then(() => location.reload())
    .catch(error => console.error('Error:', error));
}

function addToCart(productId) {
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
    }),
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
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

  document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', (e) => {
      const productId = input.getAttribute('data-product-id');
      const quantity = input.value;
      updateQuantity(productId, quantity);
    });
  });
});
