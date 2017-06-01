import VueRouter from 'vue-router';

export default new VueRouter({
    routes: [
        {
            path: '/',
            component: require('./views/Till')
        },

        {
            path: '/login',
            component: require('./views/Login')
        },

        {
            path: '/admin',
            component: require('./views/Admin')
        },

        {
            path: '/transactions',
            component: require('./views/Transactions')
        }
    ]
});
