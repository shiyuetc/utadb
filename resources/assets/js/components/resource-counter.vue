<template>
  <div id="resource-counter">
    <p class="text">
      <span class="count"><i class="fa fa-user"></i>&nbsp;ユーザー数：{{ this.user_count }}</span>
      &nbsp;|&nbsp;
      <span class="count"><i class="fa fa-pen"></i>&nbsp;状態管理数：{{ this.status_count }}</span>
    </p>
  </div>
</template>
<script>
export default {
  data() {
    return {
      user_count: 0,
      status_count: 0
    };
  },
  mounted: function() {
    $('#resource-counter').fadeTo("slow", 1.00);
    this.$nextTick(function () {
      axios.get("/api/application/resource").then(res => {
        this.user_count = res.data['user_count'];
        this.status_count = res.data['status_count'];
      }).catch(err => {});
    })
  }
}
</script>
<style scoped>
#resource-counter {
  display: none;
}
.count {
  font-size: 14px;
}
</style>
