<template>
  <div class="users">
    <table v-if="this.$parent.isMounted && this.users.length != 0" class="object-table user-table animated fadeIn">
      <thead>
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
        <tr v-for="(user, index) in this.users" :key='index'>
          <td><a v-bind:href="'/@' + user.screen_name"><img class="avatar" v-bind:src="user.profile_image_url + '_small.png'" alt=""></a></td>
          <td><a v-bind:href="'/@' + user.screen_name" class="default-link">{{ user.name }}(@{{ user.screen_name }})</a></td>
          <td class="state-count-cell">{{ user.mastered_count }}</td>
          <td class="state-count-cell">{{ user.training_count }}</td>
          <td class="state-count-cell">{{ user.stacked_count }}</td>
          <td class="state-count-cell hidden-lg-below">{{ user.mastered_count + user.training_count + user.stacked_count }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  model: {
    prop: 'users'
  },
  props: {
    users: {
      type: Array,
      required: true,
    }
  }
}
</script>