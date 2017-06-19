import VueRouter from 'vue-router';

export default new VueRouter({
    routes: [
        {
            path: '/',
            component: require('../views/Admin'),
            children: [
                {
                    path: 'transactions',
                    component: require('../admin/Transactions')
                },
                {
                    path: 'inventory',
                    component: require('../admin/Inventory')
                }
            ]
        }
    ]
});
