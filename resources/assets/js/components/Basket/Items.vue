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
                <md-table-cell>{{ item.title }}</md-table-cell>
                <md-table-cell md-numeric>{{ item.qty }}</md-table-cell>
                <md-table-cell md-numeric>{{ item.amount }}</md-table-cell>
            </md-table-row>

            <md-dialog ref="itemOptions">
                <md-dialog-title>Actions</md-dialog-title>

                <md-dialog-content>
                    <md-button class="md-raised md-primary" v-for="(item, index) in activeOption.model" :key="index" @click.native="item.action(activeOption.args, $http)">
                        {{ item.text }}
                    </md-button>
                </md-dialog-content>

                <md-dialog-actions>
                    <md-button class="md-primary" @click.native="$refs.itemOptions.close">Close</md-button>
                </md-dialog-actions>
            </md-dialog>
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
                        {text: 'Add One', action(item, http) {
                            Event.fire('item-select', item);
                        }},

                        {text: 'Add Many', action(item, http) {
                            let count = prompt('Enter Count', '1');

                            if (count != null && count > 0) {
                                http.post('/api/items/add-many/' + count, item);
                            }
                        }},

                        {text: 'Remove One', action(item, http) {
                            http.delete('/api/items/' + item.id + '/1');
                        }},

                        {text: 'Remove All', action(item, http) {
                            http.delete('/api/items/' + item.id);
                        }}
                    ]
                },

                activeOption: {
                    model: [],
                    args: {}
                }
            };
        },

        computed: {
            hasActiveOption() {
                return _.keys(this.activeOption).length > 0;
            }
        },

        methods: {
            showOptions(item, index) {
                let model = item.model_type.split('\\').pop().toLowerCase();
                this.activeOption.model = this.options[model];
                this.activeOption.args = item;
                this.$refs.itemOptions.open();
            }
        }
    }
</script>
