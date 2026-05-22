// Scroll to top on page load
function scrollToTopOnLoad() {
  document.documentElement.scrollTop = 0;
  document.body.scrollTop = 0;
  if (window.scrollTo) window.scrollTo(0, 0);
}

// Execute immediately
scrollToTopOnLoad();

// Execute on DOMContentLoaded
document.addEventListener('DOMContentLoaded', scrollToTopOnLoad);

// Execute on load event
window.addEventListener('load', scrollToTopOnLoad);
