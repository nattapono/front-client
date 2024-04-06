// https://nuxt.com/docs/api/configuration/nuxt-config
require('dotenv').config();
export default {
    mode: 'universal',
    app: {
        head: {
            charset: 'utf-8',
            viewport: 'width=device-width,initial-scale=1,user-scalable=0',
            title: "madam clean ",
            meta: [
                { name: "description" }
            ],
            link: [
                {
                    rel: 'icon',
                    type: 'image/png',
                    href: './assets/images/logomdc.png'
                },
            ],
            script: [
                {
                    src: "/ckeditor/ckeditor.js",
                    type: "text/javascript",
                },
                {
                    src:"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js",
                    type: "text/javascript",
                },
                {
                    src: "./assets/js/bootstrap.bundle.min.js",
                    type: "text/javascript",
                },
            ]
        },
        link: [
            {
                rel: 'icon',
                type: 'image/png',
                href: 'public/assets/images/logomdc.png'
            },
            {
                rel: 'stylesheet',
                href: 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css',
            },
            {
                rel: 'stylesheet',
                href: 'https://fonts.googleapis.com/css2?family=Kanit:wght@200&display=swap',
            },
            {
                rel: "stylesheet",
                href: "https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css",
                integrity: "sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N",
                crossorigin: "anonymous"
            }
        ],
        script: [
            {
                src: "./ckeditor/ckeditor.js",
                type: "text/javascript",
            },
            {
                src: "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js",
                type: "text/javascript",
            },
            {
                src: "https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js",
                integrity: "sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj",
                crossorigin: "anonymous"
            },
            {
                src: "https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js",
                integrity: "sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct",
                crossorigin: "anonymous"
            },
            {
                 src:"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js",
                 type: "text/javascript",
            },
            // fontawesome Pro front-dashboard
            { src: 'https://kit.fontawesome.com/d45e7e578e.js', crossorigin: 'anonymous' },
        ],
        plugins: [

        ],
        modules: ['@nuxtjs/axios'],
        axios: {
            proxy: true
        },
        buildModules: [
            '@nuxtjs/tailwindcss',
        ],
        vite: {
            ssr: false, // ปิดการใช้งาน Vite SSR mode
        },
        env: {
            BASE_API: process.env.BASE_API,
            VITE_API_BASE_URL: process.env.VITE_API_BASE_URL,
            DEBUG: process.env.DEBUG
        },
        Proxy: {
            '/api/': {
                target: process.env.BASE_API,
                changeOrigin: true
            },
            '/imgPath/': {
                target: process.env.BASE_API_IMAGE_PATH,
                changeOrigin: true
            }
        }
    },
    nitro: {
        devProxy: {
            '/api/': {
                target: process.env.BASE_API,
                changeOrigin: true
            },
            '/imgPath/': {
                target: process.env.BASE_API_IMAGE_PATH,
                changeOrigin: true
            }
        }

    },
}
