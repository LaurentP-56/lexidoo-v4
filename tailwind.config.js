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
            'red':{
                50: '#fef2f2',
                100: '#fee2e2',
                200: '#fecaca',
                300: '#fca5a5',
                400: '#f87171',
                500: '#ef4444',
                600: '#dc2626',
                700: '#b91c1c',
                800: '#991b1b',
                900: '#7f1d1d',
                950: '#450a0a',
            },
            'teal':{
                50: '#f0fdfa',
                100: '#ccfbf1',
                200: '#99f6e4',
                300: '#5eead4',
                400: '#2dd4bf',
                500: '#14b8a6',
                600: '#0d9488',
                700: '#0f766e',
                800: '#115e59',
                900: '#134e4a',
                950: '#042f2e',
            },
            'sky':{
                50:   '#f0f9ff',
                100:  '#e0f2fe',
                200:  '#bae6fd',
                300:  '#7dd3fc',
                400:  '#38bdf8',
                500:  '#0ea5e9',
                600:  '#0284c7',
                700:  '#0369a1',
                800:  '#075985',
                900:  '#0c4a6e',
                950:  '#082f49',
            },
            colors: {
                'blue': '#1fb6ff',
                'purple': '#7e5bef',
                'pink': '#ff49db',
                'orange': '#ff7849',
                'green': '#13ce66',
                'yellow': '#ffc82c',
                'gray-dark': '#273444',
                'gray': '#8492a6',
                'gray-light': '#d3dce6',
                'gray-600':'#4b5563',
                'Teal': '#14b8a6',
                'teal-700': '#0f766e',
                'indigo-500':'#6366f1',
                'sky-500': '#0ea5e9',
                'sky-100':'#e0f2fe',
                'sky-200':'#bae6fd',
                'emeral-500': '#10b981',
                'white': '#ffffff',
                'white30': '#ffffff30',
            },
        },
    },
        variants: {
            extend: {
                backgroundColor: ['active'],
            }
        },
  },
  plugins: [
      require('@tailwindcss/forms'),

  ],
}

