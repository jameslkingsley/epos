window._ = require('lodash');

window.Vue = require('vue');
require('vue-resource');

var VueMaterial = require('vue-material');
require('vue-material/dist/vue-material.css');
Vue.use(VueMaterial);

// Vue.material.registerTheme('default', {
//     primary: 'blue',
//     accent: 'red',
//     warn: 'red',
//     background: 'white'
// });

Vue.http.headers.common['X-CSRF-TOKEN'] = window.epos.csrfToken;
Vue.http.headers.common['X-Requested-With'] = 'XMLHttpRequest';

require('./support/event.js');
require('./support/errors.js');
require('./support/form.js');
