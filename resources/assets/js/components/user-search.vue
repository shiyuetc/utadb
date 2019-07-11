<template>
  <div>
    <loadProgress v-model="users.length" :itemName="'ユーザー'"/>
    <users v-model="this.users"/>
    <pagination @paging="statusesRequest" v-model="users.length"/>
  </div>
</template>
<script>
import loadProgress from './widgets/load-progress.vue';
import pagination from './widgets/pagination.vue';
import users from './common/users.vue';

export default {
  components: {
    loadProgress,
    pagination,
    users,
  },
  props: {
    keyword: {
      type: String,
      required: false,
      default: null
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

      var query = '?';
      query += this.keyword != undefined ? 'keyword=' + this.keyword + '&' : '';
      query += 'page=' + this.pageValue;

      axios.get('/api/users' + query).then(res => {
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
