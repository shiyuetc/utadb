import router from '../../router';

const state = {
  token: '',
  user: null
};

const mutations = {
  login(state, payload) {
    state.token = payload.access_token;
    state.user = payload.user;
  },
  logout(state) {
    state.token = null;
  }
};

const getters = {
  isLogin(state) {
    return state.token ? true : false;
  }
};

const actions = {
  login({ commit }, payload) {
    axios.post('/api/login', {
      id: payload.id,
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
};

export default {
  namespaced: true,
  state,
  mutations,
  getters,
  actions
};