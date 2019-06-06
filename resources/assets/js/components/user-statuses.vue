<template>
  <div class="section">
    <h1 class="title">
      <span v-if="state == 0"><i class="fa fa-check"></i>&nbsp;登録済みの曲</span>
      <span v-if="state == 3"><i class="fa fa-check"></i>&nbsp;習得済みの曲</span>
      <span v-if="state == 2"><i class="fas fa-graduation-cap"></i>&nbsp;練習中の曲</span>
      <span v-if="state == 1"><i class="far fa-sticky-note"></i>&nbsp;気になる曲</span>
    </h1>
    <div v-if="!isMounted" class="loading">
      <p><img src="/images/loading.gif" alt="読み込み中..."></p>
    </div>
    <div v-if="isMounted" class="statuses animated fadeIn">
      <div class="status" v-for="(status, index) in statuses" :key='index'>
        <table class="music-table">
            <tr>
              <td class="media-cell">
                <div class="cover-image">
                  <img v-bind:src="status.song.image_url" onerror="this.src='/images/no-cover-image.png'" alt="">
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
    <div class="pagination">
      <button class="button button-danger auto" @click="paging(-1)" v-bind:disabled="this.page == 1">前のページ</button>
      <a href="#">{{ page }}&nbsp;ページ</a>
      <button class="button button-danger auto" @click="paging(1)" v-bind:disabled="this.page == 9999 || statuses.length == 0">次のページ</button>
    </div>
  </div>
</template>

<script>
export default {
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
      statuses: [],
      setPlayer: null,
      isMounted: false,
      isBusy: false
    };
  },
  methods: {
    paging: function(direction) {
      this.isMounted = false;
      this.page += direction;
      if(this.setPlayer != null) clearTimeout(this.setPlayer);
      axios.get("/api/user_statuses?id=" + this.user_id + "&state=" + this.state + "&page=" + this.page).then(res => {
        this.statuses = res.data;
        this.isMounted = true;
        this.setPlayer = setTimeout("initializePlayer()", 1000);
      }).catch(err => {});
    },
    updateStatus: function(index, song_id) {
      if (this.isBusy) return;
      this.isBusy = true;
      axios.post("/api/update_status", {
          id: song_id,
          state: this.statuses[index].user_state
        }).then(res => {
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
    axios.get("/api/user_statuses?id=" + this.user_id + "&state=" + this.state + "&page=" + this.page).then(res => {
        this.statuses = res.data;
        this.isMounted = true;
        this.setPlayer = setTimeout("initializePlayer()", 1000);
    }).catch(err => {});
  }
}
</script>
