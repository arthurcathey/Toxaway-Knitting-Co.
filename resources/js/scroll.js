// Scroll to top on page load
function scrollToTopOnLoad() {
  document.documentElement.scrollTop = 0;
  document.body.scrollTop = 0;
  if (window.scrollTo) window.scrollTo(0, 0);
}

// Defer scroll setup to avoid blocking page render
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', scrollToTopOnLoad);
} else {
  // Page already loaded
  scrollToTopOnLoad();
}
