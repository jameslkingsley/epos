<template>
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
                <md-table-cell>{{ item.title }}</md-table-cell>
                <md-table-cell md-numeric>{{ item.qty }}</md-table-cell>
                <md-table-cell md-numeric>{{ item.amount }}</md-table-cell>
            </md-table-row>
        </md-table-body>
    </md-table>
</template>

<script>
    export default {
        props: ['basket']
    }
</script>
