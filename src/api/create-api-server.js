const isProd = process.env.NODE_ENV === 'production';
const path = require('path');
const axios = require('axios');
const qs = require('querystring');
const util = require("util")
let fileName = path.basename(__filename);
let {PORT_OUT_TIME} = require('../messages');
let NETWORKCODE = require('../messages/networkCode');
let {logErr, logInfo} = require('../../log4');
let api;
let {getConfigServer} = require('../config/config-server');
let configServer = getConfigServer(process.env.NODE_ENV);

let host = configServer.host;
let netNo = configServer.netNo;

axios.defaults.baseURL = host;
axios.defaults.timeout = 10000;

axios.interceptors.response.use((res) => {
  if (res.status >= 200 && res.status < 300) {
    return res;
  }
  return Promise.reject(res);
}, (error) => {
  console.log(NETWORKCODE,'NETWORKCODE')
  let errMsg = error.toString();
  let code = errMsg.substr(errMsg.indexOf('code') + 5);
  let message = (NETWORKCODE[code] || NETWORKCODE['default']).toString();
  let tmp = {
    message: message,
    code: Number(code),
  };
  // 网络异常
  return tmp;
  // return Promise.reject(error);
});
if (process.__API__) {
  api = process.__API__;
} else {
  api = {
    get: function (target, options = {}, {token = '', tokenkey = ''}) {
      return new Promise((resolve, reject) => {
        axios.request({
          url: target,
          method: 'get',
          params: options
        }).then(res => {
          resolve(res.data);
        }).catch((error) => {
          reject(error);
        });
      });
    },
    post: function (target, options = {}, sign = {}) {
      let reqTime = new Date();
      options = options || {};
      /**
       * 自定义验证参数（浏览器控制台无法查看，提高安全性）
       */
      // options.netNo = netNo;
      // options.token = sign.token || '';
      // options.appversion = options.appversion || 'v1.0';
      return new Promise((resolve, reject) => {
        axios.request({
          url: target,
          method: 'post',
          data: options
        }).then(res => {
          logInfo(fileName, 'SEND_END', target, reqTime, options, res.data);
          resolve(res.data);
        }).catch((error) => {
          logErr(fileName, 'SEND_END', target, reqTime, options, error);
          reject(error);
        });
      });
    }
  }
}

module.exports = api;
