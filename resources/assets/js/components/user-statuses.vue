<template>
  <div class="user-statuses">
    <loadProgress/>
    <div v-if="this.isMounted" class="statuses">
      <div class="status" v-for="(status, index) in statuses" :key='index'>
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
                <p class="title"><a class="default-link" v-bind:href="'/songs/' + status.song.id">{{ status.song.title }}</a></p>
                <p class="artist">{{ status.song.artist }}</p>
              </td>
              <td class="action-cell">
                <select v-bind:id="index" class="status-select"
                  v-bind:class="[status.song.id , { 'active' : status.user_state != 0 }]"
                  v-model="status.user_state"
                  v-on:change="updateStatus(index, status.song.id)"
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
    </div>
    <pagination @paging="statusesRequest"/>
  </div>
</template>
<script>
import loadProgress from './load-progress.vue';
import pagination from './pagination.vue';

export default {
  components: {
    loadProgress,
    pagination
  },
  props: {
    user_id: {
      type: String
    },
    state: {
      type: Number,
      default: 0
    },
    page: {
      type: Number,
      default: 1
    }
  },
  data() {
    return {
      pageValue: this.page,
      statuses: [],
      setPlayer: null,
      isMounted: false,
      isBusy: false
    };
  },
  methods: {
    statusesRequest: function() {
      this.isMounted = false;
      if(this.setPlayer != null) clearTimeout(this.setPlayer);
      axios.get("/api/user_statuses?id=" + this.user_id + "&state=" + this.state + "&page=" + this.pageValue).then(res => {
        this.statuses = res.data;
        this.isMounted = true;
        this.setPlayer = setTimeout("initializePlayer()", 1000);
      }).catch(err => {});
    },
    updateStatus: function(index, song_id) {
      if (this.isBusy) return;
      this.isBusy = true;
      axios.post("/api/update_status", {
          song_id: song_id,
          state: this.statuses[index].user_state
        }).then(res => {
          var user = res.data.user;
          if(this.user_id == user.id) {
            updateUserStatuses(user);
          }
          this.isBusy = false;
        }).catch(err => {
          window.location.href = "/login";
      });
    }
  },
  mounted: function() {
    this.$nextTick(function () {
      this.statusesRequest();
    })
  }
}
</script>
