export default {
    SET_HEADER(state, status) {
        state.header = status;
    },
    SET_HEADERREGIST(state, status) {
        state.headerRegist = status;
    },
    SET_FOOTER(state, status) {
        state.footer = status;
    },
    PAGE_TITLE(state, title) {
        state.pageTitle = title;
    },
    SET_USER_INFO (state, data) {
        state.userInfo = data
    },
    SERVER_DATA(state, data) {
        if (data.data){
            state.serverData[data.key] = data.data;
        } else{
            state.serverData[data.key] = data;
        }
    },
    ALREADY_URLS(state, urlKey) {
        state.alreadyUrls[urlKey] = true;
    },
    /**
     * 通过单页切换，已经获取的路由
     * @param state
     * @param routArr
     * @constructor
     */
    EXTEND_MODULES(state, routArr) {
        if (state.extendModules.indexOf(routArr) < 0) {
            state.extendModules.push(routArr);
        }
    },
    SET_ROUTE(state, {fullPath, hash, meta, name, params, path, query}) {
        state.myroute = {
            fullPath,
            hash,
            meta,
            name,
            params,
            path,
            query
        };
    },
    SET_MENULEFT(state, menuLeft) {
        state.menuLeft = menuLeft;
    },
    SET_ROUTERPATH(state, routerPath) {
        state.routerPath = routerPath;
    },
    SET_FUNDDETAILSTYPE(state, fundDetailsType) {
        state.fundDetailsType = fundDetailsType;
    }
    
}
