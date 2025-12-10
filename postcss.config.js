<<<<<<< Updated upstream
const tailwindcss = require('@tailwindcss/postcss');

module.exports = {
  plugins: [
    tailwindcss(),
    require('autoprefixer'),
  ],
=======
/** @type {import('postcss').Config} */
export default {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
  },
>>>>>>> Stashed changes
}
