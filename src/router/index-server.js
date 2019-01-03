import Vue from 'vue'
import Router from 'vue-router'
import app_routers from './app-routers'

Vue.use(Router);

/**
 * title : doc title
 * isAuth : is or isn't check userInfo
 * header default true
 * footer default false
 * keepAlive  is or not cached ex watch $route
 */
export function createRouter() {
    let routerPaths = [].concat(app_routers);
    let router = new Router({
        mode: 'history',
        fallback: false,
        scrollBehavior(to, form, savePostion) {
            if (savePostion) {
                return savePostion
            } else {
                return {
                    x: 0,
                    y: 0
                }
            }
        },
        routes: routerPaths
    });
    router.beforeEach((to, from, next) => {
        let store = router.app.$store;
        let meta = to.meta;
        let header = typeof meta.header !== 'undefined' && meta.header;
        let headerRegist = typeof meta.headerRegist !== 'undefined' && meta.headerRegist;
        let footer = typeof meta.footer !== 'undefined' && meta.footer;
        let menuLeft = typeof meta.menuLeft !== 'undefined' && meta.menuLeft;
        let routerPath = typeof to.path !== 'undefined' && to.path;
        store.commit('SET_HEADER', header);
        store.commit('SET_HEADERREGIST', headerRegist);
        store.commit('SET_FOOTER', footer);
        store.commit('SET_MENULEFT', menuLeft);
        store.commit('SET_ROUTERPATH', routerPath);
        next();
    });
    return router;
}
