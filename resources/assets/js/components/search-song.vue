<template>
  <div class="search-result">
    <loadProgress v-model="statuses.length"/>
    <songs @updated="updatedStatus" v-model="this.statuses"/>
    <pagination @paging="statusesRequest" v-model="statuses.length"/>
  </div>
</template>
<script>
import LoadProgress from './widgets/load-progress.vue';
import Pagination from './widgets/pagination.vue';
import Songs from './common/songs.vue';

export default {
  components: {
    LoadProgress,
    Pagination,
    Songs
  },
  props: {
    source: {
      type: Number,
      required: false,
      default: -1
    },
    q: {
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
      isError: false,
      pageValue: this.page,
      statuses: [],
      setPlayer: null,
    };
  },
  methods: {
    statusesRequest: function() {
      this.isMounted = false;
      if(this.setPlayer != null) clearTimeout(this.setPlayer);

      axios.get("/api/search/song?source=" + this.source + "&q=" + this.q + "&page=" + this.pageValue).then(res => {
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