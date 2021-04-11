module.exports = {
  theme: {
    extend: {
      colors: {
        primary: '#181066',
        secondary: '#0FC9F5',
        mydark: '#20494F',
        success: 'green',
        warning: 'orange',
        error: 'red',
        info: 'grey',

        // ...
      },
      height: {
        quarterscreen: '25vh',
        midscreen: '50vh',
        thirdscreen: '75vh',
      },
      minWidth: {
        '100': '100px',
        '250': '200px',
        '500': '500px',
      },
      minHeight: {
        '100': '100px',
        '250': '200px',
        '500': '500px',
      }
    },
    fill: theme => ({
      'primary': theme('colors.primary'),
      'secondary': theme('colors.secondary'),
      'mydark': theme('colors.mydark'),
      'success': theme('colors.success'),
      'warning': theme('colors.warning'),
      'error': theme('colors.error'),
      'info': theme('colors.info'),
    }),
    stroke: theme => ({
      'primary': theme('colors.primary'),
      'secondary': theme('colors.secondary'),
      'mydark': theme('colors.mydark'),
      'success': theme('colors.success'),
      'warning': theme('colors.warning'),
      'error': theme('colors.error'),
      'info': theme('colors.info'),
    }),
    textIndent: { // defaults to {}
      '1': '0.25rem',
      '2': '0.5rem',
    },
    textShadow: { // defaults to {}
      'default': '0 2px 5px rgba(0, 0, 0, 0.5)',
      'lg': '0 2px 10px rgba(0, 0, 0, 0.5)',
    },
    fontVariantCaps: { // defaults to these values
      'normal': 'normal',
      'small': 'small-caps',
      'all-small': 'all-small-caps',
      'petite': 'petite-caps',
      'unicase': 'unicase',
      'titling': 'titling-caps',
    },
    fontVariantNumeric: { // defaults to these values
      'normal': 'normal',
      'ordinal': 'ordinal',
      'slashed-zero': 'slashed-zero',
      'lining': 'lining-nums',
      'oldstyle': 'oldstyle-nums',
      'proportional': 'proportional-nums',
      'tabular': 'tabular-nums',
      'diagonal-fractions': 'diagonal-fractions',
      'stacked-fractions': 'stacked-fractions',
    },
    fontVariantLigatures: { // defaults to these values
      'normal': 'normal',
      'none': 'none',
      'common': 'common-ligatures',
      'no-common': 'no-common-ligatures',
      'discretionary': 'discretionary-ligatures',
      'no-discretionary': 'no-discretionary-ligatures',
      'historical': 'historical-ligatures',
      'no-historical': 'no-historical-ligatures',
      'contextual': 'contextual',
      'no-contextual': 'no-contextual',
    },
    textRendering: { // defaults to these values
      'rendering-auto': 'auto',
      'optimize-legibility': 'optimizeLegibility',
      'optimize-speed': 'optimizeSpeed',
      'geometric-precision': 'geometricPrecision'
    },
    textStyles: theme => ({ // defaults to {}
      heading: {
        output: false, // this means there won't be a "heading" component in the CSS, but it can be extended
        fontWeight: theme('fontWeight.bold'),
        lineHeight: theme('lineHeight.tight'),
      },
      h1: {
        extends: 'heading', // this means all the styles in "heading" will be copied here; "extends" can also be an array to extend multiple text styles
        fontSize: theme('fontSize.4xl'),
        '@screen sm': {
          fontSize: theme('fontSize.5xl'),
        },
      },
      h2: {
        extends: 'heading',
        fontSize: theme('fontSize.3xl'),
        '@screen sm': {
          fontSize: theme('fontSize.4xl'),
        },
      },
      h3: {
        extends: 'heading',
        fontSize: theme('fontSize.2xl'),
      },
      h4: {
        extends: 'heading',
        fontSize: theme('fontSize.2xl'),
      },
      h5: {
        extends: 'heading',
        fontSize: theme('fontSize.xl'),
      },
      h6: {
        fontSize: theme('fontSize.xl'),
      },
      link: {
        fontWeight: theme('fontWeight.bold'),
        color: '#DB4E60',
        '&:hover': {
          color: theme('colors.primary'),
          textDecoration: 'underline',
        },
      },
      richText: {
        fontWeight: theme('fontWeight.normal'),
        fontSize: theme('fontSize.base'),
        lineHeight: theme('lineHeight.relaxed'),
        '> * + *': {
          marginTop: '1em',
        },
        'h1': {
          extends: 'h1',
        },
        'h2': {
          extends: 'h2',
        },
        'h3': {
          extends: 'h3',
        },
        'h4': {
          extends: 'h4',
        },
        'h5': {
          extends: 'h5',
        },
        'h6': {
          extends: 'h6',
        },
        'ul': {
          listStyleType: 'square',
          padding: '0.5rem 1rem'
        },
        'ol': {
          listStyleType: 'decimal',
        },
        'a': {
          extends: 'link',
        },
        'b, strong': {
          fontWeight: theme('fontWeight.bold'),
        },
        'i, em': {
          fontStyle: 'italic',
        },
      },
    }),
  },
  variants: { // all the following default to ['responsive']
    textIndent: ['responsive'],
    textShadow: ['responsive'],
    ellipsis: ['responsive'],
    hyphens: ['responsive'],
    kerning: ['responsive'],
    textUnset: ['responsive'],
    fontVariantCaps: ['responsive'],
    fontVariantNumeric: ['responsive'],
    fontVariantLigatures: ['responsive'],
    textRendering: ['responsive'],

    textColor: ['responsive', 'hover', 'focus', 'group-hover'],
    opacity: ['responsive', 'hover', 'focus', 'active', 'group-hover'],


    transitionProperty: ['responsive'],
    transitionDuration: ['responsive'],
    transitionTimingFunction: ['responsive'],
    transitionDelay: ['responsive'],
    willChange: ['responsive'],


  },
  plugins: [
    require('tailwindcss-animatecss')({
      settings: {
        animatedSpeed: 1000,
        heartBeatSpeed: 1000,
        hingeSpeed: 2000,
        bounceInSpeed: 750,
        bounceOutSpeed: 750,
        animationDelaySpeed: 1000
      },
      variants: ['responsive'],
    }),
    require('tailwindcss-typography')({
      // all these options default to the values specified here
      ellipsis: true,         // whether to generate ellipsis utilities
      hyphens: true,          // whether to generate hyphenation utilities
      kerning: true,          // whether to generate kerning utilities
      textUnset: true,        // whether to generate utilities to unset text properties
      componentPrefix: 'c-',  // the prefix to use for text style classes
    }),
  ],
}