<template>
  <div>
    <p v-show="user.is_following_you" class="is-following-you">あなたをフレンドに追加しています</p>
    <div class="event-buttons">
      <div v-if="is_me == 1"><button class="button button-default extend-link"><a href="/settings/profile"></a><i class="fas fa-edit"></i>&nbsp;プロフィールの編集</button></div>
      <followButton v-if="is_me == 0" :user="user" :is_following="user.is_following"></followButton>
      <div><button class="button button-default extend-link"><a :href="'/@' + user.screen_name + '/random'"></a><i class="fas fa-sync-alt"></i>&nbsp;ランダム選曲</button></div>
    </div>
  </div>
</template>
<script>
import followButton from './ui/follow-button.vue';

export default {
  components: {
    followButton
  },
  props: {
    user: {
      type: Object,
      required: true
    },
    is_auth: {
      type: Number,
      required: false,
      default: 0
    },
    is_me: {
      type: Number,
      required: false,
      default: 0
    }
  }
}
</script>
<style scoped>
p.is-following-you {
  margin-top: 6px;
  padding: 2px 0;
  background: #eee;
  border-radius: 4px;
  font-size: 12px;
}
</style>
