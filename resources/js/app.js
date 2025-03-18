import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import registerGlobalComponents from './global';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import 'vue-toast-notification/dist/theme-sugar.css';

import Toast from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(ToastPlugin);
        app.use(Toast, {
            position: 'top-right',
            autoClose: 3000,
            closeOnClick: true,
            draggable: true,
            pauseOnHover: true,
            theme: 'colored',
        });

        app.use(plugin)
           .use(ZiggyVue);

        registerGlobalComponents(app);

        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
