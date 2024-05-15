/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
],
  theme: {
    extend: {
        colors: {
            clifford: '#da373d',
        }
    },
  },
  plugins: [],
}

