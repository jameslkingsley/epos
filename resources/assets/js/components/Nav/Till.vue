<template>
    <md-menu md-size="6">
        <md-button md-menu-trigger class="md-icon-button">
            <md-icon>apps</md-icon>
        </md-button>

        <md-menu-content class="app-nav">
            <md-layout md-gutter>
                <md-layout>
                    <router-link class="app-nav-item" to="/">
                        Till
                    </router-link>
                </md-layout>

                <md-layout>
                    <router-link class="app-nav-item" to="/admin">
                        Admin
                    </router-link>
                </md-layout>
            </md-layout>
        </md-menu-content>
    </md-menu>
</template>

<script>
    export default {
        methods: {
            handle() {
                this.$router.push('/');
            }
        }
    }
</script>
