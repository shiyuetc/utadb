/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import router from './router';
import titleUtil from './util/title';
import store from './store';

require('./bootstrap');

Vue.mixin(titleUtil);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
  router,
  store,
  methods: {
    buildQuery: function (data) {
      if (data.length == 0) return '';
      var query = '?';
      Object.keys(data).forEach(function (key) {
        query += key + '=' + this[key] + '&'
      }, data);
      return query;
    }
  },
  render: h => h(require('./components/App.vue')),
});