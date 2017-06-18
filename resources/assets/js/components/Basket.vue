<template>
    <md-sidenav md-fixed class="md-right main-sidebar" ref="rightSidenav">
        <div class="main-sidebar-links">
            <div v-if="loaded">
                <basket-items :basket="basket" />
                <basket-deals :basket="basket" />
                <basket-payments :basket="basket" />
                <basket-summary :basket="basket" />
                <basket-vat :basket="basket" />
            </div>

            <md-bottom-bar>
                <md-bottom-bar-item md-icon="refresh" @click.native="emptyBasket">Empty</md-bottom-bar-item>
                <md-bottom-bar-item md-icon="check" md-active @click.native="checkout">Checkout</md-bottom-bar-item>
                <md-bottom-bar-item md-icon="print" @click.native="printReceipt">Receipt</md-bottom-bar-item>
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
                this.$http.post('/api/items', item);
            },

            emptyBasket() {
                this.$http.delete('/api/basket');
            },

            checkout() {
                Event.fire('checkout', true);
            },

            reloadBasket() {
                this.$http.get('/api/basket');
            },

            printReceipt() {
                this.$http.get('/api/receipt');
            },

            modeTheme() {
                return _.findKey(this.basket.modes, (i) => {
                    return i == this.basket.meta.mode;
                }).toLowerCase();
            }
        },

        mounted() {
            Event.listen(
                'item-select',
                item => this.selected(item)
            );

            Event.listen(
                'barcode-scanned',
                code => this.$http.post('/api/items/via-barcode', { code })
            );

            Echo.channel('basket')
                .listen('BasketReload', (e) => {
                    this.basket = e.basket;
                    this.loaded = true;

                    // Set the overall theme to match the basket mode
                    this.$material.setCurrentTheme(this.modeTheme());
                })
                .listen('BasketException', (e) => {
                    Event.fire('alert', e.message);
                })
                .listen('BasketModeChanged', (e) => {
                    //
                })
                .listen('PrintReceipt', (e) => {
                    new Printer[e.printer](e.transaction).render();
                })
                .listen('PaymentService', (e) => {
                    let service = new Payment[e.service.name + 'Service'](e.service.payment);
                    service.handle();
                })
                .listen('TransactionStarted', (e) => {
                    this.$material.setCurrentTheme('default');
                })
                .listen('TransactionCompleted', (e) => {
                    this.$material.setCurrentTheme('success');
                    this.basket = e.basket;
                });
        },

        created() {
            setTimeout(this.reloadBasket, 250);

            this.$barcodeScanner.init(
                code => Event.fire('barcode-scanned', code)
            );
        },

        destroyed() {
            this.$barcodeScanner.destroy();
        }
    }
</script>
