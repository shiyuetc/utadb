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