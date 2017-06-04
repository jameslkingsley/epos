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
                <md-whiteframe>
                    <md-list>
                        <md-list-item md-expand-multiple v-for="(header, index) in headers" :key="index">
                            <span class="flex f1 align-right">
                                <strong class="text-primary">{{ header.timestamp }}</strong>

                                <pill class="flex push-left" right primary>
                                    {{ header.due_from_customer }}
                                </pill>
                            </span>

                            <md-list-expand>
                                <md-table @sort="sort">
                                    <md-table-header>
                                        <md-table-row>
                                            <md-table-head>Description</md-table-head>
                                            <md-table-head width="100" md-numeric>Qty</md-table-head>
                                            <md-table-head width="100" md-numeric>Net</md-table-head>
                                            <md-table-head width="100" md-numeric>VAT</md-table-head>
                                            <md-table-head width="100" md-numeric>Gross</md-table-head>
                                        </md-table-row>
                                    </md-table-header>

                                    <md-table-body>
                                        <md-table-row v-for="(item, index) in header.items" :key="index">
                                            <md-table-cell>
                                                ITEM &mdash; {{ item.model.title }}
                                            </md-table-cell>

                                            <md-table-cell md-numeric>{{ item.qty }}</md-table-cell>
                                            <md-table-cell md-numeric>{{ item.net_total }}</md-table-cell>
                                            <md-table-cell md-numeric>{{ item.vat_total }}</md-table-cell>
                                            <md-table-cell md-numeric>{{ item.gross_total }}</md-table-cell>
                                        </md-table-row>

                                        <md-table-row v-for="(deal, index) in header.deals" :key="index">
                                            <md-table-cell>
                                                DEAL &mdash; {{ deal.title }}
                                            </md-table-cell>

                                            <md-table-cell md-numeric colspan="4">{{ deal.discount_total }}</md-table-cell>
                                        </md-table-row>

                                        <md-table-row v-for="(payment, index) in header.payments" :key="index">
                                            <md-table-cell>
                                                PAYMENT &mdash; {{ payment.title }}
                                            </md-table-cell>

                                            <md-table-cell md-numeric colspan="4">{{ payment.amount_total }}</md-table-cell>
                                        </md-table-row>
                                    </md-table-body>

                                    <md-table-header>
                                        <md-table-row>
                                            <md-table-head width="100" md-numeric colspan="3">Due</md-table-head>
                                            <md-table-head width="100" md-numeric>Took</md-table-head>
                                            <md-table-head width="100" md-numeric>Change</md-table-head>
                                        </md-table-row>
                                    </md-table-header>

                                    <md-table-body>
                                        <md-table-row>
                                            <md-table-cell md-numeric colspan="3">{{ header.due_from_customer }}</md-table-cell>
                                            <md-table-cell md-numeric>{{ header.payment_total }}</md-table-cell>
                                            <md-table-cell md-numeric>{{ header.due_to_customer }}</md-table-cell>
                                        </md-table-row>
                                    </md-table-body>
                                </md-table>
                            </md-list-expand>
                        </md-list-item>
                    </md-list>
                </md-whiteframe>
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

        methods: {
            sort(sort) {
                console.log(sort);
                // this.headers = _.orderBy(this.headers, [item => item[sort.name]], sort.type);
            }
        },

        created() {
            this.$http.get('/api/transactions')
                .then(response => {
                    this.headers = response.body;
                });
        }
    }
</script>
