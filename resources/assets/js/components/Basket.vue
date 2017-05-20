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
                        <md-table-cell md-numeric>{{ item.model.retail_price }}</md-table-cell>
                    </md-table-row>
                </md-table-body>
            </md-table>

            <md-bottom-bar>
                <md-bottom-bar-item md-icon="refresh" @click.native="emptyBasket">Empty</md-bottom-bar-item>
                <md-bottom-bar-item md-icon="check" md-active>Checkout</md-bottom-bar-item>
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
