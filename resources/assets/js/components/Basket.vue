<template>
    <md-sidenav md-fixed class="md-right main-sidebar" ref="rightSidenav">
        <div class="main-sidebar-links">
            <md-table>
                <md-table-header>
                    <md-table-row>
                        <md-table-head>Description</md-table-head>
                        <md-table-head md-numeric>Qty</md-table-head>
                        <md-table-head md-numeric>Price</md-table-head>
                    </md-table-row>
                </md-table-header>

                <md-table-body>
                    <md-table-row v-for="(item, index) in basket.items" :key="index">
                        <md-table-cell>{{ item.model.title }}</md-table-cell>
                        <md-table-cell md-numeric>{{ item.qty }}</md-table-cell>
                        <md-table-cell md-numeric>{{ (item.qty * item.model.retail_price).toFixed(2) }}</md-table-cell>
                    </md-table-row>
                </md-table-body>

                <md-table-header>
                    <md-table-row class="text-primary">
                        <md-table-head>&nbsp;</md-table-head>
                        <md-table-head md-numeric class="text-primary">{{ basket.itemCount }}</md-table-head>
                        <md-table-head md-numeric class="text-primary">{{ basket.balance }}</md-table-head>
                    </md-table-row>
                </md-table-header>
            </md-table>

            <md-table>
                <md-table-header>
                    <md-table-row>
                        <md-table-head>VAT Breakdown</md-table-head>
                        <md-table-head md-numeric>Net</md-table-head>
                        <md-table-head md-numeric>Gross</md-table-head>
                    </md-table-row>
                </md-table-header>

                <md-table-body>
                    <md-table-row v-for="(vat, key) in basket.vatBreakdown" :key="key">
                        <md-table-cell>{{ key }}%</md-table-cell>
                        <md-table-cell md-numeric>{{ basket.vatBreakdown[key].net }}</md-table-cell>
                        <md-table-cell md-numeric>{{ basket.vatBreakdown[key].gross }}</md-table-cell>
                    </md-table-row>
                </md-table-body>
            </md-table>

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
                basket: {}
            };
        },

        methods: {
            reload() {
                this.$http.get('/api/basket')
                    .then(response => this.basket = response.body);
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

        created() {
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
