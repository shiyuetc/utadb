<template>
  <div>
    <button v-show="!isFollowing" @click="onFollowChange" :disabled="wait" class="button button-default"><i class="fas fa-user-plus"></i>&nbsp;フレンドに追加</button>
    <button v-show="isFollowing && !mouseIn" @click="onFollowChange" @mouseover="mouseOver" @mouseleave="buttonLock = false;" :disabled="wait" class="button button-info"><i class="fas fa-user-friends"></i>&nbsp;フレンドに追加済み</button>
    <button v-show="isFollowing && mouseIn" @click="onFollowChange" @mouseleave="mouseIn = false;" :disabled="wait" class="button button-danger"><i class="fas fa-user-times"></i>&nbsp;フレンドを解除</button>
  </div>
</template>
<script>
export default {
  props: {
    user: {
      type: Object,
      required: true
    },
    is_following: {
      type: Boolean,
      required: false,
      default: false
    }
  },
  data() {
    return {
      wait: false,
      isFollowing: this.is_following,
      mouseIn: false,
      buttonLock: false
    }
  },
  methods: {
    onFollowChange: function() {
      if(this.wait) return;
      this.wait = true;
      
      if(!this.isFollowing) {
        var action = 'create';
        this.isFollowing = true;
        this.buttonLock = true;
      } else {
        var action = 'destroy';
        this.isFollowing = false;
      }
      axios.post("/api/friends/" + action, { id:this.user.id }).then(res => {
        
      }).catch(err => {
        if(err.response.status === 403) {
          window.location.href = "/login";
        }
      });
      this.wait = false;
    },
    mouseOver: function() {
      if(!this.buttonLock)
        this.mouseIn = true;
    }
  }
}
</script>
