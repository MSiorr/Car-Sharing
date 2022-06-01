module.exports = {
  purge: {
    enabled: !process.env.ROLLUP_WATCH,
    mode: 'all',
    content: ['./**/**/*.html', './**/**/*.svelte'],
    options: {
      whitelistPatterns: [/svelte-/],
      defaultExtractor: (content) =>

        [...content.matchAll(/(?:class:)*([\w\d-/:%.]+)/gm)].map(([_match, group, ..._rest]) => group),
    },
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    screens: {
      'sm': '640px',
      // => @media (min-width: 640px) { ... }

      'md': '768px',
      // => @media (min-width: 768px) { ... }

      'lg': '1024px',
      // => @media (min-width: 1024px) { ... }

      'xl': '1280px',
      // => @media (min-width: 1280px) { ... }

      '2xl': '1536px',
      // => @media (min-width: 1536px) { ... }
    },
    boxShadow: {
      'white': '0 1px 3px 0 rgba(255, 255, 255, 0.1), 0 1px 2px 0 rgba(255, 255, 255, 0.06)',
      'white-md': '0 4px 6px -1px rgba(255, 255, 255, 0.1), 0 2px 4px -1px rgba(255, 255, 255, 0.06)',
      'white-lg': '0px 0px 12px 4px rgba(255,255,255,0.1), 0px 0px 12px 4px rgba(255,255,255,0.05)',
      'myBg-top': '0px -10px 25px 25px #111827, 0px -10px 25px 25px #111827'
    },
    minWidth: {
      '100p': '100px'
    },
    extend: {
      margin: {
        '-2': '-2rem',
        '-4': '-4rem',
        '-6': '-6rem',
        '-8': '-8rem',
        '-10': '-10rem',
      }
    },
    minHeight: {
      '8': '2rem',
      '10': '2.5rem',
    }
  },
  variants: {
    extend: {
      textColor: ['visited'],
    }
  },
  plugins: [],
}