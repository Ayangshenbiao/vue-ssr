<template>
    <div>
        <h1 @click="fun()">接口调试</h1>
        <h1 @click="goPush('/home')">go home</h1>
    </div>
</template>
<script>

  export default {
    created() {
      // 服务端不支持这个钩子，不要在此处写逻辑代码
    },
    beforeCreate(){
      // 服务端不支持这个钩子，不要在此处写逻辑代码
    },
    pageConfig() {//渲染配置，每个页面组件必须有
      return {
        title: '登录',
      }
    },
    name: "login",
    components: {},
    data() {
      return {};
    },
    mounted() {
      console.log(this.$options)
    },
    computed: {},
    props: [],
    methods: {
      fun() {//post请求示例
        this.$store.dispatch('FETCH', {
          urlKey: 'GETAREAINFOBYDB',
          data: {
            data: 1
          }
        }).then(res => {
          console.log(res);
        }).catch(err => {
          console.log(err)
        })
      },

    }
  };
</script>

<style lang="less">

</style>
