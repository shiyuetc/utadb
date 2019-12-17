import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'home',
    component: require('./components/pages/Home.vue'),
  },
  {
    path: '/register',
    name: 'register',
    component: require('./components/pages/Register.vue'),
  },
];

const router = new VueRouter({
  mode: 'history',
  routes,
})

router.beforeEach((to, from, next) => {
  store.commit('alert/setAlert', { 'message': '' });
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!store.getters.isLogin) {
      next({
        path: '/login',
        query: {
          redirect: to.fullPath
        }
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;