<template>
  <div class="status-infomation">
    <div class="articles statuses">
      <div class="article status">
        <div class="article-header">
          <p class="avatar"><a :href="'/@' + status.user.screen_name"><img :src="'/images/profile_image' + status.user.profile_image + '_small.png'" alt=""></a></p>
          <p class="text"><a class="bold underline" :href="'/@' + status.user.screen_name">{{ status.user.name }}</a>さんが「{{ statusJp[status.state] }}」に登録しました</p>
        </div>
        <div class="article-body">
          <table class="music-table">
            <tr>
              <td class="media-cell">
                <div class="cover-image">
                  <img :src="status.song.image_url" alt="">
                  <div class="mediPlayer" v-if="status.song.audio_url">
                    <audio class="listen" preload="none" data-size="40" :src="status.song.audio_url"></audio>
                  </div>
                </div>
              </td>
              <td class="text-cell">
                <p class="title"><a class="default-link" :href="'/songs/' + status.song.id">{{ status.song.title }}</a></p>
                <p class="artist"><a class="default-link" :href="'/artists/' + status.song.artist_id">{{ status.song.artist }}</a></p>
              </td>
              <td class="action-cell">
                <UpdateSelect :ref="status.song.id" @updated="updatedStatus" :id="status.song.id" :state="status.my_state"/>
              </td>
            </tr>
          </table>
        </div>
        <div class="article-footer">
          <p class="date"><SubtractDate :date="status.created_at"/> ({{ status.created_at }})</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import SubtractDate from './ui/subtract-date.vue';
import UpdateSelect from './ui/update-select.vue';

export default {
  components: {
    SubtractDate,
    UpdateSelect
  },
  props: {
    status: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      statusJp: ['記録なし', '気になる曲', '練習中の曲', '習得済みの曲'],
    };
  },
  methods: {
    updatedStatus: function(response) {
      updateUserStatuses(response.user);
    },
  },
  mounted() {
    this.$nextTick(function () {
      setTimeout("initializePlayer()", 1000);
    })
  }
};
</script>
