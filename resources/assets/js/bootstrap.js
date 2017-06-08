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
        primary: {
            color: 'light-green',
            hue: 700
        },
        accent: 'black'
    },

    admin: {
        primary: 'blue-grey',
        accent: 'black'
    },

    refund: {
        primary: {
            color: 'deep-orange',
            hue: 800
        },
        accent: 'black'
    },

    staff: {
        primary: 'black',
        accent: 'black'
    },

    debug: {
        primary: 'red',
        accent: 'red'
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
