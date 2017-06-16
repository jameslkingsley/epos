<template>
    <md-table>
        <md-table-header>
            <md-table-row>
                <md-table-head>Payment</md-table-head>
                <md-table-head md-numeric>&nbsp;</md-table-head>
                <md-table-head md-numeric>Amount</md-table-head>
            </md-table-row>
        </md-table-header>

        <md-table-body>
            <md-table-row
                v-for="(payment, index) in basket.payments"
                :key="index"
                @click.native="showOptions(payment, index)">
                <md-table-cell>{{ payment.name }}</md-table-cell>
                <md-table-cell>&nbsp;</md-table-cell>
                <md-table-cell md-numeric>{{ payment.amount_normal }}</md-table-cell>
            </md-table-row>
        </md-table-body>
    </md-table>
</template>

<script>
    export default {
        props: ['basket'],

        data() {
            return {
                options: [
                    {text: 'Remove', action(e) {
                        e.$http.delete('/api/payments/' + e.data.payment.id);
                        Event.fire('alert', e.data.payment.name + ' payment removed');
                    }}
                ]
            };
        },

        methods: {
            showOptions(payment, index) {
                new Actions({
                    options: this.options,
                    data: { payment: payment },
                    autoClose: true
                }).open();
            }
        }
    }
</script>
