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
            'purple-header':'#3E1B3A',
            'black-header':'#1E1E1E',
            'cian-header':'#22294F',
        }
    },
  },
  plugins: [],
}

