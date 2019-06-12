<template>
  <div class="pagination">
    <button class="button button-danger auto" @click="paging(-1)" v-bind:disabled="!this.$parent.isMounted || this.$parent.pageValue == 1">前のページ</button>
    <a>{{ this.$parent.pageValue }}&nbsp;ページ</a>
    <button class="button button-danger auto" @click="paging(1)" v-bind:disabled="!this.$parent.isMounted || this.$parent.pageValue == 9999 || this.responseCount == 0">次のページ</button>
  </div>
</template>
<script>
export default {
  model: {
    prop: 'responseCount'
  },
  props: {
    responseCount: {
      type: Number,
      required: false,
      default: -1
    }
  },
  methods: {
    paging: function(direction) {
      $('body,html').animate({
        scrollTop: 0
      }, 200);
      this.$parent.pageValue += direction;
      this.$emit('paging');
    }
  }
}
</script>
<style lang="scss" scoped>
div.pagination {
  padding: 12px 0 12px 0;
  text-align: center;
  a {
    margin: 0 12px;
    font-size: 14px;
  }
  button.button {
    font-size: 12px;
  }
} 
</style>
