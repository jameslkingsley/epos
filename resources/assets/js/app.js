require('./bootstrap');

// Components
Vue.component('products', require('./components/Products.vue'));
Vue.component('categories', require('./components/Categories.vue'));
Vue.component('basket', require('./components/Basket.vue'));
Vue.component('product', require('./components/Product.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));

const app = new Vue({
    el: '#app'
});
