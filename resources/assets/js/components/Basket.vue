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
            reload() {
                this.$http.get('/api/basket')
                    .then(response => {
                        this.basket = response.body;
                        this.loaded = true;
                    });
            },

            selected(item) {
                this.$http.post('/api/basket-items', item)
                    .then(response => this.reload());
            },

            emptyBasket() {
                this.$http.delete('/basket')
                    .then(response => Event.fire('basket-reload', response.body));
            },

            checkout() {
                Event.fire('checkout', true);
            }
        },

        mounted() {
            this.reload();

            Event.listen(
                'item-select',
                item => this.selected(item)
            );

            Event.listen(
                'basket-reload',
                () => this.reload()
            );
        }
    }
</script>
