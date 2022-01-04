import Vue from "vue";
window.Vue = require('vue');

window.halfmoon = require("halfmoon");
window.$ = window.jQuery = require('jquery');
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.config.productionTip = false;

Vue.config.devtools = true;
Vue.config.performance = true;

const app = new Vue({
  el: '#app',
});
