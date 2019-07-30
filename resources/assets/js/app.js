
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('analysis-chart-component', require('./components/analysis-chart.vue'));
Vue.component('avatar-categories-component', require('./components/avatar-categories.vue'));
Vue.component('notification-component', require('./components/notification.vue'));
Vue.component('resource-counter-component', require('./components/resource-counter.vue'));

Vue.component('timeline-component', require('./components/timeline.vue'));
Vue.component('song-ranking-component', require('./components/song-ranking.vue'));
Vue.component('song-recent-component', require('./components/song-recent.vue'));
Vue.component('song-search-component', require('./components/song-search.vue'));
Vue.component('song-from-artist-component', require('./components/song-from-artist.vue'));
Vue.component('song-user-component', require('./components/song-user.vue'));
Vue.component('song-common-component', require('./components/song-common.vue'));
Vue.component('song-infomation-component', require('./components/song-infomation.vue'));

Vue.component('user-search-component', require('./components/user-search.vue'));

const app = new Vue({
    el: '#app',
    methods: {
        buildQuery: function(data) {
            var query = '?';
            Object.keys(data).forEach(function(key) {
                query += key + '=' + this[key] + '&'
            }, data);
            return query;
        }
    }
});
