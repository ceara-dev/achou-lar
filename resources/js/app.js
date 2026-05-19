import './bootstrap';
import './echo';
import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        const ziggy = typeof window !== 'undefined' ? window.Ziggy : {};

        app.use(plugin)
            .use(ZiggyVue, ziggy)
            .mount(el);
    },
});
