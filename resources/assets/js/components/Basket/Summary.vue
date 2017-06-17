<template>
    <md-table>
        <md-table-header>
            <md-table-row>
                <md-table-head>Summary</md-table-head>
                <md-table-head md-numeric>Amount</md-table-head>
            </md-table-row>
        </md-table-header>

        <md-table-body>
            <!-- <md-table-row>
                <md-table-cell>Items</md-table-cell>
                <md-table-cell md-numeric>{{ basket.summaries.balance.items | currency }}</md-table-cell>
            </md-table-row> -->

            <md-table-row v-show="basket.summaries.balance.due_from_customer > 0">
                <md-table-cell>Due From Customer</md-table-cell>
                <md-table-cell md-numeric>{{ basket.summaries.balance.due_from_customer | currency }}</md-table-cell>
            </md-table-row>

            <md-table-row v-show="basket.summaries.balance.due_from_customer <= 0">
                <md-table-cell>Due To Customer</md-table-cell>
                <md-table-cell md-numeric>{{ basket.summaries.balance.due_to_customer | currency }}</md-table-cell>
            </md-table-row>
        </md-table-body>
    </md-table>
</template>

<script>
    export default {
        props: ['basket']
    }
</script>
