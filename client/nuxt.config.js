import colors from 'vuetify/es5/util/colors'

export default {
  // Disable SSR
  ssr: false,
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    htmlAttrs: {
      lang: 'ru-RU',
      translate: 'no',
    },
    titleTemplate: 'ИТ-Фича',
    title: 'ИТ-Фича',
    meta: [
      { charset: 'utf-8' },
      // Основные meta теги
      { name: 'viewport',         hid: 'viewport',         content: `width=device-width, initial-scale=1` },
      { name: 'description',      hid: 'description',      content: `ИТ-фича система международного биллинга.` },
      { name: 'keywords',         hid: 'keywords',         content: `платежи банкинг` },
      { name: 'author',           hid: 'author',           content: `Олег Бахтадзе-Карнаухов` },
      { name: 'format-detection', hid: 'format-detection', content: `telephone=no` },
      { name: 'google',           hid: 'google',           content: `notranslate` },
      { name: 'theme-color',      hid: 'theme-color',      content: `#7450e7` },
      // The Open Graph protocol meta tags
      { property: 'og:locale',        hid: 'og:locale',        content: `ru_RU` },
      { property: 'og:image',         hid: 'og:image',         content: `${ process.env.HOST || `http://localhost` }/open-graph-logo.png` },
      { property: 'og:site_name',     hid: 'og:site_name',     content: `UNIAPP` },
      { property: 'og:type',          hid: 'og:type',          content: `website` },
      { property: 'og:url',           hid: 'og:url',           content: (process.env.HOST || `http://localhost`) },
      { property: 'og:title',         hid: 'og:title',         content: `ИТ-фича` },
      { property: 'og:description',   hid: 'og:description',   content: `ИТ-фича система международной оплаты.` },
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    '~/assets/config.scss'
  ],

  // Правила Robots.txt
  robots: {
    UserAgent: '*',
    Disallow: '/admin/',
    Sitemap: '/sitemap.xml'
  },

  // Настройки карты сайта
  sitemap: {
    hostname: (process.env.HOST || `http://localhost`),
    gzip: true,
    exclude: [
        '/admin/**',
        '/manager/**'
    ],
  },

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    { src: '@plugins/v-axios.js'},
    { src: '@plugins/v-mask.js'},
    { src: '@plugins/v-masonry', ssr: false },
    { src: '@plugins/v-card.js', mode: 'client' }

  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: [
    '~/components',
    { path: '~/components/Interface', extensions: ['vue'] },
    { path: '~/components/Auth', extensions: ['vue'] },
    { path: '~/components/Card', extensions: ['vue'] },
    { path: '~/components/Wallet', extensions: ['vue'] },
    { path: '~/components/History', extensions: ['vue'] }
  ],

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify',
    '@nuxtjs/moment',
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    // https://auth.nuxtjs.org/
    '@nuxtjs/auth-next',
    // https://go.nuxtjs.dev/pwa
    '@nuxtjs/pwa',
    // https://www.npmjs.com/package/@nuxtjs/yandex-metrika
    '@nuxtjs/yandex-metrika',
    // https://www.npmjs.com/package/@nuxtjs/robots
    '@nuxtjs/robots',
    // https://sitemap.nuxtjs.org/
    '@nuxtjs/sitemap',
  ],

  // Конфигурация momentjs
  moment: {
    defaultLocale: 'ru',
    locales: ['ru']
  },

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    baseURL: (process.env.URL || 'http://localhost') + '/api/'
  },

  // Auth Options
  auth: {
    redirect: {
      login: "/auth/signin",
      logout: "/",
      home: "/campaign",
      // callback: "/login",
    },
    strategies: {
      local: {
        token: {
          property: 'data.access_token',
          type: 'Bearer'
        },
        user: {
          property: 'data'
        },
        endpoints: {
          login:  { url: 'user/login',  method: 'post' },
          user:   { url: 'user/me',     method: 'post' },
          logout: { url: 'user/logout', method: 'post' },
        },
        tokenRequired: true,
      }
    }
  },

  // PWA module configuration: https://go.nuxtjs.dev/pwa
  pwa: {
    manifest: {
      lang: 'ru'
    }
  },

  // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
  vuetify: {
    customVariables: ['~/assets/variables.scss'],
    theme: {
      dark: true,
      themes: {
        dark: {
          primary: '#7595ff',//colors.blue.darken2,
          accent: colors.grey.darken3,
          secondary: '#F3F3F3',//colors.amber.darken3,
          info: colors.teal.lighten1,
          warning: colors.amber.base,
          error: '#E2251D',//colors.deepOrange.accent4,
          success: '#297E37',//colors.green.accent3
        }
      }
    }
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
