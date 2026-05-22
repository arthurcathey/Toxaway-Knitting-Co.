// Global cart configuration
// Set by server-side template with Laravel routes and CSRF token
// This allows all cart functions to access the necessary endpoints

if (typeof window.cartConfig === 'undefined') {
  console.warn('cartConfig not initialized. Cart operations may not work.');
}
