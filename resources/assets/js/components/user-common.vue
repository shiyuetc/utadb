<template>
  <div class="user-statuses">
    <loadProgress v-model="this.statuses.length"/>
    <table v-if="this.isMounted" class="object-table music-table table-padding">
      <thead v-if="this.statuses.length != 0">
        <tr>
          <th></th>
          <th class="title-column">タイトル</th>
          <th>ステータス</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(status, index) in this.statuses" :key='index'>
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
      </tbody>
    </table>
    <pagination @paging="statusesRequest" v-model="this.statuses.length"/>
  </div>
</template>
<script>
import LoadProgress from './load-progress.vue';
import Pagination from './pagination.vue';
import UpdateSelect from './ui/update-select.vue';

export default {
  components: {
    LoadProgress,
    Pagination,
    UpdateSelect
  },
  props: {
    user_id: {
      type: String,
      required: true
    },
    page: {
      type: Number,
      required: false,
      default: 1
    }
  },
  data() {
    return {
      isMounted: false,
      isBusy: false,
      isError: false,
      pageValue: this.page,
      setPlayer: null,
      statuses: [],
    };
  },
  methods: {
    statusesRequest: function() {
      this.isMounted = false;
      if(this.setPlayer != null) clearTimeout(this.setPlayer);
      axios.get("/api/user_common?id=" + this.user_id + "&page=" + this.pageValue).then(res => {
        this.statuses = res.data;
        this.isMounted = true;
        this.setPlayer = setTimeout("initializePlayer()", 1000);
      }).catch(err => {
        this.statuses = [];
        this.isError = true;
      });
    },
    updatedStatus: function(response) {
      
    }
  },
  mounted: function() {
    this.$nextTick(function () {
      this.statusesRequest();
    })
  }
}
</script>
