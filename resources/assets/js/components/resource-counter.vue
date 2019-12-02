<template>
  <div id="resource-counter">
    <p class="text">
      <span class="count f14"><i class="fa fa-user"></i>&nbsp;ユーザー数：<DrumRoll :value="user_count"/></span>
      &nbsp;|&nbsp;
      <span class="count f14"><i class="fa fa-pen"></i>&nbsp;状態管理数：<DrumRoll :value="post_count"/></span>
    </p>
  </div>
</template>
<script>
import DrumRoll from './ui/drum-roll.vue';

export default {
  components: { 
    DrumRoll 
  },
  data() {
    return {
      user_count: 0,
      post_count: 0
    };
  },
  mounted: function() {
    axios.get("/api/application/resource").then(res => {
      this.user_count = res.data['user_count'];
      this.post_count = res.data['post_count'];
    }).catch(err => {});
  }
}
</script>
