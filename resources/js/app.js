import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Layout from './Shared/Layout.vue'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import store from './store';

createInertiaApp({
    resolve: async (name) => {
        const page = resolvePageComponent(`./Pages/${name}.vue`, await import.meta.glob('./Pages/**/*.vue'))
        page.layout = page.layout || Layout
        return page

    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(store)
            .mixin({methods:{route:window.route}})
            .mount(el)
    },
})


