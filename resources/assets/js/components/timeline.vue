<template>
  <div class="timeline">
    <loadProgress v-model="this.statuses.length"/>
    <div v-if="this.isMounted" class="statuses animated fadeIn">
      <div class="status" v-for="status in this.statuses" :key="status.id">
        <div class="status-header">
          <p class="avatar"><a v-bind:href="'/@' + status.user.screen_name"><img v-bind:src="status.user.profile_image_url + '_small.png'" alt=""></a></p>
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
                <p class="title"><a class="default-link" v-bind:href="'/songs/' + status.song.id">{{ status.song.title }}</a></p>
                <p class="artist">{{ status.song.artist }}</p>
              </td>
              <td class="action-cell">
                <updateSelect :ref="status.song.id" @updated="updatedStatus" :id="status.song.id" :state="status.user_state"/>
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
import LoadProgress from './widgets/load-progress.vue';
import UpdateSelect from './ui/update-select.vue';

export default {
  components: {
    LoadProgress,
    UpdateSelect
  },
  props: {
    user_id: {
      type: String,
      required: false,
      default: null
    }
  },
  data() {
    return {
      isMounted: false,
      isBusy: false,
      isError: false,
      statusJp: ['気になる曲', '練習中の曲', '習得済みの曲'],
      statuses: [],
      next: null,
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
    statusesRequest: function() {
      this.isMounted = false;
      var timeline = this.user_id == null ? "public_timeline" : "user_timeline?id=" + this.user_id;
      axios.get("/api/" + timeline).then(res => {
        this.statuses = res.data;
        this.isMounted = true;
        setTimeout("initializePlayer()", 1000);
      }).catch(err => {
        this.isError = true;
      });
    },
    updatedStatus: function(response) {
      if(this.user_id == null) {
        let selects = this.$refs[response.id];
        for (var i = 0; i < selects.length; i++) {
          selects[i].stateValue = response.new_state;
        }
      }
      var user = response.user;
      if(this.user_id == null || this.user_id == user.id) {
        updateUserStatuses(user);
      }
    }
  },
  mounted() {
    this.$nextTick(function () {
      this.statusesRequest();
    })
  }
};
</script>

