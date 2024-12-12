import './bootstrap';
import '../css/app.css';

//standaard layout van website
import AppLayout from './Shared/layout/AppLayout.vue';

import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    const page = pages[`./Pages/${name}.vue`];

    // Stel de standaard layout in als er geen is gespecificeerd
    page.default.layout = page.default.layout || AppLayout;
    return page;

  },
  setup({ el, App, props, plugin }) {
    //creër de vue app
    const app = createApp({ render: () => h(App, props) })
      app.use(plugin)
      app.use(ZiggyVue)
      //components voor elke site
      app.component('Link', Link)
      app.component('Head', Head)
      app.mount(el)
  },
})