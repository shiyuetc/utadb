<template>
  <div>
    <LoadProgress v-model="this.songs.length" :itemName="'曲'"/>
    <Songs v-if="this.songs.length > 0" @updated="updatedStatus" v-model="this.songs"/>
  </div>
</template>
<script>
import LoadProgress from './widgets/load-progress.vue';
import Songs from './common/songs.vue';

export default {
  components: {
    LoadProgress,
    Songs
  },
  data() {
    return {
      isMounted: false,
      isError: false,
      songs: []
    };
  },
  methods: {
    request: function() {
      this.isMounted = false;
      axios.get('/api/songs/recent').then(res => {
        this.songs = res.data;
        this.isMounted = true;
      }).catch(err => {
        this.songs = [];
        this.isError = true;
      });
    },
    updatedStatus: function(response) {
      updateUserStatuses(response.user);
    }
  },
  mounted: function() {
    this.$nextTick(function () {
      this.request();
    })
  }
}
</script>
