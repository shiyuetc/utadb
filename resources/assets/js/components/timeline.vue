<template>
  <div class="timeline">
    <div class="articles statuses">
      <div class="article status animated fadeIn" v-for="status in this.statuses" :key="status.id">
        <div class="article-header">
          <p class="avatar"><a :href="'/@' + status.user.screen_name"><img :src="status.user.profile_image_url + '_small.png'" alt=""></a></p>
          <p class="text"><a class="bold underline" :href="'/@' + status.user.screen_name">{{ status.user.name }}</a>さんが「{{ statusJp[status.state] }}」に登録しました</p>
        </div>
        <div class="article-body">
          <table class="music-table">
            <tr>
              <td class="media-cell">
                <div class="cover-image">
                  <img :src="status.song.image_url" alt="">
                  <div class="mediPlayer" v-if="status.song.audio_url">
                    <audio class="listen" preload="none" data-size="40" :src="status.song.audio_url"></audio>
                  </div>
                </div>
              </td>
              <td class="text-cell">
                <p class="title"><a class="default-link" :href="'/songs/' + status.song.id">{{ status.song.title }}</a></p>
                <p class="artist"><a class="default-link" :href="'/artists/' + status.song.artist_id">{{ status.song.artist }}</a></p>
              </td>
              <td class="action-cell">
                <updateSelect :ref="status.song.id" @updated="updatedStatus" :id="status.song.id" :state="status.my_state"/>
              </td>
            </tr>
          </table>
        </div>
        <div class="article-footer">
          <p class="date"><subtract-date :date="status.created_at"></subtract-date></p>
          <p class="like" @click="postLike(status)">
            <span :class="[ status.is_liked ? 'liked' : 'unlike']">
              <i :class="[[ status.is_liked ? 'fas' : 'far'], 'fa-heart']"></i>
              <a v-show="status.like_count > 0">{{ status.like_count }}</a>
            </span>
          </p>
        </div>
      </div>
    </div>
    <loadProgress v-model="this.statuses.length" :itemName="'投稿'"/>
    <button v-show="this.count == 50 && this.isMounted && this.next != null" class="button button-default" @click="statusesRequest">さらに読み込む...</button>
    <button v-show="this.count != 50 && this.isMounted && this.next != null" class="button button-default" @click="redirectUrl('/@' + screen_name + '/records')">もっと見る</button>
  </div>
</template>
<script>
import loadProgress from './widgets/load-progress.vue';
import subtractDate from './ui/subtract-date.vue';
import updateSelect from './ui/update-select.vue';

export default {
  components: {
    loadProgress,
    subtractDate,
    updateSelect
  },
  props: {
    user_id: {
      type: String,
      required: false,
      default: null
    },
    screen_name: {
      type: String,
      required: false,
      default: null
    },
    count: {
      type: Number,
      required: false,
      default: 50
    }
  },
  data() {
    return {
      statusJp: ['記録なし', '気になる曲', '練習中の曲', '習得済みの曲'],
      isMounted: false,
      isBusy: false,
      isError: false,
      statuses: [],
      next: null
    };
  },
  methods: {
    redirectUrl: function (url) {
        location.href = url;
    },
    statusesRequest: function() {
      this.isMounted = false;

      var data = {};
      if(this.user_id != null) data['id'] = this.user_id;
      if(this.next != null) data['next'] = this.next;
      data['count'] = this.count;
      var query = this.$root.buildQuery(data);
      
      axios.get("/api/timeline" + query).then(res => {
        if(this.statuses.length == 0) {
          this.statuses = res.data;
        } else {
          res.data.forEach((status) => {
            this.statuses.push(status);
          });
        }
        this.next = res.data.length == this.count ? res.data[res.data.length - 1]['id'] : null;
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
        this.$set(status, 'like_count', status.like_count + 1);
      } else {
        var action = 'destroy';
        this.$set(status, 'is_liked', 0);
        this.$set(status, 'like_count', status.like_count - 1);
      }
      
      axios.post("/api/likes/" + action + "?id=" + status.id).then(res => {
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