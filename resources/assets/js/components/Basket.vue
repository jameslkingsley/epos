<template>
    <md-sidenav md-fixed class="md-right main-sidebar" ref="rightSidenav" v-if="loaded">
        <div class="main-sidebar-links">
            <basket-items :basket="basket" />
            <basket-summary :basket="basket" />
            <basket-payments :basket="basket" />
            <basket-vat :basket="basket" />

            <md-bottom-bar>
                <md-bottom-bar-item md-icon="refresh" @click.native="emptyBasket">Empty</md-bottom-bar-item>
                <md-bottom-bar-item md-icon="check" md-active @click.native="checkout">Checkout</md-bottom-bar-item>
                <md-bottom-bar-item md-icon="print">Receipt</md-bottom-bar-item>
            </md-bottom-bar>
        </div>
    </md-sidenav>
</template>

<script>
    export default {
        data() {
            return {
                basket: {},
                loaded: false
            };
        },

        methods: {
            selected(item) {
                this.$http.post('/api/basket-items', item);
            },

            emptyBasket() {
                this.$http.delete('/basket');
            },

            checkout() {
                Event.fire('checkout', true);
            }
        },

        mounted() {
            Event.listen(
                'item-select',
                item => this.selected(item)
            );

            Echo.channel('basket')
                .listen('BasketReload', (e) => {
                    this.basket = e.basket;
                    this.loaded = true;
                    console.log(e);
                })
                .listen('TransactionStarted', (e) => {
                    this.$material.setCurrentTheme('default');
                    console.log(e);
                })
                .listen('TransactionCompleted', (e) => {
                    this.$material.setCurrentTheme('success');
                    this.basket = e.basket;
                    console.log(e);
                });
        }
    }
</script>
