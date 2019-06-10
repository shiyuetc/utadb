<template>
  <div class="search-result">
    <loadProgress/>
    <table v-if="this.isMounted" class="object-table user-table">
      <thead v-if="this.statuses.length != 0">
        <tr>
          <th class="avatar-column"></th>
          <th class="name-column">ユーザー名</th>
          <th><span class="hidden-sm-below">習得</span>済<span class="hidden-sm-below">み</span></th>
          <th><span class="hidden-sm-below">練習</span>中</th>
          <th>気<span class="hidden-sm-below">になる</span></th>
          <th class="hidden-lg-below">登録済み</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, index) in statuses" :key='index'>
          <td><a v-bind:href="'/@' + user.screen_name"><img class="avatar" v-bind:src="user.profile_image_url + '_small.png'" alt=""></a></td>
          <td><a v-bind:href="'/@' + user.screen_name" class="default-link">{{ user.name }}(@{{ user.screen_name }})</a></td>
          <td class="state-count-cell">{{ user.mastered_state_count }}</td>
          <td class="state-count-cell">{{ user.training_state_count }}</td>
          <td class="state-count-cell">{{ user.stacked_state_count }}</td>
          <td class="state-count-cell hidden-lg-below">{{ user.mastered_state_count + user.training_state_count + user.stacked_state_count }}</td>
        </tr>
      </tbody>
    </table>
    <pagination @paging="statusesRequest"/>
  </div>
</template>
<script>
import loadProgress from './load-progress.vue';
import pagination from './pagination.vue';

export default {
  components: {
    loadProgress,
    pagination,
  },
  props: {
    q: {
      type: String,
      required: true
    },
    page: {
      type: Number,
      default: 1
    }
  },
  data() {
    return {
      pageValue: this.page,
      statuses: [],
      isMounted: false,
      isError: false
    };
  },
  methods: {
    statusesRequest: function() {
      this.isMounted = false;

      axios.get("/api/search_user?q=" + this.q + "&page=" + this.pageValue).then(res => {
        this.statuses = res.data;
        this.isMounted = true;
      }).catch(err => {
        this.statuses = [];
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
<style scoped>
table.user-table th.avatar-column {
	width: 52px;
}
table.user-table th.name-column {
  padding: 0 12px;
  text-align: left;
}
table.user-table td img.avatar {
  width: 42px;
  height: auto;
  border-radius: 100%;
  vertical-align: bottom;
  transition: opacity 0.3s;
  -moz-transition: opacity 0.3s;
  -webkit-transition: opacity 0.3s;
  -o-transition: opacity 0.3s;
  -ms-transition: opacity 0.3s;
}
table.user-table td img.avatar:hover {
	opacity: 0.8;
}
table.user-table td.state-count-cell {
  border-left: 1px solid #eaeaea;
	text-align: center;
}
</style>
