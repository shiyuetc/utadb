<template>
  <span>{{ subtractDate(this.date) }}</span>
</template>
<script>
export default {
  props: {
    date: {
      type: String,
      required: true
    }
  },
  methods: {
    subtractDate: function(date) {
      var now = new Date();
      var target = new Date(date.replace(/-/g, "/"));
      var timestamp = Math.floor(now.getTime() / 1000 - target.getTime() / 1000);
      if (timestamp < 60) return timestamp + ' 秒前';
      if (timestamp < 3600) return Math.floor(timestamp / 60) + ' 分前 ';
      if (timestamp < 86400) return Math.floor(timestamp / 3600) + ' 時間前';
      return Math.floor(timestamp / 86400) + ' 日前';
    },
  }
}
</script>
