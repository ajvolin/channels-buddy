require('./bootstrap');

import 'bootstrap'
import Vue from 'vue'
import VueMeta from 'vue-meta'
import VTooltip from 'v-tooltip'
import { BootstrapVue } from 'bootstrap-vue'
import { App, plugin } from '@inertiajs/inertia-vue'
import route from 'ziggy-js'
import MainLayout from './layouts/MainLayout.vue'

Vue.config.productionTip = false;
Vue.mixin({
    methods: {
        route: (name, params, absolute, config = Ziggy) => route(name, params, absolute, config)
    }
})
Vue.use(VTooltip)
Vue.use(plugin)
Vue.use(VueMeta)
Vue.use(BootstrapVue)

// Register global components
const requireComponents = require.context('./components', true, /[A-Z]\w+\.(vue|js)$/)
requireComponents.keys().forEach(component => {
    const componentConfig = requireComponents(component)

    // Get component name in PascalCase 
    const componentName = _.upperFirst(
        _.camelCase(
          // Gets the file name regardless of folder depth
            component
                .split('/')
                .pop()
                .replace(/\.\w+$/, '')
        )
    )

    // Register component with Vue
    Vue.component(componentName, componentConfig.default || componentConfig)
})

Vue.prototype.$router = 'fake'

let app = document.getElementById('app');
new Vue({
    metaInfo: {
        titleTemplate: (title) => title ? `${title} - ` + app_name : app_name
    },
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => import(/* webpackChunkName: "[request]" */ `./pages/${name}`)
                                    .then(module => {
                                        if(!module.default.layout) {
                                              module.default.layout = MainLayout;
                                            }
                                            return module.default;
                                    }),
        },
    }),
}).$mount(app)