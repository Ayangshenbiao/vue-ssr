import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import mutations from './mutations'
import getters from './getters'
import * as messages from '@/messages/index'
import form from './modules/form'

Vue.use(Vuex);

export function createStore() {
  return new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    state: {
      userInfo: null,
      header: false,
      headerRegist: false,
      menuLeft: false,
      footer: false,
      extendModules: [], // 路由扩展模块
      myroute: {},
      pageTitle: '',
      serverData: {},
      alreadyUrls: {},
      messages: messages,
      routerPath: '',
      fundDetailsType: {},//同花顺详情和高端详情
    },
    actions,
    mutations,
    getters,
    modules:{
      form
    }
  });
}
