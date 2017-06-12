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
            path: '/sandbox',
            component: require('./views/Sandbox')
        },

        {
            path: '/admin',
            component: require('./views/Admin'),
            children: [
                {
                    path: 'transactions',
                    component: require('./admin/Transactions')
                },
                {
                    path: 'inventory',
                    component: require('./admin/Inventory')
                }
            ]
        }
    ]
});
