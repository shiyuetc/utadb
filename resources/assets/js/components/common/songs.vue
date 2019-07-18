<template>
  <div class="songs">
    <table v-if="this.$parent.isMounted && this.songs.length != 0" class="object-table music-table table-padding animated fadeIn">
      <thead>
        <tr>
          <th></th>
          <th class="title-column">タイトル</th>
          <th>ステータス</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(song, index) in this.songs" :key='index'>
          <td class="media-cell">
            <div class="cover-image">
              <img :src="song.image_url" alt="">
              <div class="mediPlayer" v-if="song.audio_url">
                <audio class="listen" preload="none" data-size="40" :src="song.audio_url"></audio>
              </div>
            </div>
          </td>
          <td class="text-cell">
            <p class="title"><a class="default-link" :href="'/songs/' + song.id">{{ song.title }}</a></p>
            <p class="artist"><a class="default-link" :href="'/artists/' + song.artist_id">{{ song.artist }}</a></p>
          </td>
          <td class="action-cell">
            <updateSelect @updated="updatedStatus" :id="song.id" :state="song.my_state"/>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import updateSelect from '../ui/update-select.vue';

export default {
  components: {
    updateSelect
  },
  model: {
    prop: 'songs'
  },
  props: {
    songs: {
      type: Array,
      required: true,
    }
  },
  methods: {
    updatedStatus: function(response) {
      this.$emit('updated', response);
    }
  }
}
</script>
