<template>
  <div class="section">
    <h1 class="title">
      <span v-if="type == 'all'"><i class="fa fa-check"></i>&nbsp;登録済みの曲</span>
      <span v-if="type == 'mastered'"><i class="fa fa-check"></i>&nbsp;習得済みの曲</span>
      <span v-if="type == 'training'"><i class="fas fa-graduation-cap"></i>&nbsp;練習中の曲</span>
      <span v-if="type == 'stacked'"><i class="far fa-sticky-note"></i>&nbsp;気になる曲</span>
    </h1>
    <div v-if="isMounted" class="statuses animated fadeIn">
      <div class="status" v-for="(status, index) in statuses" :key='index'>
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
                  v-on:change="updateStatus(index, status.song.id)"
                  v-bind:disabled="isBusy"
                >
                  <option value="0" selected>記録なし</option>
                  <option value="1">気になる</option>
                  <option value="2">練習中</option>
                  <option value="3">習得済み</option>
                </select>
              </td>
            </tr>
          </table>
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
    type: {
      type: String,
      default: 'all'
    },
    user_id: {
      type: String
    }
  },
  data() {
    return {
      statuses: [],
      isMounted: false,
      isBusy: false
    };
  },
  methods: {
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
          this.isBusy = false;
        }).catch(err => {
          window.location.href = "/login";
      });
    }
  },
  mounted() {
    var state = 0;
    switch(this.type) {
      case 'mastered': state = 3; break;
      case 'training': state = 2; break;
      case 'stacked': state = 1; break;
    }
    var data = "?id=" + this.user_id + "&state=" + state;
    axios.get("/api/user_statuses" + data).then(res => {
        this.statuses = res.data;
        this.isMounted = true;
        setTimeout("initializePlayer()", 1000);
    }).catch(err => {});
  }
}
</script>
