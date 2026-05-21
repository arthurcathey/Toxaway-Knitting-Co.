// Vite entry point for JavaScript

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', () => {
  const mobileMenuBtn = document.getElementById('mobile-menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  
  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }
});

// Shop page utility functions
function updateCartCount(count) {
  const cartLink = document.querySelector('[data-cart-count]');
  if (cartLink) {
    cartLink.setAttribute('data-cart-count', count);
    if (count > 0) {
      cartLink.innerHTML = `CART <span class="bg-stone-900 text-stone-50 rounded-full w-5 h-5 flex items-center justify-center text-xs">${count}</span>`;
    }
  }
}

function requestConsultation() {
  window.location.href = '/contact?type=custom-consultation';
}
