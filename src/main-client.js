import Vue from 'vue'
import App from './App.vue'
import {createStore} from './store'
import {createRouter} from './router/index-client'
import {sync} from 'vuex-router-sync'
import titleMixin from './util/pageConfig'
import * as filters from './util/filters'

/*轮播图组件*/
// import 'swiper/dist/css/swiper.css'
// import {swiper, swiperSlide} from 'vue-awesome-swiper'
// Vue.component("v-swiper", swiper);
// Vue.component("v-swiper-slide", swiperSlide);
// if (process.browser) {
//     const VueAwesomeSwiper = require('vue-awesome-swiper/dist/ssr')
//     Vue.use(VueAwesomeSwiper)
// }
/*日历组件*/
// import JDatePicker from 'vue-jlunar-datepicker';
// Vue.component("j-date-picker", JDatePicker);
/*表格组件*/
// import 'vue-easytable/libs/themes-base/index.css'
// import {VPagination} from 'vue-easytable'
// Vue.component('v-pagination', VPagination);

// mixin for handling title
Vue.mixin(titleMixin);
// regist global utility filters.
Object.keys(filters).forEach(key => {
    Vue.filter(key, filters[key]);
});

// Expose a factory function that creates a fresh set of store, router,
// app instances on each call (which is called for each SSR request)
export function createApp() {
    // create store and router instances
    const store = createStore();
    let routerServer = [];
    let serverrouterServer = window.__INITIAL_STATE__.routerServer;
    serverrouterServer.map(item => {
        routerServer = routerServer.concat(require('./router/' + item));
    });
    //console.log("serverrouterServer = " + serverrouterServer + ", routerServer = " + routerServer);
    const router = createRouter(routerServer);
    // console.log('store',JSON.stringify(router.options.routes))
    // sync the router with the vuex store.
    // this registers `store.state.route`
    sync(store, router);


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
