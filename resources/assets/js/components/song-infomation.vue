<template>
  <div class="song-infomation">
    <div class="cover-image-big">
      <img v-bind:src="status.song.image_url" alt="">
      <div class="mediPlayer" v-if="status.song.audio_url">
        <audio class="listen" preload="none" data-size="120" v-bind:src="status.song.audio_url"></audio>
      </div>
    </div>
    <div style="text-align: center;">
      <select class="status-select"
        v-bind:class="[status.song.id , { 'active' : status.user_state != 0 }]"
        v-model="status.user_state"
        @change="updateStatus(status.song.id)"
        v-bind:disabled="isBusy">
        <option value="0" selected>記録なし</option>
        <option value="1">気になる</option>
        <option value="2">練習中</option>
        <option value="3">習得済み</option>
      </select>
    </div>
    <table class="infomation-table">
      <thead>
        <tr><th colspan="2">曲情報</th></tr>
      </thead>
      <tbody>
        <tr>
          <td>タイトル</td>
          <td>{{ status.song.title }}</td>
        </tr>
        <tr>
          <td>アーティスト</td>
          <td>{{ status.song.artist }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    status: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      isBusy: false,
    };
  },
  methods: {
    updateStatus: function(song_id) {
      if (this.isBusy) return;
      this.isBusy = true;
      
      axios.post("/api/update_status", {
          song_id: song_id,
          state: this.status.user_state
        }).then(res => {
          updateUserStatuses(res.data.user);
          this.isBusy = false;
        }).catch(err => {
          window.location.href = "/login";
      });
    }
  },
  mounted() {
    setTimeout("initializePlayer()", 100);
  }
};
</script>
