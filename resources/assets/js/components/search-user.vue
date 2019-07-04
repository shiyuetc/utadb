<template>
  <div class="search-result">
    <loadProgress v-model="users.length" :itemName="'ユーザー'"/>
    <users v-model="this.users"/>
    <pagination @paging="statusesRequest" v-model="users.length"/>
  </div>
</template>
<script>
import LoadProgress from './widgets/load-progress.vue';
import Pagination from './widgets/pagination.vue';
import Users from './common/users.vue';

export default {
  components: {
    LoadProgress,
    Pagination,
    Users,
  },
  props: {
    q: {
      type: String,
      required: false,
      default: ''
    },
    page: {
      type: Number,
      default: 1
    }
  },
  data() {
    return {
      pageValue: this.page,
      users: [],
      isMounted: false,
      isError: false
    };
  },
  methods: {
    statusesRequest: function() {
      this.isMounted = false;
      var api = this.q == '' ?
        "list?page=" + this.pageValue :
        "search?q=" + this.q + "&page=" + this.pageValue;
      axios.get('/api/users/' + api).then(res => {
        this.users = res.data;
        this.isMounted = true;
      }).catch(err => {
        this.users = [];
        this.isError = true;
      });
    }
  },
  mounted: function() {
    this.$nextTick(function () {
      this.statusesRequest();
    })
  }
}
</script>
