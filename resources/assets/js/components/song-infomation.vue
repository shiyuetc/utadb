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
import updateSelect from './update-select.vue';

export default {
  components: {
    updateSelect
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
