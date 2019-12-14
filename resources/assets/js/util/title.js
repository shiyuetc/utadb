export default {
  methods: {
    updateTitle(str) {
      if(str) {
        document.title = `${str} - ${process.env.MIX_APP_NAME}`;
      } else {
        document.title = process.env.MIX_APP_NAME;
      }
      document.querySelectorAll(".update-title").forEach((it) => {
        it.innerHTML = str;
      });
    }
  },
  mounted() {
    if (this.$options.title !== undefined) {
      this.updateTitle(this.$options.title());
    }
  }
};