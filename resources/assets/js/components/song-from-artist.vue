<template>
  <div>
    <LoadProgress v-model="statuses.length" :itemName="'曲'"/>
    <Songs @updated="updatedStatus" v-model="this.statuses"/>
    <Pagination @paging="statusesRequest" v-model="statuses.length" :responseMaxCount="20"/>
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

      var data = {};
      data['type'] = 'artist';
      data['source'] = this.source;
      data['id'] = this.id;
      data['page'] = this.pageValue;
      data['with_state'] = '1';
      var query = this.$root.buildQuery(data);

      axios.get('/api/songs' + query).then(res => {
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
