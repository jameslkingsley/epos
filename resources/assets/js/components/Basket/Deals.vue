<template>
    <md-table>
        <md-table-header>
            <md-table-row>
                <md-table-head>Deal</md-table-head>
                <md-table-head md-numeric>Discount</md-table-head>
            </md-table-row>
        </md-table-header>

        <md-table-body>
            <md-table-row v-for="(deal, index) in basket.deals" :key="index">
                <md-table-cell>{{ deal.name }}</md-table-cell>
                <md-table-cell md-numeric>{{ deal.discount }}</md-table-cell>
            </md-table-row>
        </md-table-body>
    </md-table>
</template>

<script>
    export default {
        props: ['basket']
    }
</script>
