<template>
    <!--最外层的div很重要-->
    <!--[Vue warn]: The client-side rendered virtual DOM tree is not matching server-rendered content. This is likely caused by incorrect HTML markup, for example nesting block-level elements inside <p>, or missing <tbody>. Bailing hydration and performing full client-side render.-->
    <div>
        <div id="APP">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>

  export default {
    name: 'APP',
    components: {},
    computed: {},
    created() {

    },
    mounted() {

    }
  }
</script>

<style>

</style>

