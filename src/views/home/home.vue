<template>
    <div>
        <h1>home</h1>
        <h1 @click="goPush('/login')">go login</h1>
    </div>
</template>

<script>
  export default {
    pageConfig(){
      return {}
    },
    name: "home",
    data() {
      return {}
    },
    methods: {},
    mounted() {

    }

  }
</script>

<style lang="less" scoped>

</style>