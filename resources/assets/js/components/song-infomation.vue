<template>
  <div class="section">
    <h1 class="title">
      <i class="fas fa-music"></i>&nbsp;{{ song.artist }} / {{ song.title }}
    </h1>
    <div class="song-infomation">
      <div class="cover-image-big">
        <img v-bind:src="song.image_url" alt="">
        <div class="mediPlayer" v-if="song.audio_url">
          <audio class="listen" preload="none" data-size="120" v-bind:src="song.audio_url"></audio>
        </div>
      </div>
      <div style="text-align: center;">
        <select class="status-select"
          v-bind:class="[song.id , { 'active' : song.user_state != 0 }]"
          v-model="song.user_state"
          @change="updateStatus(song.id)"
          v-bind:disabled="isBusy">
          <option value="0" selected>記録なし</option>
          <option value="1">気になる</option>
          <option value="2">練習中</option>
          <option value="3">習得済み</option>
        </select>
      </div>
      <table class="infomation-table">
        <thead>
          <tr>
            <th colspan="2">曲情報</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>タイトル</td>
            <td>{{ song.title }}</td>
          </tr>
          <tr>
            <td>アーティスト</td>
            <td>{{ song.artist }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    song: {
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
          state: this.song.user_state
        }).then(res => {
          updateUserStatuses(res.data.user);
          this.isBusy = false;
        }).catch(err => {
          window.location.href = "/login";
      });
    }
  },
  mounted() {
    setTimeout("initializePlayer()", 1000);
  }
};
</script>
