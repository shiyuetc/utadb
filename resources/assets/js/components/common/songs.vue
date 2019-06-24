<template>
  <div class="songs">
    <table v-if="this.$parent.isMounted && this.statuses.length != 0" class="object-table music-table table-padding animated fadeIn">
      <thead>
        <tr>
          <th></th>
          <th class="title-column">タイトル</th>
          <th>ステータス</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(status, index) in this.statuses" :key='index'>
          <td class="media-cell">
            <div class="cover-image">
              <img v-bind:src="status.song.image_url" alt="">
              <div class="mediPlayer" v-if="status.song.audio_url">
                <audio class="listen" preload="none" data-size="40" v-bind:src="status.song.audio_url"></audio>
              </div>
            </div>
          </td>
          <td class="text-cell">
            <p class="title"><a class="default-link" v-bind:href="'/songs/' + status.song.id">{{ status.song.title }}</a></p>
            <p class="artist">{{ status.song.artist }}</p>
          </td>
          <td class="action-cell">
            <updateSelect @updated="updatedStatus" :id="status.song.id" :state="status.user_state"/>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import UpdateSelect from '../ui/update-select.vue';

export default {
  components: {
    UpdateSelect
  },
  model: {
    prop: 'statuses'
  },
  props: {
    statuses: {
      type: Array,
      required: true,
    }
  },
  data() {
    return {
      isBusy: false,
    };
  },
  methods: {
    updatedStatus: function(response) {
      this.$emit('updated', response);
    }
  } 
}
</script>
