<template>
    <div class="container">
        <alert />

        <md-toolbar class="md-dense">
            <nav-till />

            <h2 class="md-title" style="flex: 1">
                <clock />
            </h2>

            <md-menu md-direction="bottom left">
                <md-button md-menu-trigger class="md-icon-button">
                    <md-icon>filter_list</md-icon>
                </md-button>

                <md-menu-content>
                    <md-menu-item v-for="(mode, name) in basket.modes" @click.native="changeMode(mode)">
                        {{ name }}
                    </md-menu-item>
                </md-menu-content>
            </md-menu>

            <md-button class="md-icon-button" @click.native="destroyBasket">
                <md-icon>delete</md-icon>
            </md-button>
        </md-toolbar>

        <categories></categories>

        <div class="page-content">
            <div class="main-content">
                <items v-show="!checkout"></items>
                <checkout v-show="checkout"></checkout>
            </div>
        </div>

        <basket></basket>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                app: window.epos.app,
                checkout: false,
                basket: {}
            }
        },

        methods: {
            changeMode(mode) {
                this.$http.put('/api/basket/mode/' + mode);
            },

            destroyBasket() {
                this.$http.delete('/api/basket');
            }
        },

        created() {
            Event.listen('checkout', state => this.checkout = state);

            Echo.channel('basket')
                .listen('BasketReload', (e) => {
                    this.basket = e.basket;
                });
        }
    }
</script>
