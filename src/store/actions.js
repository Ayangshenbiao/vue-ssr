import {post, get} from '@/api'
import * as api from '@/api/config-api'
import * as constant from '@/util/constant'

export default {
    /**
     *server data get And render
     * @param data json or json Array
     * @returns {Promise<any> | Promise.<TResult> | *}
     * @constructor
     */
    FETCH({commit, state, dispatch}, reqData) {
        let cookie = state.cookie || {};
        var app = this._vm;
        let client = typeof window !== 'undefined';
        // if page need login ,check session storage key userInfo
        let meta = state.myroute.meta || {};
        if (client && meta.isAuth && !app.sessionGetItem('userInfo')) {
            console.log("Client = " + client + ", IsAuth = " + meta.isAuth + ", UserInfo = " + app.sessionGetItem('userInfo') + " Jump To login");
            app.goPush(constant.Router.defualtNoUserInfoUserInfo, true);
        }

        if (api[reqData.urlKey].url === constant.Router.login && app.sessionGetItem('userInfo')) {
            console.log("Url = " + constant.Router.login + "已登录");
            app.goPush(constant.Router.defualtHasUserInfo, true)
        }

        function handleCatch(error) {
            if (client) {
                let message = (error && error.message) ? error.message : (typeof error === 'string' ? error : JSON.stringify(error));
                //app.$notice.setNotice(true, message);
            }
        }

        if (reqData instanceof Array) {
            let postArray = [];
            let keyArray = [];
            reqData.map(({urlKey = '', data = null, key = ''}, index) => {
                postArray.push(post(api[urlKey].url, data || null, cookie));
                keyArray.push(key || urlKey || `pagedata${index}`);
                commit('ALREADY_URLS', urlKey);
            });
            return Promise.all(postArray).then(data => {
                data.map((item, index) => {
                    let msgStatus = typeof reqData[index].msgStatus === 'undefined' || reqData[index].msgStatus;
                    if (client) {
                        // error
                        if (msgStatus) {
                            app.errorModus(item || {});
                        }
                        // login
                        if (item.code === 'AUTHORIZED_ERROR') {
                            commit('SET_USER_INFO', null);
                            app.clearApplication();

                            app.goPush(`/login`, true);
                            return false;
                        }
                    } else {
                        item.msgStatus = msgStatus;
                    }
                    if (item) {
                        return commit('SERVER_DATA', {key: keyArray[index], data: item});
                    }
                });
                return data;
            }).catch(error => {
                commit('SERVER_DATA', {key: 'error', data: error});
                handleCatch(error);
                return error;
            })
        } else {
            commit('ALREADY_URLS', reqData.urlKey);
            var postUrl = api[reqData.urlKey].url + '?timestamp=' + new Date().getTime() + Math.random();
            return post(postUrl, reqData.data || null, cookie).then((resdata) => {
                let msgStatus = typeof reqData.msgStatus === 'undefined' || reqData.msgStatus;
                if (client) {
                    // error
                    if (msgStatus) {
                        app.errorModus(resdata || {});
                    }
                    // login
                    if (resdata.code === 'AUTHORIZED_ERROR') {
                        //清缓存
                        commit('SET_USER_INFO', null);
                        app.clearApplication();

                        //跳转
                        app.goPush(`/login`, true);
                        return false;
                    }
                } else {
                    resdata.msgStatus = msgStatus;
                }
                commit('SERVER_DATA', {key: reqData.key || reqData.urlKey || 'pagedata', data: resdata});
                return resdata;
            }).catch(error => {
                commit('SERVER_DATA', {key: reqData.key || reqData.urlKey || 'pagedata', data: error});
                handleCatch(error);
                return error;
            })
        }
    },

    /**
     * user_info
     * @constructor
     */
    USER_INFO: ({commit, state}, cookie) => {
        return post(api.USER_INFO.url, null, cookie).then((data) => {
            if (data.code === '0000') {
                commit('SET_USER_INFO', data.data);
            } else {
                commit('SET_USER_INFO', null);
            }
            return data;
        })
    },
    /**
     * get请求
     */
    FETCH_GET: ({commit, state}, reqData) => {
        var url = '';
        for(var key in api){
            if(key = reqData.urlKey){
                url = api[key].url
            }
        }
        return get(url,reqData).then((res) => {
            return res.data;
        })
    },
}
