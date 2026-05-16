/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
        "./resources/**/*.ts",
        "./resources/**/*.tsx",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#4472C4',
                secondary: '#F5821F',
            },
            fontFamily: {
                nunito: ['Nunito', 'sans-serif'],
            },
        },
    },
    plugins: [],
}
