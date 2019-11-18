<template>
  <div class="load-progress">
    <div id="loading" v-show="!this.$parent.isMounted && !this.$parent.isError">
      <p><img src="/images/loading.svg" width="48px" alt="読み込み中..."></p>
    </div>
    <div id="loaded" v-show="this.$parent.isMounted && this.responseCount == 0">
      <p>{{ this.itemName }}が見つかりませんでしたわ。(&gt; &lt;。)</p>
    </div>
    <div id="error" v-show="this.$parent.isError">
      <p>エラー吐きましたわ。(&gt; &lt;。)</p>
    </div>
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
    },
    itemName: {
      type: String,
      required: false,
      default: '項目'
    }
  }
}
</script>
<style lang="scss" scoped>
div.load-progress > div {
  display: table;
  width: 100%;
  height: 67px;
  text-align: center;
  p {
    display: table-cell;
    font-size: 12px;
    line-height: 67px;
    vertical-align: middle;
    img {
      display: block;
      margin: 0 auto;
      padding: 0;
    }
  }
}
</style>
