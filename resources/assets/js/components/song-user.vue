<template>
  <div>
    <loadProgress v-model="this.songs.length" :itemName="'曲'"/>
    <songs v-if="this.songs.length > 0" @updated="updatedStatus" v-model="this.songs"/>
    <pagination @paging="request" v-model="this.songs.length"/>
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
    user_id: {
      type: String,
      required: true
    },
    state: {
      type: Number,
      required: false,
      default: 0
    },
    keyword: {
      type: String,
      required: false,
      default: ''
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
      songs: []
    };
  },
  methods: {
    request: function() {
      this.isMounted = false;
      if(this.setPlayer != null) clearTimeout(this.setPlayer);

      var query = '?';
      query += 'state=' + this.state + '&';
      query += this.keyword != '' ? 'keyword=' + this.keyword + '&' : '';
      query += 'page=' + this.pageValue + '&';
      query += 'per_page=' + this.perPage + '&';

      axios.get('/api/songs/' + this.user_id + query).then(res => {
        this.songs = res.data;
        this.isMounted = true;
        this.setPlayer = setTimeout("initializePlayer()", 1000);
      }).catch(err => {
        this.songs = [];
        this.isError = true;
      });
    },
    updatedStatus: function(response) {
      var user = response.user;
      if(this.user_id == user.id) {
        updateUserStatuses(user);
      }
    }
  },
  mounted: function() {
    this.$nextTick(function () {
      this.request();
    })
  }
}
</script>
