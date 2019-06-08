<template>
  <div class="timeline">
    <div v-if="!this.isMounted" id="loading" class="load">
      <p><img src="/images/loading.gif" alt="読み込み中..."></p>
    </div>
    <div v-if="this.isMounted && this.statuses.length == 0" id="loaded" class="load">
      <p>項目が存在しませんでした。</p>
    </div>
    <div v-if="this.isMounted" class="statuses animated fadeIn">
      <div class="status" v-for="(status, index) in statuses" :key="status.id">
        <div class="status-header">
          <p class="avatar"><a v-bind:href="'/@' + status.user.screen_name"><img src="/images/sample_avatar.png" alt=""></a></p>
          <p class="text"><a class="default-link" v-bind:href="'/@' + status.user.screen_name">{{ status.user.name }}</a>さんが『{{ statusJp[status.state - 1] }}』に登録しました</p>
        </div>
        <div class="status-body">
          <table class="music-table">
            <tr>
              <td class="media-cell">
                <div class="cover-image">
                  <img v-bind:src="status.song.image_url" alt="">
                  <div class="mediPlayer" v-if="status.song.audio_url">
                    <audio class="listen" preload="none" data-size="40" v-bind:src="status.song.audio_url"></audio>
                  </div>
                </div>
              </td>
              <td class="text-cell">
                <p class="title"><a class="default-link" v-bind:href="'/song/' + status.song.id">{{ status.song.title }}</a></p>
                <p class="artist">{{ status.song.artist }}</p>
              </td>
              <td class="action-cell">
                <select v-bind:id="index" class="status-select"
                  v-bind:class="[status.song.id , { 'active' : status.user_state != 0 }]"
                  v-model="status.user_state"
                  @change="updateStatus(index, status.song.id)"
                  v-bind:disabled="isBusy">
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
  </div>
</template>

<script>
export default {
  props: {
    user_id: {
      type: String
    }
  },
  data() {
    return {
      statusJp: ['気になる曲', '練習中の曲', '習得済みの曲'],
      statuses: [],
      isMounted: false,
      isBusy: false
    };
  },
  methods: {
    subtractDate: function(date) {
      var now = new Date();
      var target = new Date(date.replace(/-/g, "/"));
      var timestamp = Math.round(now.getTime() / 1000 - target.getTime() / 1000);
      if (timestamp < 60) return timestamp + ' 秒前';
      if (timestamp < 3600) return Math.round(timestamp / 60) + ' 分前';
      if (timestamp < 86400) return Math.round(timestamp / 3600) + ' 時間前';
      return Math.round(timestamp / 86400) + ' 日前';
    },
    updateStatus: function(index, song_id) {
      if (this.isBusy) return;
      this.isBusy = true;
      
      var state = this.statuses[index].user_state;
      var selects = $("." + song_id);
      for (var i = 0; i < selects.length; i++) {
        if (selects[i].id == index) continue;
        this.statuses[selects[i].id].user_state = state;
      }
      axios.post("/api/update_status", {
          song_id: song_id,
          state: state
        }).then(res => {
          var user = res.data.user;
          if(this.user_id == null || this.user_id == user.id) {
            updateUserStatuses(user);
          }
          this.isBusy = false;
        }).catch(err => {
          window.location.href = "/login";
      });
    }
  },
  mounted() {
    var timeline = (this.user_id == null) ? "public_timeline" : "user_timeline?id=" + this.user_id;
    axios.get("/api/" + timeline).then(res => {
        this.statuses = res.data;
        this.isMounted = true;
        setTimeout("initializePlayer()", 1000);
    }).catch(err => {});
  }
};
</script>

