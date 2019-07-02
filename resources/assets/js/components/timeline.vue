<template>
  <div class="timeline">
    <div class="statuses">
      <div class="status animated fadeIn" v-for="status in this.statuses" :key="status.id">
        <div class="status-header">
          <p class="avatar"><a v-bind:href="'/@' + status.user.screen_name"><img v-bind:src="status.user.profile_image_url + '_small.png'" alt=""></a></p>
          <p class="text"><a class="default-link" v-bind:href="'/@' + status.user.screen_name">{{ status.user.name }}</a>さんが「{{ statusJp[status.state] }}」に登録しました</p>
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
                <updateSelect :ref="status.song.id" @updated="updatedStatus" :id="status.song.id" :state="status.my_state"/>
              </td>
            </tr>
          </table>
        </div>
        <div class="status-footer">
          <p class="date">{{ subtractDate(status.created_at) }}</p>
          <p class="like" @click="postLike(status)">
            <span v-bind:class="[ status.is_liked ? 'liked' : 'unlike']">
              <i v-bind:class="[[ status.is_liked ? 'fas' : 'far'], 'fa-heart']"></i>
              <a v-show="status.like_count > 0">{{ status.like_count }}</a>
            </span>
          </p>
        </div>
      </div>
    </div>
    <loadProgress v-model="this.statuses.length"/>
    <button v-show="this.isMounted && this.next != null" class="button button-default" @click="statusesRequest">さらに読み込む...</button>
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
      statusJp: ['記録なし', '気になる曲', '練習中の曲', '習得済みの曲'],
      statuses: [],
      next: null,

      test_key: [{is_liked: 0,like_count: 0}, {is_liked: 0,like_count: 0}]
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
      var timeline = this.user_id == null ? "public_timeline?" : "user_timeline?id=" + this.user_id + "&";
      if(this.next != null) {
        timeline += "next=" + this.next;
      }
      axios.get("/api/" + timeline).then(res => {
        if(this.statuses.length == 0) {
          this.statuses = res.data;
        } else {
          res.data.forEach((status) => {
            this.statuses.push(status);
          });
        }
        this.next = res.data.length == 50 ? res.data[res.data.length - 1]['id'] : null;
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
    },
    postLike: function(status) {
      if(this.isBusy) return;
      this.isBusy = true;

      if(!status.is_liked) {
        var action = 'create';
        this.$set(status, 'is_liked', 1);
      } else {
        var action = 'destroy';
        this.$set(status, 'is_liked', 0);
      }
      
      axios.post("/api/likes/" + action + "?activity_id=" + status.id).then(res => {
        this.$set(status, 'like_count', res.data["like_count"]);
        this.isBusy = false;
      }).catch(err => {
        window.location.href = "/login";
      });
    },
  },
  mounted() {
    this.$nextTick(function () {
      this.statusesRequest();
    })
  }
};
</script>

