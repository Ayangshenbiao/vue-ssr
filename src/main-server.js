import Vue from 'vue'
// import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-chalk/index.css';
// import Avue from '@smallwei/avue';
// import '@smallwei/avue/lib/theme-chalk/index.css';
import App from './App.vue'
import {createStore} from './store'
import {createRouter} from './router/index-server'
import {sync} from 'vuex-router-sync'
import methodsMixin from '@/util/view-server'
import titleMixin from './util/pageConfig'
import * as filters from './util/filters'

// use for external plug-in
// Vue.use(Avue);
// Vue.use(ElementUI);

// mixin for handling title
Vue.mixin(titleMixin);
Vue.mixin(methodsMixin);

// regist global utility filters.
Object.keys(filters).forEach(key => {
    Vue.filter(key, filters[key]);
});

// Expose a factory function that creates a fresh set of store, router,
// app instances on each call (which is called for each SSR request)
export function createApp() {
    // create store and router instances
    const store = createStore();
    const router = createRouter();

    // sync the router with the vuex store.
    // this registers `store.state.route`
    sync(store, router);

    // import 'vue-easytable/libs/themes-base/index.css'
    // import {VTable,VPagination} from 'vue-easytable'
    // create the app instance.
    // here we inject the router, store and ssr context to all child components,
    // making them available everywhere as `this.$router` and `this.$store`.
    const app = new Vue({
        router,
        store,
        render: h => h(App)
    });

    // expose the app, the router and the store.
    // note we are not mounting the app here, since bootstrapping will be
    // different depending on whether we are in a browser or on the server.
    return {app, router, store};
}
