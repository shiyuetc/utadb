<template>
  <div class="song-infomation">
    <div class="cover-image-big">
      <img v-bind:src="status.song.image_url" alt="">
      <div class="mediPlayer" v-if="status.song.audio_url">
        <audio class="listen" preload="none" data-size="120" v-bind:src="status.song.audio_url"></audio>
      </div>
    </div>
    <div style="text-align: center;">
      <updateSelect @updated="updatedStatus" :id="status.song.id" :state="status.user_state"/>
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
    <table class="infomation-table">
      <thead>
        <tr><th colspan="2">登録しているユーザー</th></tr>
      </thead>
      <tbody>
        <tr>
          <td>習得済み</td>
          <td>
            <div>
              <a v-for="(user, index) in this.statuses[3]" :key='index' v-bind:href="'/@' + user.screen_name">
                <img class="avatar" v-bind:src="user.profile_image_url + '_small.png'" alt="" v-tooltip.top-center="user.name + ' (@' + user.screen_name + ')'">
              </a>
            </div>
          </td>
        </tr>
        <tr>
          <td>練習中</td>
          <td>
            <a v-for="(user, index) in this.statuses[2]" :key='index' v-bind:href="'/@' + user.screen_name">
              <img class="avatar" v-bind:src="user.profile_image_url + '_small.png'" alt="" v-tooltip.top-center="user.name + ' (@' + user.screen_name + ')'">
            </a>
          </td>
        </tr>
        <tr>
          <td>気になる</td>
          <td>
            <a v-for="(user, index) in this.statuses[1]" :key='index' v-bind:href="'/@' + user.screen_name">
              <img class="avatar" v-bind:src="user.profile_image_url + '_small.png'" alt="" v-tooltip.top-center="user.name + ' (@' + user.screen_name + ')'">
            </a>
          </td>
        </tr>
      </tbody>
    </table>
    <ul class="link-items">
      <li><a v-bind:href="'https://www.google.com/search?q=' + status.song.artist + '+' + status.song.title" target="_blank"><img src="/images/icons/icon-google.png" alt=""></a></li>
      <li><a v-bind:href="'https://www.youtube.com/results?search_query=' + status.song.artist + '+' + status.song.title" target="_blank"><img src="/images/icons/icon-youtube.png" alt=""></a></li>
    </ul>
  </div>
</template>
<script>
import VTooltip  from 'v-tooltip';
import UpdateSelect from './ui/update-select.vue';

export default {
  components: {
    UpdateSelect
  },
  props: {
    status: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      isBusy: false,
      statuses: [],
    };
  },
  methods: {
    updatedStatus: function(response) {
      updateUserStatuses(response.user);
    }
  },
  mounted() {
    setTimeout("initializePlayer()", 100);
    axios.get("/api/status/lookup?song_id=" + this.status.song.id).then(res => {
      this.statuses = res.data;
    }).catch(err => { });
  }
};
</script>
<style scoped>
div.song-infomation {
  margin: 18px 12px;
}
table.infomation-table {
  width: 100%;
  margin: 12px 0;
  border-collapse: collapse;
}
table.infomation-table th {
  padding: 6px 0;
  border: 1px solid #ccc;
  background: #eee;
  font-weight: normal;
	font-size: 12px;
	text-align: center;
}
table.infomation-table td {
  padding: 6px;
  border: 1px solid #ccc;
  font-size: 14px;
}
table.infomation-table td:nth-child(2n+1) {
  width: 120px;
  background: #eee;
	text-align: right;
}
table.infomation-table img.avatar {
  width: 32px;
  height: 32px;
  margin: 0 2px;
}
ul.link-items {
  display: flex;
  list-style: none;
  justify-content: flex-end;
  margin: 0;
  padding-left: 0;
}
ul.link-items li a {
  display: block;
  margin-left: 4px;
  border: 1px solid #ccc;
}
ul.link-items li a img {
  vertical-align: bottom;
}
</style>