/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/admin/**/*.blade.php',
    ],
    theme: {
        extend: {},
    },
    corePlugins: {
        preflight: false,
    },
    plugins: [],
}
