<template>
  <div>
    <div class="articles">
      <div class="article animated fadeIn" v-for="notification in this.notifications" :key="notification.id">
        <div class="article-header">
          <p class="avatar"><a :href="'/@' + notification.sender.screen_name"><img :src="notification.sender.profile_image_url + '_small.png'" alt=""></a></p>
          <p class="text" v-if="notification.kind == 'like'">
            <a class="default-link" :href="'/@' + notification.sender.screen_name">{{ notification.sender.name }}</a>さんに【<a class="default-link" :href="'/artists/' + notification.song.artist_id">{{ notification.song.artist }}</a> / <a class="default-link" :href="'/songs/' + notification.song.id">{{ notification.song.title }}</a>】を「{{ statusJp[notification.post.state] }}」に登録した投稿がいいねされました
          </p>
          <p class="text" v-if="notification.kind == 'follow'">
            <a class="default-link" :href="'/@' + notification.sender.screen_name">{{ notification.sender.name }}</a>さんがあなたをフレンドに追加しました
          </p>
        </div>
        <div class="article-footer">
          <p class="date"><subtract-date :date="notification.created_at"></subtract-date></p>
        </div>
      </div>
    </div>
    <loadProgress v-model="this.notifications.length" :itemName="'通知'"/>
  </div>
</template>
<script>
import loadProgress from './widgets/load-progress.vue';
import subtractDate from './ui/subtract-date.vue';

export default {
  components: {
    loadProgress,
    subtractDate
  },
  data() {
    return {
      statusJp: ['記録なし', '気になる曲', '練習中の曲', '習得済みの曲'],
      isMounted: false,
      isError: false,
      notifications: []
    };
  },
  methods: {
    Request: function() {
      this.isMounted = false;
      axios.get('/api/notifications').then(res => {
        this.notifications = res.data;
        this.isMounted = true;
      }).catch(err => {
        this.isError = true;
      });
    }
  },
  mounted: function() {
    this.$nextTick(function () {
      this.Request();
    })
  }
}
</script>
