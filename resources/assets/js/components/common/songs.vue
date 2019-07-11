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
              <img v-bind:src="song.image_url" alt="">
              <div class="mediPlayer" v-if="song.audio_url">
                <audio class="listen" preload="none" data-size="40" v-bind:src="song.audio_url"></audio>
              </div>
            </div>
          </td>
          <td class="text-cell">
            <p class="title"><a class="default-link" v-bind:href="'/songs/' + song.id">{{ song.title }}</a></p>
            <p class="artist"><a class="default-link" v-bind:href="'/artists/' + song.artist_id">{{ song.artist }}</a></p>
          </td>
          <td class="action-cell">
            <updateSelect v-if="statuses[song.id] != undefined" @updated="updatedStatus" :id="song.id" :state="statuses[song.id]"/>
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
  data() {
    return {
      isBusy: false,
      statuses: []
    };
  },
  watch: {
    songs: function() {
      this.lookStatus();
    }
  },
  methods: {
    lookStatus: function() {
      this.statuses = [];
      if(this.songs.length > 0) {
        var ids_str = '?';
        this.songs.forEach((song) => {
          ids_str += 'ids[]=' + song.id + '&';
        });
        axios.get('/api/statuses/lookup' + ids_str).then(res => {
          this.statuses = res.data;
        }).catch(err => { });
      }
    },
    updatedStatus: function(response) {
      this.$emit('updated', response);
    }
  },
  mounted: function() {
    this.$nextTick(function () {
      this.lookStatus();
    })
  }
}
</script>
