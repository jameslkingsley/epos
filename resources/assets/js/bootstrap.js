window._ = require('lodash');

window.Vue = require('vue');
require('vue-resource');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

var VueMaterial = require('vue-material');
require('vue-material/dist/vue-material.css');
Vue.use(VueMaterial);

Vue.material.registerTheme({
    default: {
        primary: 'indigo',
        accent: 'indigo'
    },

    success: {
        primary: 'green',
        accent: 'green'
    }
});

Vue.http.headers.common['X-CSRF-TOKEN'] = window.epos.csrfToken;
Vue.http.headers.common['X-Requested-With'] = 'XMLHttpRequest';

require('./support/event.js');
require('./support/errors.js');
require('./support/form.js');

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '648cf3562bf2244772cf',
    cluster: 'eu'
});
