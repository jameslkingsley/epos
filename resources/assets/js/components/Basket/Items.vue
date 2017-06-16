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
            <md-table-row v-for="(item, index) in basket.items" :key="index" @click.native="showOptions(item, index)">
                <md-table-cell>{{ item.model.name }}</md-table-cell>
                <md-table-cell md-numeric>{{ item.qty }}</md-table-cell>
                <md-table-cell md-numeric>{{ item.qty * item.model.gross | currency }}</md-table-cell>
            </md-table-row>
        </md-table-body>
    </md-table>
</template>

<script>
    export default {
        props: ['basket'],

        data() {
            return {
                options: {
                    product: [
                        {text: 'Add One', action(e) {
                            Event.fire('item-select', e.data.item);
                            Event.fire('alert', e.data.item.model.name + ' added');
                        }},

                        {text: 'Add Many', autoClose: true, action(e) {
                            new Keypad({
                                minimum: 1,
                                currency: null
                            }).open().then(value => {
                                e.$http.post('/api/items/add-many/' + value, e.data.item);
                                Event.fire('alert', e.data.item.model.name + ' added ' + value + ' times');
                            });
                        }},

                        {text: 'Remove One', action(e) {
                            e.$http.delete('/api/items/' + e.data.item.id + '/1');
                            Event.fire('alert', '1 ' + e.data.item.model.name + ' removed');
                        }},

                        {text: 'Remove All', autoClose: true, action(e) {
                            e.$http.delete('/api/items/' + e.data.item.id);
                            Event.fire('alert', 'All ' + e.data.item.model.name + ' removed');
                        }}
                    ]
                }
            };
        },

        methods: {
            showOptions(item, index) {
                let model = item.model_type.split('\\').pop().toLowerCase();

                if (model in this.options) {
                    new Actions({
                        options: this.options[model],
                        data: { item: item }
                    }).open();
                }
            }
        }
    }
</script>
