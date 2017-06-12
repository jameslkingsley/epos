<template>
    <div>
        <md-whiteframe class="p-t-1 p-x-1">
            <md-toolbar class="md-dense md-transparent">
                <md-input-container>
                    <label for="category">Category</label>

                    <md-select name="category" id="category" v-model="category" @change="view">
                        <md-option v-for="(item, index) in categories" :key="index" :value="item.id">
                            {{ item.name }}
                        </md-option>
                    </md-select>
                </md-input-container>
            </md-toolbar>
        </md-whiteframe>

        <md-table>
            <md-table-header>
                <md-table-row>
                    <md-table-head>ID</md-table-head>
                    <md-table-head>Model Type</md-table-head>
                    <md-table-head>Model ID</md-table-head>
                </md-table-row>
            </md-table-header>

            <md-table-body>
                <md-table-row v-for="(item, index) in items" :key="index">
                    <md-table-cell>{{ item.id }}</md-table-cell>
                    <md-table-cell>{{ item.model_type }}</md-table-cell>
                    <md-table-cell>{{ item.model_id }}</md-table-cell>
                </md-table-row>
            </md-table-body>
        </md-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                category: 1,
                categories: [],
                items: []
            };
        },

        methods: {
            view() {
                this.$http.get('/api/categories/' + this.category)
                    .then(response => this.items = response.body);
            }
        },

        created() {
            this.$http.get('/api/categories')
                .then(response => {
                    this.categories = response.body;
                });
        }
    }
</script>
