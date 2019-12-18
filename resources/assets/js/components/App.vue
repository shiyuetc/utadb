<template>
<div id="app">
  <div id="app-body">
    <vue-progress-bar />
    <v-header />
    <div class="header-push"></div>
    <div class="container">
      <router-view></router-view>
    </div>
    <div class="footer-push"></div>
  </div>
  <v-footer />
</div>
</template>

<script>
export default {
  name: "App",
  mounted() {
    this.$Progress.finish();
  },
  created() {
    this.$Progress.start();
    this.$router.beforeEach((to, from, next) => {
      if (to.meta.progress !== undefined) {
        let meta = to.meta.progress;
        this.$Progress.parseMeta(meta);
      }
      this.$Progress.start();
      next();
    });
    this.$router.afterEach((to, from) => {
      this.$Progress.finish();
    });
  }
};
</script>