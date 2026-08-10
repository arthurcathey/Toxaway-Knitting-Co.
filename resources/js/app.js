
document.addEventListener('DOMContentLoaded', () => {
  const mobileMenuBtn = document.getElementById('mobile-menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  
  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }
});

function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const scrollBtn = document.getElementById('scroll-to-top-btn');
  
  if (scrollBtn) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        scrollBtn.classList.remove('hidden');
      } else {
        scrollBtn.classList.add('hidden');
      }
    });
    
    scrollBtn.addEventListener('click', scrollToTop);
  }
});

function updateCartCount(count) {
  const cartLink = document.querySelector('[data-cart-count]');
  if (cartLink) {
    cartLink.setAttribute('data-cart-count', count);
    if (count > 0) {
      cartLink.classList.add('inline-flex', 'items-center', 'gap-2');
      cartLink.innerHTML = `CART <span class="bg-stone-900 text-stone-50 rounded-full w-5 h-5 flex items-center justify-center text-xs">${count}</span>`;
    } else {
      cartLink.classList.remove('inline-flex', 'items-center', 'gap-2');
      cartLink.innerHTML = 'CART';
    }
  }
}

// Initialize cart count from server on page load
document.addEventListener('DOMContentLoaded', () => {
  // Use requestIdleCallback to defer non-critical cart initialization
  if ('requestIdleCallback' in window) {
    requestIdleCallback(() => {
      initializeCartCount();
      setupCartHandlers();
    });
  } else {
    // Fallback for browsers that don't support requestIdleCallback
    setTimeout(() => {
      initializeCartCount();
      setupCartHandlers();
    }, 0);
  }

  // Handle size selection - disable add to cart button until size is chosen (critical for UX)
  document.querySelectorAll('[data-add-to-cart]').forEach(button => {
    const productId = button.getAttribute('data-add-to-cart');
    const sizeSelect = document.getElementById(`size-${productId}`);
    
    if (sizeSelect) {
      // Initially disable the button if no size is selected
      button.disabled = true;
      button.classList.add('opacity-50', 'cursor-not-allowed');
      
      // Enable/disable button based on size selection
      sizeSelect.addEventListener('change', () => {
        if (sizeSelect.value) {
          button.disabled = false;
          button.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
          button.disabled = true;
          button.classList.add('opacity-50', 'cursor-not-allowed');
        }
      });
    }
  });

  // Delete confirmation handler
  document.querySelectorAll('[data-confirm-delete]').forEach(form => {
    form.addEventListener('submit', (e) => {
      const message = form.getAttribute('data-confirm-delete');
      if (!confirm(message)) {
        e.preventDefault();
      }
    });
  });
});

function initializeCartCount() {
  const timestamp = new Date().getTime();
  fetch(`/cart/count?t=${timestamp}`)
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      const cartCount = parseInt(data.cartCount) || 0;
      localStorage.setItem('cartCount', cartCount);
      updateCartCount(cartCount);
    })
    .catch(error => {
      const cartCount = parseInt(localStorage.getItem('cartCount')) || 0;
      if (cartCount > 0) {
        updateCartCount(cartCount);
      } else {
        updateCartCount(0);
      }
    });
}

function setupCartHandlers() {
  // Handle quantity input changes on cart page
  document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', () => {
      const productId = input.getAttribute('data-product-id');
      const size = input.getAttribute('data-size');
      const color = input.getAttribute('data-color');
      const quantity = input.value;
      
      if (productId) {
        updateQuantity(productId, size, color, quantity);
      }
    });
  });

  // Handle remove from cart button
  document.querySelectorAll('.remove-cart-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const productId = btn.getAttribute('data-product-id');
      const size = btn.getAttribute('data-size');
      const color = btn.getAttribute('data-color');
      
      if (productId) {
        removeFromCart(productId, size, color);
      }
    });
  });

  // Add to cart button click handlers
  document.querySelectorAll('[data-add-to-cart]').forEach(button => {
    button.addEventListener('click', (e) => {
      const productId = button.getAttribute('data-add-to-cart');
      addToCart(productId);
    });
  });
}

function requestConsultation() {
  window.location.href = '/contact?type=custom-consultation';
}
