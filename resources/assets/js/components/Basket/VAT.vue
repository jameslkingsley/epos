<template>
    <md-table>
        <md-table-header>
            <md-table-row>
                <md-table-head>VAT Breakdown</md-table-head>
                <md-table-head md-numeric>Net</md-table-head>
                <md-table-head md-numeric>Gross</md-table-head>
            </md-table-row>
        </md-table-header>

        <md-table-body>
            <md-table-row v-for="(vat, key) in basket.summaries.vat" :key="key">
                <md-table-cell>{{ key }}%</md-table-cell>
                <md-table-cell md-numeric>{{ basket.summaries.vat[key].net | currency }}</md-table-cell>
                <md-table-cell md-numeric>{{ basket.summaries.vat[key].gross | currency }}</md-table-cell>
            </md-table-row>
        </md-table-body>
    </md-table>
</template>

<script>
    export default {
        props: ['basket']
    }
</script>
