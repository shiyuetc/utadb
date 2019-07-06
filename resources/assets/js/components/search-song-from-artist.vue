<template>
  <div class="search-result">
    <loadProgress v-model="statuses.length" :itemName="'曲'"/>
    <songs @updated="updatedStatus" v-model="this.statuses"/>
    <pagination @paging="statusesRequest" v-model="statuses.length" :responseMaxCount="20"/>
  </div>
</template>
<script>
import loadProgress from './widgets/load-progress.vue';
import pagination from './widgets/pagination.vue';
import songs from './common/songs.vue';

export default {
  components: {
    loadProgress,
    pagination,
    songs
  },
  props: {
    source: {
      type: Number,
      required: false,
      default: -1
    },
    id: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      isMounted: false,
      isError: false,
      pageValue: 1,
      statuses: [],
      setPlayer: null,
    };
  },
  methods: {
    statusesRequest: function() {
      this.isMounted = false;
      if(this.setPlayer != null) clearTimeout(this.setPlayer);

      axios.get("/api/songs/search_from_artist?source=" + this.source + "&artist_id=" + this.id + "&page=" + this.pageValue).then(res => {
        this.statuses = res.data;
        this.isMounted = true;
        this.setPlayer = setTimeout("initializePlayer()", 1000);
      }).catch(err => {
        this.statuses = [];
        this.isError = true;
      });
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