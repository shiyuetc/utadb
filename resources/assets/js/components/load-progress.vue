<template>
  <div class="load-progress">
    <div v-if="!this.$parent.isMounted" id="loading" class="load">
      <p><img src="/images/loading.gif" alt="読み込み中..."></p>
    </div>
    <div v-if="this.$parent.isMounted && this.$parent.statuses.length == 0" id="loaded" class="load">
      <p>項目が存在しませんでした。</p>
    </div>
  </div>
</template>
<style scoped>
div.load {
  display: table;
  width: 100%;
  height: 67px;
  text-align: center;
}
div.load p {
  display: table-cell;
  font-size: 12px;
  line-height: 67px;
  vertical-align: middle;
}
div.load p img {
  display: block;
	margin: 0 auto;
	padding: 0;
}
</style>