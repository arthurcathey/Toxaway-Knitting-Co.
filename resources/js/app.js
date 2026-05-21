
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
      cartLink.innerHTML = `CART <span class="bg-stone-900 text-stone-50 rounded-full w-5 h-5 flex items-center justify-center text-xs">${count}</span>`;
    } else {
      cartLink.innerHTML = 'CART';
    }
  }
}

// Initialize cart count from session on page load
document.addEventListener('DOMContentLoaded', () => {
  // Get cart count from localStorage or session
  const cartCount = localStorage.getItem('cartCount') || 0;
  if (cartCount > 0) {
    updateCartCount(cartCount);
  }
});

function requestConsultation() {
  window.location.href = '/contact?type=custom-consultation';
}

// Delete confirmation handler
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-confirm-delete]').forEach(form => {
    form.addEventListener('submit', (e) => {
      const message = form.getAttribute('data-confirm-delete');
      if (!confirm(message)) {
        e.preventDefault();
      }
    });
  });
});
