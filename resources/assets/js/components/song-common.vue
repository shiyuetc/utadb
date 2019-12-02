<template>
  <div>
    <LoadProgress v-model="this.songs.length" :itemName="'曲'"/>
    <Songs v-if="this.songs.length > 0" @updated="updatedStatus" v-model="this.songs"/>
    <Pagination @paging="request" v-model="this.songs.length"/>
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
    },
    perPage: {
      type: Number,
      required: false,
      default: 50
    }
  },
  data() {
    return {
      isMounted: false,
      isError: false,
      setPlayer: null,
      pageValue: this.page,
      songs: [],
    };
  },
  methods: {
    request: function() {
      this.isMounted = false;
      if(this.setPlayer != null) clearTimeout(this.setPlayer);

      var data = {};
      data['page'] = this.pageValue;
      data['per_page'] = this.perPage;
      data['with_state'] = '1';
      var query = this.$root.buildQuery(data);

      axios.get('/api/songs/@' + this.user_id + '/common' + query).then(res => {
        this.songs = res.data;
        this.isMounted = true;
        this.setPlayer = setTimeout("initializePlayer()", 1000);
      }).catch(err => {
        this.songs = [];
        this.isError = true;
      });
    },
    updatedStatus: function(response) { }
  },
  mounted: function() {
    this.$nextTick(function () {
      this.request();
    })
  }
}
</script>
