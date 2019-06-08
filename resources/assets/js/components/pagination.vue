<template>
  <div class="pagination">
    <button class="button button-danger auto" @click="paging(-1)" v-bind:disabled="this.$parent.pageValue == 1">前のページ</button>
    <a>{{ this.$parent.pageValue }}&nbsp;ページ</a>
    <button class="button button-danger auto" @click="paging(1)" v-bind:disabled="this.$parent.pageValue == 9999 || this.$parent.statuses.length == 0">次のページ</button>
  </div>
</template>
<script>
export default {
  methods: {
    paging: function(direction) {
      this.$parent.pageValue += direction;
      this.$emit('paging');
    }
  }
}
</script>
<style scoped>
div.pagination {
  padding: 12px 0 12px 0;
  text-align: center;
}
div.pagination a {
  margin: 0 12px;
  font-size: 14px;
}
div.pagination button.button {
  font-size: 12px;
}
</style>
