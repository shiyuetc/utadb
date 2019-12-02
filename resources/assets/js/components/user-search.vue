<template>
  <div>
    <LoadProgress v-model="users.length" :itemName="'ユーザー'"/>
    <Users v-model="this.users"/>
    <Pagination @paging="statusesRequest" v-model="users.length"/>
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

      var data = {};
      if(this.keyword != undefined) data['keyword'] = this.keyword;
      data['page'] = this.pageValue;
      var query = this.$root.buildQuery(data);

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
