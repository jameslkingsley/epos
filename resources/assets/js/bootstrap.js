const modules = [
    'Payments',
    'Printers',
    'Support',
    'UI'
];

// Lodash
window._ = require('lodash');

// Axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.epos.csrfToken;
window.ajax = window.axios;

// Collect
window.collect = require('collect.js');

// Vue
window.Vue = require('vue');
require('vue-resource');

// Vue Router
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Vue Material Design
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
        primary: 'blue',
        accent: 'blue'
    }
});

// AJAX Defaults
Vue.http.headers.common['X-CSRF-TOKEN'] = window.epos.csrfToken;
Vue.http.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Load Modules
for (let m of modules) {
    require('./modules/' + m + '/index.js');
}

// Barcode
import VueBarcodeScanner from 'vue-barcode-scanner';
Vue.use(VueBarcodeScanner);

// Websocket
window.Pusher = require('pusher-js');
import Echo from 'laravel-echo';
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: epos.app.broadcasting.key,
    cluster: epos.app.broadcasting.options.cluster
});
