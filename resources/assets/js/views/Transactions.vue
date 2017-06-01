<template>
    <div class="container">
        <md-toolbar class="md-dense">
            <nav-till />

            <h2 class="md-title" style="flex: 1">
                Transactions
            </h2>
        </md-toolbar>

        <div class="page-content">
            <div class="main-content">
                <md-table v-for="(header, index) in headers" :key="index">
                    <md-table-header>
                        <md-table-row>
                            <md-table-head>Transaction</md-table-head>
                            <md-table-head md-numeric>Net</md-table-head>
                            <md-table-head md-numeric>VAT</md-table-head>
                            <md-table-head md-numeric>Gross</md-table-head>
                            <md-table-head md-numeric>Discount</md-table-head>
                        </md-table-row>
                    </md-table-header>

                    <md-table-body>
                        <md-table-row>
                            <md-table-cell>
                                {{ header.created_at }} &mdash;
                                {{ header.items.length }} Items &middot;
                                {{ header.deals.length }} Deals &middot;
                                {{ header.payments.length }} Payments
                            </md-table-cell>

                            <md-table-cell md-numeric>{{ header.net }}</md-table-cell>
                            <md-table-cell md-numeric>{{ header.vat }}</md-table-cell>
                            <md-table-cell md-numeric>{{ header.gross }}</md-table-cell>
                            <md-table-cell md-numeric>{{ header.discount }}</md-table-cell>
                        </md-table-row>
                    </md-table-body>

                    <md-table-header>
                        <md-table-row>
                            <md-table-head>Item</md-table-head>
                            <md-table-head md-numeric>Qty</md-table-head>
                            <md-table-head md-numeric>Net</md-table-head>
                            <md-table-head md-numeric>VAT</md-table-head>
                            <md-table-head md-numeric>Gross</md-table-head>
                        </md-table-row>
                    </md-table-header>

                    <md-table-body>
                        <md-table-row v-for="(item, index) in header.items" :key="index">
                            <md-table-cell>
                                {{ item.model.title }}
                            </md-table-cell>

                            <md-table-cell md-numeric>{{ item.qty }}</md-table-cell>
                            <md-table-cell md-numeric>{{ item.net }}</md-table-cell>
                            <md-table-cell md-numeric>{{ item.vat }}</md-table-cell>
                            <md-table-cell md-numeric>{{ item.gross }}</md-table-cell>
                        </md-table-row>
                    </md-table-body>
                </md-table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                headers: []
            };
        },

        created() {
            this.$http.get('/api/transactions')
                .then(response => {
                    this.headers = response.body;
                });
        }
    }
</script>
