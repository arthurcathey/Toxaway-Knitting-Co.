/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        mono: ['-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', '"Helvetica Neue"', 'Arial', 'sans-serif'],
      },
      // Add CSS containment for better rendering performance
      container: {
        center: true,
        padding: '1rem',
      },
    },
  },
  plugins: [],
  // Optimize for production builds
  safelist: [
    // Add any dynamic classes that should never be purged
  ],
}
