<template>
  <div class="search-result">
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
              <updateSelect @updated="updatedStatus" :id="status.song.id" :state="status.user_state"/>
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
import updateSelect from './update-select.vue';

export default {
  components: {
    loadProgress,
    pagination,
    updateSelect
  },
  props: {
    source: {
      type: Number,
      default: 0
    },
    q: {
      type: String,
      required: true
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
      axios.get("/api/search_song?source=" + this.source + "&q=" + this.q + "&page=" + this.pageValue).then(res => {
        this.statuses = res.data;
        this.isMounted = true;
        this.setPlayer = setTimeout("initializePlayer()", 1000);
      }).catch(err => {});
    },
    updatedStatus: function(response) {
      updateUserStatuses(response.user);
    }
  },
  mounted: function() {
    this.$nextTick(function () {
      this.statusesRequest();
    })
  }
}
</script>
