Vue.component('alert', require('./components/Alert.vue'));

Vue.filter('currency', (value) => {
    return formatAsCurrency(value);
});
