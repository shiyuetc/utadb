<template>
  <div>
    <div class="articles">
      <div class="article animated fadeIn" v-for="notification in this.notifications" :key="notification.id">
        <div class="article-header">
          <p class="avatar"><a v-bind:href="'/@' + notification.sender.screen_name"><img v-bind:src="notification.sender.profile_image_url + '_small.png'" alt=""></a></p>
          <p class="text" v-show="notification.kind == 'like'"><a class="default-link" v-bind:href="'/@' + notification.sender.screen_name">{{ notification.sender.name }}</a>さんに【{{ notification.song.artist }} / <a class="default-link" v-bind:href="'/songs/' + notification.song.id">{{ notification.song.title }}</a>】を「{{ statusJp[notification.activity.state] }}」に登録した投稿がいいねされました</p>
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
      isMounted: false,
      isError: false,
      statusJp: ['記録なし', '気になる曲', '練習中の曲', '習得済みの曲'],
      notifications: []
    };
  },
  methods: {
    subtractDate: function(date) {
      var now = new Date();
      var target = new Date(date.replace(/-/g, "/"));
      var timestamp = Math.floor(now.getTime() / 1000 - target.getTime() / 1000);
      if (timestamp < 60) return timestamp + ' 秒前';
      if (timestamp < 3600) return Math.floor(timestamp / 60) + ' 分前 ';
      if (timestamp < 86400) return Math.floor(timestamp / 3600) + ' 時間前';
      return Math.floor(timestamp / 86400) + ' 日前';
    },
    Request: function() {
      this.isMounted = false;
      axios.get('/api/notifications/list').then(res => {
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
