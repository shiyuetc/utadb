<template>
  <div>
    <select class="status-select" v-bind:class="[this.id , { 'active' : stateValue != 0 }]"
      v-model="stateValue"
      @change="updateStatus"
      v-bind:disabled="this.$parent.isBusy">
      <option value="0" selected>記録なし</option>
      <option value="1">気になる</option>
      <option value="2">練習中</option>
      <option value="3">習得済み</option>
    </select>
  </div>
</template>
<script>
export default {
  props: {
    id: {
      type: String,
      required: true
    },
    state: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      stateValue: this.state,
    }
  },
  methods: {
    updateStatus: function() {
      if (this.$parent.isBusy) return;
      this.$parent.isBusy = true;
      axios.post("/api/update_status", {
          song_id: this.id,
          state: this.stateValue
        }).then(res => {
          this.$emit('updated', res.data);
          this.$parent.isBusy = false;
        }).catch(err => {
          window.location.href = "/login";
      });
    }
  }
}
</script>
