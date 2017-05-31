import './bootstrap';
import router from './routes';

// Components
Vue.component('basket-deals', require('./components/Basket/Deals.vue'));
Vue.component('alert', require('./components/Alert.vue'));
Vue.component('nav-till', require('./components/Nav/Till.vue'));
Vue.component('basket-items', require('./components/Basket/Items.vue'));
Vue.component('basket-vat', require('./components/Basket/VAT.vue'));
Vue.component('basket-payments', require('./components/Basket/Payments.vue'));
Vue.component('basket-summary', require('./components/Basket/Summary.vue'));
Vue.component('payments-fastcash', require('./components/Payments/FastCash.vue'));
Vue.component('payments-cash', require('./components/Payments/Cash.vue'));
Vue.component('payments-card', require('./components/Payments/Card.vue'));
Vue.component('checkout', require('./components/Checkout.vue'));
Vue.component('models-payment', require('./components/Models/Payment.vue'));
Vue.component('models-product', require('./components/Models/Product.vue'));
Vue.component('clock', require('./components/Clock.vue'));
Vue.component('items', require('./components/Items.vue'));
Vue.component('categories', require('./components/Categories.vue'));
Vue.component('basket', require('./components/Basket.vue'));
Vue.component('item', require('./components/Item.vue'));

const app = new Vue({
    el: '#app',
    router
});
