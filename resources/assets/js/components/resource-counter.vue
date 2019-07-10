<template>
  <div id="resource-counter">
    <p class="text">
      <span class="count"><i class="fa fa-user"></i>&nbsp;ユーザー数：<drumRoll :value="user_count"></drumRoll></span>
      &nbsp;|&nbsp;
      <span class="count"><i class="fa fa-pen"></i>&nbsp;状態管理数：<drumRoll :value="post_count"></drumRoll></span>
    </p>
  </div>
</template>
<script>
import drumRoll from './ui/drum-roll.vue';

export default {
  components: { 
    drumRoll 
  },
  data() {
    return {
      user_count: 0,
      post_count: 0
    };
  },
  mounted: function() {
    this.$nextTick(function () {
      axios.get("/api/application/resource").then(res => {
        this.user_count = res.data['user_count'];
        this.post_count = res.data['post_count'];
      }).catch(err => {});
    })
  }
}
</script>
<style scoped>
.count {
  font-size: 14px;
}
</style>
