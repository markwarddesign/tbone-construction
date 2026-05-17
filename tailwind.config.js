/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './blocks/**/*.{js,jsx,php}',
        './parts/**/*.html',
        './patterns/**/*.php',
        './templates/**/*.html',
        './functions.php',
        './inc/**/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans:  ['ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'sans-serif'],
                serif: ['Georgia', 'Times New Roman', 'serif'],
            },
            colors: {
                linen:    '#faf8f5',
                ink:      '#1f2926',
                rust:     '#c25e24',
                'rust-dark': '#7a3b16',
            },
        },
    },
    plugins: [],
};
