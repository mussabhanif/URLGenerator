import './bootstrap';
import '../css/app.css';
import "vuetify/styles";
import "@mdi/font/css/materialdesignicons.css";
import "sweetalert2/dist/sweetalert2.min.css";
import "vue-toastification/dist/index.css";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import vuetify from './plugins/vuetify';
import { createPinia } from 'pinia';
import VueSweetalert2 from "vue-sweetalert2";
import Toast from "vue-toastification";


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const pinia = createPinia();
        const toastOptions = {
            transition: "Vue-Toastification__bounce",
            maxToasts: 20,
            newestOnTop: true,
            position: "top-right",
            timeout: 5000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false
        };
        const vueApp = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(vuetify)
            .use(pinia)
            .use(Toast, toastOptions)
            .use(VueSweetalert2);
            vueApp.mount(el);
            return vueApp
    },
    progress: {
        color: '#4B5563',
    },
});
