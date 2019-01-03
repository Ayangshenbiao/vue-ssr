import 'babel-polyfill'
import 'classlist-polyfill'
import 'html5-history-api'
import Vue from 'vue'
import 'es6-promise/auto'
import {createApp} from './main-client'
import methods from '@/util/view-client'


// a global mixin that calls `asyncData` when a route component's params change
function asyncuserInfo({store, route = {}}) {
    return store.dispatch('USER_INFO');
    // return store.dispatch('USER_INFOR').then(data => {
    //   if (data.head.returnCode === '04' && route.path !== '/login') {
    //     route.push({
    //       path: '/login',
    //       query: {
    //         loginbackurl: route.path
    //       }
    //     })
    //   }else{
    //     return data
    //   }
    // })
}

// resolve all cookie to json
function resolveCookie() {
    let cookies = {};
    document.cookie.split(';').map(item => {
        let tmp = item.split('=');
        cookies[tmp[0].replace(/(^\s*)/g, '')] = unescape(tmp[1]);
    });
    return cookies;
}

Vue.mixin({
    beforeRouteUpdate(to, from, next) {
        myNotice.setNotice(false);
        const {asyncData} = this.$options;
        if (asyncData) {
            asyncData({
                store: this.$store,
                route: to,
                cookie: resolveCookie()
            }).then(next).catch(next);
        } else {
            next();
        }
    },
    methods
});
// view public

const {app, router, store} = createApp();

// prime the store with server-initialized state.
// the state is determined during SSR and inlined in the page markup.
if (window.__INITIAL_STATE__) {
    store.replaceState(window.__INITIAL_STATE__);
}

// wait until router has resolved all async before hooks
// and async components...
router.onReady(() => {
    // checked userinfor status report error and init dictionaries
    // app.errorModus(store.getters['USER_INFOR_HEADER'])
    store.commit('SET_USER_INFO', methods.sessionGetItem('userInfo'));
    // error notice
    let errorMsg = store.getters['GET_SERVER_DATA']();
    for (let key in errorMsg) {
        if (errorMsg[key].msgStatus && errorMsg[key]) {
            app.errorModus(errorMsg[key]);
            break;
        }
    }
    // Add router hook for handling asyncData.
    // Doing it after initial route is resolved so that we don't double-fetch
    // the data that we already have. Using router.beforeResolve() so that all
    // async components are resolved.
    router.beforeResolve((to, from, next) => {
        //myloading.setLoading(true);
        store.commit('PAGE_TITLE', '...');
        const matched = router.getMatchedComponents(to);
        const prevMatched = router.getMatchedComponents(from);
        let diffed = false;
        const activated = matched.filter((c, i) => {
            return diffed || (diffed = (prevMatched[i] !== c));
        });
        let asyncDataHooks = activated.map(c => c.asyncData).filter(_ => _);
        if (to.path !== '/login' && !to.path.match(/\/error\/(404|500)/) && from.path !== '/login' && from.path !== '/realname') {
            //asyncDataHooks = [asyncuserInfo].concat(asyncDataHooks)
        }
        if (!asyncDataHooks.length) {
            //myloading.setLoading(false);
            return next();
        }
        bar.start();
        Promise.all(asyncDataHooks.map(hook => hook({store, route: to, cookie: resolveCookie()})))
            .then((data) => {
                if (to.meta.isAth && data.filter(item => {
                        if (item instanceof Array) {
                            return item.filter(citem => citem.code === 'AUTHORIZED_ERROR').length !== 0;
                        } else {
                            return item.code === 'AUTHORIZED_ERROR';
                        }
                    }).length !== 0) {
                    console.log("令牌失效");
                    router.push({
                        path: '/a',
                        query: {
                            loginbackurl: to.path
                        }
                    });
                }
                bar.finish();
                //myloading.setLoading(false);
                next();
            })
            .catch(next);
    });

    // actually mount to DOM
    app.$mount('#APP');
});

// service worker
if (location.protocol === 'https:' && navigator.serviceWorker) {
    navigator.serviceWorker.register('/service-worker.js');
}
