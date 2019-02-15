<template>
    <div>
        <!--接口-->
        <h1 @click="fun()">xxx</h1>

        <!--路由-->
        <h1 @click="goPush('/home')">go home</h1>

        <!--element ui-->
        <el-button type="primary">主要按钮</el-button>

        <!--avue-->
        <avue-data-display :option="option"></avue-data-display>

        <!--vue-jlunar-datepicker  部分需特殊配置的组件 详见webpack.base.config.js-->
        <j-date-picker v-model="picker" width="150" :editable="false" :showLunarControl="false"></j-date-picker>
    </div>
</template>
<script>

  export default {
    created() {
      // 服务端没有window、document对象， 如果加了对这个对象的引用和操作，将在服务端引起报错中断。
    },
    beforeCreate(){
      // 服务端没有window、document对象， 如果加了对这个对象的引用和操作，将在服务端引起报错中断。
    },
    pageConfig() {//渲染配置，每个页面组件必须有
      return {
        title: '登录',
      }
    },
    name: "login",
    components: {},
    data() {
      return {
        picker: "",
        option:{
          data:[
            {
              count: 100,
              title: '日活跃数',
              href:'https://avue.top',
              target:'_blank'
            },
            {
              count: '3,000',
              title: '月活跃数',
              href:'https://avue.top',
              target:'_blank'
            },
            {
              count: '20,000',
              title: '年活跃数',
              href:'https://avue.top',
              target:'_blank'
            },
            {
              count: '40,000',
              title: '周活跃数',
              href:'https://avue.top',
              target:'_blank'
            }
          ]
        }
      };
    },
    mounted() {
      console.log(this.$options,process)
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

<style lang="scss" scoped>

</style>
