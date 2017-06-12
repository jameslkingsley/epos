<template>
    <md-theme md-name="admin">
        <div class="container">
            <alert />

            <md-toolbar class="md-dense">
                <nav-till />

                <h2 class="md-title" style="flex: 1">
                    Admin
                </h2>
            </md-toolbar>

            <md-sidenav md-fixed class="md-left main-sidebar" ref="leftSidenav">
                <div class="main-sidebar-links" style="background: white">
                    <md-list>
                        <md-list-item>
                            <router-link to="/admin/transactions">
                                Transactions
                            </router-link>
                        </md-list-item>

                        <md-list-item>
                            <router-link to="/admin/inventory">
                                Inventory
                            </router-link>
                        </md-list-item>
                    </md-list>
                </div>
            </md-sidenav>

            <div class="admin-page-content">
                <router-view></router-view>
            </div>
        </div>
    </md-theme>
</template>

<script>
    export default {
        //
    }
</script>
