import Vue from 'vue';
import Vuex from 'vuex';
import router from '../router';
import alert from "./modules/alert";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    token: null,
    i: null
  },
  mutations: {
    login(state, payload) {
      state.token = payload.access_token;
      state.i = payload.user;
    },
    logout(state) {
      state.token = null;
      state.i = null;
    }
  },
  getters: {
    isLogin(state) {
      return state.token ? true : false;
    }
  },
  actions: {
    login({ commit }, payload) {
      axios.post('/api/login', {
        screen_name: payload.id,
        password: payload.password
      }).then(res => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + res.data.access_token;
        commit('login', res.data);
        router.push({ path: '/' });
        commit('alert/setAlert', {
          'message': 'ログインしました。'
        }, { root: true });
      }).catch(error => {
        commit('alert/setAlert', {
          'message': 'ログインに失敗しました。',
          'type': 'danger'
        }, { root: true });
      });
    },
    logout({ commit }) {
      axios.post('/api/logout').then(res => {
        axios.defaults.headers.common['Authorization'] = '';
        commit('logout');
        router.push({ path: '/' });
        commit('alert/setAlert', {
          'message': 'ログアウトしました。'
        }, { root: true });
      }).catch(error => {
        commit('alert/setAlert', {
          'message': 'ログアウトに失敗しました。'
        }, { root: true });
      });
    }
  },
  modules: {
    alert
  }
});