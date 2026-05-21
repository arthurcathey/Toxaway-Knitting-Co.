// Cart management functions
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
  fetch(window.cartConfig.addUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': window.cartConfig.csrfToken,
    },
    body: JSON.stringify({
      product_id: productId,
      quantity: 1,
    }),
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Added to cart!');
        location.reload();
      }
    })
    .catch(error => console.error('Error:', error));
}

// Event Listeners for data attributes
document.addEventListener('DOMContentLoaded', () => {
  // Handle "Add to Cart" buttons
  document.querySelectorAll('[data-add-to-cart]').forEach(button => {
    button.addEventListener('click', (e) => {
      const productId = button.getAttribute('data-add-to-cart');
      addToCart(productId);
    });
  });

  // Handle "Remove from Cart" buttons
  document.querySelectorAll('[data-remove-from-cart]').forEach(button => {
    button.addEventListener('click', (e) => {
      const productId = button.getAttribute('data-remove-from-cart');
      removeFromCart(productId);
    });
  });

  // Handle quantity input changes
  document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', (e) => {
      const productId = input.getAttribute('data-product-id');
      const quantity = input.value;
      updateQuantity(productId, quantity);
    });
  });
});
