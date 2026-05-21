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
    // Classes used inline in WP post/page content (stored in the DB, not
    // visible to the JIT scanner). Keep this list as small as practical.
    safelist: [
        // Padding / margin / gap, all sides, full spacing scale
        { pattern: /^(p|m|gap)(t|r|b|l|x|y)?-(0|0\.5|1|1\.5|2|2\.5|3|3\.5|4|5|6|7|8|9|10|11|12|14|16|20|24|28|32|40|48|56|64)$/,
          variants: [ 'sm', 'md', 'lg', 'xl' ] },
        // Container widths
        { pattern: /^max-w-(xs|sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl|full|prose|none)$/,
          variants: [ 'sm', 'md', 'lg' ] },
        // space-y / space-x utilities
        { pattern: /^space-(x|y)-(0|0\.5|1|1\.5|2|2\.5|3|3\.5|4|5|6|7|8|9|10|11|12|14|16|20|24|28|32)$/,
          variants: [ 'sm', 'md', 'lg' ] },
        // Text sizes and alignment used in long-form content
        { pattern: /^text-(xs|sm|base|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl|left|center|right|justify)$/,
          variants: [ 'sm', 'md', 'lg' ] },
        // Flex / grid helpers used inline
        { pattern: /^(flex|grid|hidden|block|inline-flex|inline-block|items-(start|center|end|baseline|stretch)|justify-(start|center|end|between|around|evenly))$/,
          variants: [ 'sm', 'md', 'lg' ] },
        // Grid column counts
        { pattern: /^grid-cols-(1|2|3|4|5|6|7|8|9|10|11|12)$/,
          variants: [ 'sm', 'md', 'lg' ] },
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
