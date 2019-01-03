/**
 * title : doc title
 * isAuth : is or isn't check userInfo
 * loginCallBackUrl
 * The page is expected to jump the module;
 * disabled module: actives  advisor logRe
 * extendModules:[]
 * header: default false
 * headerRegist: default false
 * menuLeft: default false
 * footer: default false
 */
module.exports = [
  /**
   * 默认
   */
  {
    path: '*',
    name: 'default',
    redirect: '/login'
  },
  /**
   * 登录首页
   */
  {
    path: '/login',
    name: 'login',
    meta: {
      isAuth: false,
      header: true,
      footer: true,
      extendModules: []
    },
    component: (resolve) => require(['@/views/home/login'], resolve)
  }, {
    path: '/home',
    name: 'home',
    meta: {
      isAuth: false,
      header: true,
      footer: true,
      extendModules: []
    },
    component: (resolve) => require(['@/views/home/home'], resolve)
  },


];

