<template>
  <div class="component">
    <p class="title">歌詞</p>
    <loadProgress v-model="this.lyric.length" :itemName="'歌詞'"/>
    <div class="lyric">
      <span class="animated fadeIn" v-show="isMounted" v-html="lyric"></span>
    </div>
  </div>
</template>
<script>
import loadProgress from './widgets/load-progress.vue';

export default {
  components: {
    loadProgress
  },
  props: {
    artist: {
      type: String,
      required: true
    },
    title: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      lyric: '',
      isMounted: false,
      isError: false
    };
  },
  mounted: function() {
    this.isMounted = false;

    var data = {};
    data["artist"] = this.artist;
    data["title"] = this.title;
    var query = this.$root.buildQuery(data);
    
    axios.get('/api/songs/lyric' + query).then(res => {
      this.lyric = (res.data.lyric !== undefined) ? res.data.lyric : '';
      this.isMounted = true;
    }).catch(err => {
      this.isError = true;
    });
  }
};
</script>
<style lang="scss" scoped>
div.component {
  margin: 8px 0;
  border: 1px solid #ccc;
  p.title {
    margin: 0;
    padding: 6px;
    background: #eee;
    border-bottom: 1px solid #ccc;
    font-size: 12px;
    text-align: center;
  }
  div.lyric {
    padding: 12px 12px 24px 12px;
  }
}
</style>
