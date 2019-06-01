<template>
<div class="statuses section animated fadeIn">
  <div class="status" v-for="(status, index) in statuses" :key="status.id">
    <div class="status-header">
      <p class="avatar"><a v-bind:href="'@' + status.user.name"><img src="images/sample_avatar.png" alt=""></a></p>
      <p class="text"><a class="default-link" v-bind:href="'@' + status.user.name">{{ status.user.name }}</a>さんが『{{ status_jp[status.state - 1] }}』に登録しました</p>
    </div>
    <div class="status-body">
      <table class="music-table">
        <tr>
          <td class="media-cell">
            <div class="cover-image">
              <img v-bind:src="status.song.image_url" onerror="this.src='images/no-cover-image.png'" alt="">
              <div class="mediPlayer" v-if="status.song.audio_url">
                <audio class="listen" preload="none" data-size="40" v-bind:src="status.song.audio_url"></audio>
              </div>
            </div>
          </td>
          <td class="text-cell">
            <p class="title">{{ status.song.title }}</p>
            <p class="artist">{{ status.song.artist }}</p>
          </td>
          <td class="action-cell">
            <select v-bind:id="'select' + index" class="status-select" v-bind:class="{ 'active' : status.user_state != 0 }" v-model="status.user_state" v-on:change="updateStatus(index, status.song.id)">
              <option value="0" selected>記録なし</option>
              <option value="1">気になる</option>
              <option value="2">練習中</option>
              <option value="3">習得済み</option>
            </select>
          </td>
        </tr>
      </table>
    </div>
    <div class="status-footer">
      <p class="date">{{ subtractDate(status.used_at) }}</p>
    </div>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      status_jp: ['気になる曲', '練習中の曲', '習得済みの曲'],
      statuses: [],
    };
  },
  methods: {
    subtractDate: function(date) {
      var now = new Date();
      var target = new Date(date.replace(/-/g,"/"));
      var timestamp = Math.round(now.getTime() / 1000 - target.getTime() / 1000);
      if(timestamp < 60) {
        return timestamp + " 秒前";
      } if(timestamp < 3600) {
        return (Math.round(timestamp / 60)) + " 分前";
      } if(timestamp < 86400) {
        return (Math.round(timestamp / 3600)) + " 時間前";
      }
      return (Math.round(timestamp / 86400)) + " 日前";
    },
    updateStatus: function(index, song_id) {
      
    }
  },
  mounted() {
    axios.get("api/public_timeline").then(res => {
      this.statuses = res.data;
      setTimeout("initializePlayer()", 1000);
    }).catch(err => { });
  }
};
</script>

