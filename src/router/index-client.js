import Vue from 'vue'
import Router from 'vue-router'
import methods from '@/util/view-client'
import * as constant from '@/util/constant'

Vue.use(Router);

// function layout (resolve, routString, sign) {
//   if (!resolve || !routString) {
//     console.log('resolve or router is not empty!')
//     return null
//   }
//   let reqPath = require(`@/${routString}`)
//   return sign ? require.ensure([], () => {
//     resolve(reqPath)
//   }, sign) : require.ensure([], () => {
//     resolve(reqPath)
//   })
// }

/**
 * title : doc title
 * isAuth : is or isn't check userInfo
 * header default true
 * footer default false
 * keepAlive  is or not cached ex watch $route
 */
export function createRouter(routerPaths) {
    let router = new Router({
        mode: 'history',
        fallback: false,
        scrollBehavior(to, form, savePostion) {
            if (savePostion) {
                return savePostion;
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
        //router.app.$loading.setLoading(true);
        let meta = to.meta;

        //登录权限检查
        if (meta.isAuth && !methods.sessionGetItem('userInfo')) {
            window.location.replace(`/login`);
            return;
        }

        if (methods.sessionGetItem('userInfo') && methods.sessionGetItem('userInfo').custOpenProcess && '0' !== methods.sessionGetItem('userInfo').custOpenProcess.process) {
            let path = constant.CustOpenProcess[methods.sessionGetItem('userInfo').custOpenProcess.process];
            if(to.path.indexOf('/viewPdf/') == -1){
                if (path !== to.path) {
                    window.location.replace(path);
                    return;
                }
            }

        }
        if (methods.sessionGetItem('userInfo') &&  methods.sessionGetItem('userInfo').custOpenProcess && '0' === methods.sessionGetItem('userInfo').custOpenProcess.process) {
            //首次登录检查
            if (methods.sessionGetItem('userInfo').sysUserInfo &&
                (methods.sessionGetItem('userInfo').sysUserInfo.loginInitFlag == '1' || methods.sessionGetItem('userInfo').sysUserInfo.isHasTradePassword != '1')) { //设置交易密码
                if (constant.Router.setPwd != to.path) {
                    window.location.replace(constant.Router.setPwd);
                    return;
                }
            } else if (methods.sessionGetItem('userInfo').custInfo &&
                (methods.sessionGetItem('userInfo').custInfo.custRiskLevel == '' || methods.sessionGetItem('userInfo').custInfo.custRiskLevel == null || methods.sessionGetItem('userInfo').custInfo.testMaturity < methods.formatDate(new Date(), 'yyyyMMdd'))) { //风险测评检查
                if (constant.Router.riskTest != to.path) {
                    window.location.replace(constant.Router.riskTest);
                    return;
                }
            } else if (to.path === "/login") {
                let path = constant.CustOpenProcess[methods.sessionGetItem('userInfo').custOpenProcess.process];
                if (path !== to.path) {
                    window.location.replace(path);
                    return;
                }
            }
        }

        //角色权限检查
        let roleList = methods.getRoleRule();
        if (meta.roleList && meta.roleList.length) {
            let visit = false;
            meta.roleList.forEach((item, index) => {
                if (roleList[item]) {
                    visit = true;
                }
            });
            if (!visit) {
                window.location.replace(constant.Router.roleForbid);
                return;
            }
        }

        let store = router.app.$store;
        let header = typeof meta.header !== 'undefined' && meta.header;
        let headerRegist = typeof meta.headerRegist !== 'undefined' && meta.headerRegist;
        let footer = typeof meta.footer !== 'undefined' && meta.footer;
        let menuLeft = typeof meta.menuLeft !== 'undefined' && meta.menuLeft;
        let routerPath = typeof to.path !== 'undefined' && to.path;
        store.commit('SET_ROUTE', to);
        store.commit('SET_HEADER', header);
        store.commit('SET_HEADERREGIST', headerRegist);
        store.commit('SET_FOOTER', footer);
        store.commit('SET_MENULEFT', menuLeft);
        store.commit('SET_ROUTERPATH', routerPath);
        if (meta.extendModules && meta.extendModules.length) {
            let routerServer = [];
            let server = window.__INITIAL_STATE__.routerServer || [];
            meta.extendModules.map(item => {
                if (server.indexOf(item) < 0 && store.state.extendModules.indexOf(item) < 0) {
                    store.commit('EXTEND_MODULES', item);
                    routerServer = routerServer.concat(require('./' + item));
                }
            });
            if (routerServer.length) {
                router.addRoutes(routerServer);
            }
        }
        // if (from.fullPath === to.fullPath) {
        //   router.back()
        //   return false
        // }
        // window.__INITIAL_STATE__.routerServer = window.__INITIAL_STATE__.routerServer || meta.extendModules || []
        next();
    });

    return router;
}
