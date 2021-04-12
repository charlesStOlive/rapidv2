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
        danger: 'red',
        info: 'grey',
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
        'quarterscreen': '25vh',
        midscreen: '50vh',
        'thirdscreen': '75vh',

      }
    },
    fontFamily: {
      'sans': ['Raleway', 'Arial', 'sans-serif']
    },
    fill: theme => ({
      'primary': theme('colors.primary'),
      'secondary': theme('colors.secondary'),
      'mydark': theme('colors.mydark'),
      'white': theme('colors.white'),
      'success': theme('colors.success'),
      'warning': theme('colors.warning'),
      'error': theme('colors.error'),
      'info': theme('colors.info'),
    }),
    stroke: theme => ({
      'primary': theme('colors.primary'),
      'secondary': theme('colors.secondary'),
      'mydark': theme('colors.mydark'),
      'white': theme('colors.white'),
      'success': theme('colors.success'),
      'warning': theme('colors.warning'),
      'error': theme('colors.error'),
      'info': theme('colors.info'),
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
    require('@tailwindcss/typography'),
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
    require('@tailwindcss/custom-forms')

  ],
}