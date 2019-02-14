<template>
    <div>
        <h1 @click="fun()">xxx</h1>
        <h1 @click="goPush('/home')">go home</h1>
        <!--<avue-data-display :option="option"></avue-data-display>-->
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
