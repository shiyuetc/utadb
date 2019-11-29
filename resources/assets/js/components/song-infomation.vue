<template>
  <div class="song-infomation">
    <div class="cover-image-big">
      <img :src="song.image_url" alt="">
      <div class="mediPlayer" v-if="song.audio_url">
        <audio class="listen" preload="none" data-size="120" :src="song.audio_url"></audio>
      </div>
    </div>
    <div style="text-align: center;">
      <updateSelect @updated="updatedStatus" :id="song.id" :state="my_state_value"/>
    </div>
    <table class="infomation-table">
      <thead>
        <tr><th colspan="2">曲情報</th></tr>
      </thead>
      <tbody>
        <tr>
          <td>タイトル</td>
          <td>{{ song.title }}</td>
        </tr>
        <tr>
          <td>アーティスト</td>
          <td><a class="default-link" :href="'/artists/' + song.artist_id">{{ song.artist }}</a></td>
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
              <a v-for="(user, index) in this.users[3]" :key='index' :href="'/@' + user.screen_name">
                <img class="avatar" :src="user.profile_image_url + '_small.png'" alt="" v-tooltip.top-center="user.name + ' (@' + user.screen_name + ')'">
              </a>
            </div>
          </td>
        </tr>
        <tr>
          <td>練習中</td>
          <td>
            <a v-for="(user, index) in this.users[2]" :key='index' :href="'/@' + user.screen_name">
              <img class="avatar" :src="user.profile_image_url + '_small.png'" alt="" v-tooltip.top-center="user.name + ' (@' + user.screen_name + ')'">
            </a>
          </td>
        </tr>
        <tr>
          <td>気になる</td>
          <td>
            <a v-for="(user, index) in this.users[1]" :key='index' :href="'/@' + user.screen_name">
              <img class="avatar" :src="user.profile_image_url + '_small.png'" alt="" v-tooltip.top-center="user.name + ' (@' + user.screen_name + ')'">
            </a>
          </td>
        </tr>
      </tbody>
    </table>
    <ul class="link-items">
      <li><a :href="'https://www.google.com/search?q=' + song.artist + '+' + song.title" target="_blank"><img src="/images/icons/icon-google.png" alt="" v-tooltip.top-center="'Googleで検索'"></a></li>
      <li><a :href="'https://www.youtube.com/results?search_query=' + song.artist + '+' + song.title" target="_blank"><img src="/images/icons/icon-youtube.png" alt="" v-tooltip.top-center="'Youtubeで検索'"></a></li>
      <li><a :href="'https://open.spotify.com/search/' + song.artist + ' ' + song.title" target="_blank"><img src="/images/icons/icon-spotify.png" alt="" v-tooltip.top-center="'Spotifyで検索'"></a></li>
    </ul>
    <LyricText :artist="song.artist" :title="song.title"/>
  </div>
</template>
<script>
import VTooltip  from 'v-tooltip';
import UpdateSelect from './ui/update-select.vue';
import LyricText from './lyric-text.vue';

export default {
  components: {
    UpdateSelect,
    LyricText
  },
  props: {
    song: {
      type: Object,
      required: true
    },
    my_state: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      isBusy: false,
      my_state_value: this.my_state,
      users: [],
    };
  },
  methods: {
    updatedStatus: function(response) {
      updateUserStatuses(response.user);
    }
  },
  mounted() {
    setTimeout("initializePlayer()", 100);
    axios.get("/api/statuses/registereUser?id=" + this.song.id).then(res => {
      this.users = res.data;
    }).catch(err => { });
  }
};
</script>
<style lang="scss" scoped>
div.song-infomation {
  margin: 18px 12px;
}
table.infomation-table {
  width: 100%;
  margin: 12px 0;
  border-collapse: collapse;
  th {
    padding: 6px 0;
    border: 1px solid #ccc;
    background: #eee;
    font-weight: normal;
    font-size: 12px;
    text-align: center;
  }
  td {
    padding: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
  }
  td:nth-child(2n+1) {
    width: 120px;
    background: #eee;
    text-align: right;
  }
  img.avatar {
    width: 32px;
    height: 32px;
    margin: 0 2px;
    border-radius: 100%;
  }
}
ul.link-items {
  display: flex;
  list-style: none;
  justify-content: flex-end;
  margin: 0;
  padding-left: 0;
  li a {
    display: block;
    margin-left: 4px;
    border: 1px solid #ccc;
    transition: background-color 0.2s;
    -moz-transition: background-color 0.2s;
    -webkit-transition: background-color 0.2s;
    -o-transition: background-color 0.2s;
    -ms-transition: background-color 0.2s;
    img {
      vertical-align: bottom;
    }
  }
  li a:hover {
    background: #eaeaea;
  }
}
</style>
