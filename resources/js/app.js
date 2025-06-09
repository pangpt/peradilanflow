import './bootstrap';
import * as bootstrap from 'bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from "ziggy-js";

createInertiaApp({
    title: title => `${title} - Laravelflow`,
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .mount(el)
  },
  progress: {
    delay: 250,
    color: '#29d',
    includeCSS: true,
    showSpinner: true,
  },
})