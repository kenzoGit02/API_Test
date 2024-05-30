/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{php,html,js,cjs,mjs,ts}"],
  theme: {
    extend: {},
  },
  plugins: [require('@tailwindcss/forms')],
}

