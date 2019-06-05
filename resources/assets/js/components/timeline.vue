<template>
  <div class="section">
    <h1 class="title">
      <span v-if="user_id == null"><i class="fab fa-react"></i>&nbsp;ローカルタイムライン</span>
      <span v-if="user_id != null"><i class="fab fa-react"></i>&nbsp;ユーザータイムライン</span>
    </h1>
    <div v-if="isMounted" class="statuses animated fadeIn">
      <div class="status" v-for="(status, index) in statuses" :key="status.id">
        <div class="status-header">
          <p class="avatar">
            <a v-bind:href="'@' + status.user.screen_name">
              <img src="images/sample_avatar.png" alt="">
            </a>
          </p>
          <p class="text">
            <a class="default-link" v-bind:href="'@' + status.user.screen_name">{{ status.user.name }}</a>さんが『{{ statusJp[status.state - 1] }}』に登録しました
          </p>
        </div>
        <div class="status-body">
          <table class="music-table">
            <tr>
              <td class="media-cell">
                <div class="cover-image">
                  <img v-bind:src="status.song.image_url" onerror="this.src='images/no-cover-image.png'" alt>
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
                <select
                  v-bind:id="index"
                  class="status-select"
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
      <div v-if="statuses.length == 0" class="not-exist">
        <p></p>
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
      var timestamp = Math.round(
        now.getTime() / 1000 - target.getTime() / 1000
      );
      if (timestamp < 60) {
        return timestamp + " 秒前";
      }
      if (timestamp < 3600) {
        return Math.round(timestamp / 60) + " 分前";
      }
      if (timestamp < 86400) {
        return Math.round(timestamp / 3600) + " 時間前";
      }
      return Math.round(timestamp / 86400) + " 日前";
    },
    updateStatus: function(index, song_id) {
      if (this.isBusy) return;
      this.isBusy = true;
      var state = this.statuses[index].user_state;
      axios.post("/api/update_status", {
          id: song_id,
          state: state
        }).then(res => {
          var selects = $("." + song_id);
          for (var i = 0; i < selects.length; i++) {
            if (selects[i].id == index) continue;
            this.statuses[selects[i].id].user_state = state;
          }
          var user = res.data.user;
          if(this.user_id == user.id) {
            var statusCountElements = document.getElementsByClassName('status-count');
            statusCountElements[0].textContent = (user.stacked_state_count + user.training_state_count + user.mastered_state_count) + '曲';
            statusCountElements[1].textContent = user.mastered_state_count + '曲';
            statusCountElements[2].textContent = user.training_state_count + '曲';
            statusCountElements[3].textContent = user.stacked_state_count + '曲';
          }
          this.isBusy = false;
        }).catch(err => {
          window.location.href = "/login";
      });
    }
  },
  mounted() {
    var data = this.user_id != null ? "?id=" + this.user_id : "";
    var timeline = this.user_id == null ? "public" : "user";
    axios.get("/api/" + timeline+ "_timeline" + data).then(res => {
        this.statuses = res.data;
        this.isMounted = true;
        setTimeout("initializePlayer()", 1000);
    }).catch(err => {});
  }
};
</script>

