<template>
  <div>
    <loadProgress v-model="users.length" :itemName="'ユーザー'"/>
    <users v-model="this.users"/>
    <pagination @paging="request" v-model="users.length"/>
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
    type: {
      type: String,
      required: true
    },
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      pageValue: 1,
      users: [],
      isMounted: false,
      isError: false
    };
  },
  methods: {
    request: function() {
      this.isMounted = false;
      
      var data = {};
      data['id'] = this.user.id;
      data['page'] = this.pageValue;
      var query = this.$root.buildQuery(data);

      axios.get('/api/friends/' + this.type + query).then(res => {
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
      this.request();
    })
  }
}
</script>
