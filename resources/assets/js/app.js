
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

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('user-statuses-component', require('./components/user-statuses.vue'));
Vue.component('timeline-component', require('./components/timeline.vue'));

Vue.component('search-song-component', require('./components/search-song.vue'));

Vue.component('song-infomation-component', require('./components/song-infomation.vue'));

const app = new Vue({
    el: '#app'
});
