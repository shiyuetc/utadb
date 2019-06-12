<template>
  <div>
    <select id="categories" class="select" v-model="category" @change="updateAvatarList">
      <option value="monster">モンスター (12件)</option>
      <option value="food_jp">食べ物(和食) (15件)</option>
      <option value="food_we">食べ物(洋食) (14件)</option>
      <option value="food_cn">食べ物(中華) (14件)</option>
      <option value="food_other">食べ物(その他) (13件)</option>
      <option value="plant">植物 (16件)</option>
      <option value="insect">昆虫 (16件)</option>
    </select>
    <load-progress/>
    <div v-if="isMounted" class="avatars">
      <label class="avatar" v-for="(avatar, index) in avatars" :key='index' v-tooltip.top-center="avatar.name">
        <img v-bind:src="'/images/profile_image/' + avatar.category + '/' + avatar.id + '_small.png'" alt="">
        <p><input type="radio" name="avatar" v-bind:value="avatar.id"></p>
      </label>
    </div>
  </div>
</template>
<script>
import LoadProgress from './load-progress.vue';
import VTooltip  from 'v-tooltip';

export default {
  components: {
    LoadProgress
  },
  data() {
    return {
      isMounted: false,
      category: 'monster',
      avatars: [],
    };
  },
  methods: {
    updateAvatarList: function() {
      this.isMounted = false;
      axios.get("/api/search_avatar?category=" + this.category).then(res => {
        this.avatars = res.data;
        this.isMounted = true;
      }).catch(err => { });
    }
  },
  mounted: function() {
    this.$nextTick(function () {
      this.updateAvatarList('monster');
    })
  }
}
</script>
<style lang="scss" scoped>
div.avatars {
  margin-top: 12px;
  label.avatar {
    float: left;
    margin: 0;
    text-align: center;
    p {
      margin: 0;
      font-size: 14px;
    }
    img {
      width: 48px;
      height: 48px;
      cursor: pointer;
    }
  }
}
</style>