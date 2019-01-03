import {createApp} from './main-server'

const isDev = process.env.NODE_ENV !== 'production';

function asyncuserInfo({store, route = {}, cookie}) {
    return store.dispatch('USER_INFO', cookie);
}

// This exported function will be called by `bundleRenderer`.
// This is where we perform data-prefetching to determine the
// state of our application before actually rendering it.
// Since data fetching is async, this function is expected to
// return a Promise that resolves to the app instance.
export default context => {
    return new Promise((resolve, reject) => {
        const s = isDev && Date.now();
        const {app, router, store} = createApp();

        const {url, routerPathsObj, routerPaths} = context;
        const {fullPath, matched, meta} = router.resolve(url).route;
        if (fullPath !== url) {
            return reject({url: fullPath})
        }
        // not token cookie
        if (!context.cookie.token && meta.isAuth) {
            console.log("not token cookie",meta.loginCallBackUrl,fullPath);
            //return reject({url: `/login?loginbackurl=${meta.loginCallBackUrl || fullPath}`});
        }
        store.state.cookie = context.cookie;
        // GET CURRENT ROUT CONGIG MODEL
        if (matched.length === 0) { // store.state.routerServer
            return reject({url: '/'});
        }
        let routpath = matched[0].path || '/';
        let modulesName = [];
        //console.log('matched[0].path', matched, routpath, routerPathsObj, routerPathsObj[routpath], meta.extendModules);

        if (routerPathsObj[routpath]) {
            modulesName.push(routerPathsObj[routpath]);
            // modulesName = modulesName.concat(routerPaths[routerPathsObj[routpath]])
            if (meta.extendModules instanceof Array) {
                modulesName = modulesName.concat(...meta.extendModules);
                // meta.extendModules.map(item => {
                //   modulesName = modulesName.concat(routerPaths[item])
                // })
            }
        }
        store.state.routerServer = modulesName;
        // set router's location
        router.push(url);

        // wait until router has resolved possible async hooks
        router.onReady(() => {
            const matchedComponents = router.getMatchedComponents();
            // no matched routes
            if (!matchedComponents.length) {
                return reject({code: 404});
            }
            // Call fetchData hooks on components matched by the route.
            // A preFetch hook dispatches a store action and returns a Promise,
            // which is resolved when the action is complete and store state has been
            // updated.
            let matArry = [];
            /*let matArry = (url.split('?')[0].match(/\/error\/(404|500)/) || url === '/login') ? [] : [asyncuserInfo({
                store,
                route: router.currentRoute,
                cookie: context.cookie
            })];*/
            let macthComs = matchedComponents.map(({asyncData}) => asyncData && asyncData({
                store,
                cookie: context.cookie,
                route: router.currentRoute
            }));
            if (macthComs && macthComs.filter(item => item).length !== 0) {
                matArry = matArry.concat(macthComs);
            }
            // let matArry = matchedComponents.map(({asyncData}) => asyncData && asyncData({
            //   store,
            //   route: router.currentRoute
            // }))
            // console.log('matchedComponents',matchedComponents)
            Promise.all(matArry).then((data) => {
                if (router.currentRoute.meta.isAth && data.filter(item => {
                        if (item instanceof Array) {
                            return item.filter(citem => citem.head.code === 'AUTHORIZED_ERROR').length !== 0;
                        } else {
                            return item.head.code === 'AUTHORIZED_ERROR';
                        }
                    }).length !== 0) {
                    console.log("令牌失效");

                    return reject({
                        code: 'AUTHORIZED_ERROR',
                        url: `/login?loginbackurl=${meta.loginCallBackUrl || fullPath}`,
                        message: 'user is not login'
                    });
                }
                isDev && console.log(`data pre-fetch: ${Date.now() - s}ms`);
                // After all preFetch hooks are resolved, our store is now
                // filled with the state needed to render the app.
                // Expose the state on the render context, and let the request handler
                // inline the state in the HTML response. This allows the client-side
                // store to pick-up the server-side state without having to duplicate
                // the initial data fetching on the client.
                context.state = store.state;
                // console.log('store.state',store.state)
                resolve(app);
            }).catch(reject);
        }, reject);
    })
}
