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
  </div>
</template>
<script>
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
    };
  },
  methods: {
    updatedStatus: function(response) {
      updateUserStatuses(response.user);
    }
  },
  mounted() {
    setTimeout("initializePlayer()", 100);
  }
};
</script>
<style scoped>
div.song-infomation {
  margin: 18px 12px;
}
table.infomation-table {
  width: 100%;
  margin-top: 12px;
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
</style>