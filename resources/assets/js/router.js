import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [{
  path: '/',
  name: 'home',
  component: require('./components/Home.vue')
}];

const router = new VueRouter({
  mode: 'history',
  routes,
})

router.beforeEach((to, from, next) => {
  store.commit('alert/setAlert', {
    'message': ''
  });
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!store.getters['auth/isLogin']) {
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