// Lodash
window._ = require('lodash');

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

// Helpers
require('./support/event.js');
require('./support/errors.js');
require('./support/form.js');
require('./support/currency.js');

// Barcode
import VueBarcodeScanner from 'vue-barcode-scanner';
Vue.use(VueBarcodeScanner);

require('./support/settings.js');
window.epos.settings = new Settings().register(window.epos.settings);
window.setting = (name) => {
    return window.epos.settings.get(name);
}

// Keypad
require('./keypad.js');
window.KeypadOptions = {
    currency: window.epos.app.currency
};

// Keyboard
require('./keyboard.js');
window.KeyboardOptions = {
    //
};

// Actions
require('./actions.js');

// Printers
window.Printer = require('./printers/printer.js');

// Payments
window.Payment = require('./payments/payment.js');

// Websocket
window.Pusher = require('pusher-js');
import Echo from 'laravel-echo';
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: epos.app.broadcasting.key,
    cluster: epos.app.broadcasting.options.cluster
});
