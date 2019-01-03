const path = require('path');
const axios = require('axios');
let {PORT_OUT_TIME} = require('../messages');
let api;
axios.defaults.timeout = 10000;
axios.interceptors.response.use((res) => {
    if (res.status >= 200 && res.status < 300) {
        return res;
    }
    return Promise.reject(res);
}, (error) => {
    // 网络异常
  return Promise.reject({message: PORT_OUT_TIME, err: error});
});

if (process.__API__) {
    api = process.__API__;
} else {
    api = {
        get: function (target, params = {}) {
            const suffix = Object.keys(params).map(name => {
                return `${name}=${JSON.stringify(params[name])}`;
            }).join('&');
            const urls = `${target}?${suffix}`;
            return new Promise((resolve, reject) => {
                axios.get(urls, params).then(res => {
                    resolve(res.data);
                }).catch((error) => {
                    reject(error);
                })
            });
        },
        post: function (target, options = {}) {
            return new Promise((resolve, reject) => {
                axios.post(target, options).then(res => {
                    resolve(res.data);
                }).catch((error) => {
                    reject(error);
                });
            });
        }
    }
}

module.exports = api;