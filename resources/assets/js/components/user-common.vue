<template>
  <div class="user-statuses">
    <loadProgress v-model="this.statuses.length"/>
    <songs @updated="updatedStatus" v-model="this.statuses"/>
    <pagination @paging="statusesRequest" v-model="this.statuses.length"/>
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
    updatedStatus: function(response) { }
  },
  mounted: function() {
    this.$nextTick(function () {
      this.statusesRequest();
    })
  }
}
</script>
