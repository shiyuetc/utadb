import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'welcome',
    component: require('./components/pages/Welcome.vue'),
    meta: { requiresGuest: true }
  },
  {
    path: '/',
    name: 'home',
    component: require('./components/pages/Home.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/register',
    name: 'register',
    component: require('./components/pages/Register.vue'),
    meta: { requiresGuest: true }
  },
  {
    path: '/login',
    name: 'login',
    component: require('./components/pages/Login.vue'),
    meta: { requiresGuest: true }
  },
];

const router = new VueRouter({
  mode: 'history',
  routes,
})

router.beforeEach((to, from, next) => {
  store.commit('alert/setAlert', { 'message': '' });
  var next_flag = true;
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!store.getters.isLogin) {
      next_flag = false;
      next({ name: 'login' });
    }
  } else if (to.matched.some(record => record.meta.requiresGuest)) {
    if (store.getters.isLogin) {
      next_flag = false;
      next({ name: 'home' });
    }
  }
  if(next_flag) {
    next();
  }
});

export default router;