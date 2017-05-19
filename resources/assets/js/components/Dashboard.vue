<template>
    <div class="dashboard">
        <categories>
            <div class="logo">
                <a :href="app.url" class="simple-text">
                    <clock></clock>
                </a>
            </div>
        </categories>

        <div class="main-panel">
            <nav class="navbar navbar-default" style="width: calc(100% - 25vw)">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" @click.prevent="emptyBasket">Empty Basket</a>
                    </div>
                </div>
            </nav>

            <div class="content" style="width: calc(100% - 25vw)">
                <div class="container-fluid p-a-0">
                    <items></items>
                </div>
            </div>

            <div class="sidebar sidebar-right" data-background-color="white" data-active-color="danger">
                <div class="sidebar-wrapper w-100 p-a-2">
                    <basket></basket>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                app: window.epos.app
            }
        },

        methods: {
            emptyBasket() {
                this.$http.delete('/basket')
                    .then(response => Event.fire('basket-reload', response.body));
            }
        }
    }
</script>
