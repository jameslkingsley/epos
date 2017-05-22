<template>
    <md-sidenav md-fixed class="md-left main-sidebar" ref="leftSidenav">
        <md-toolbar class="md-large">
            <div class="md-toolbar-container">
                <h3 class="md-title pull-left">
                    <clock />
                </h3>
            </div>
        </md-toolbar>

        <div class="main-sidebar-links">
            <md-list>
                <md-list-item
                    v-for="category in categories"
                    :class="classes(category)"
                    :key="category.id"
                    @click.native="view(category)">
                    {{ category.name }}
                </md-list-item>
            </md-list>
        </div>
    </md-sidenav>
</template>

<script>
    export default {
        data() {
            return {
                categories: [],
                active: -1
            }
        },

        methods: {
            classes(category) {
                return {
                    'active': this.active === category.id
                };
            },

            setup() {
                this.$http.get('/api/categories')
                    .then(response => {
                        this.categories = response.body;
                        this.view(this.categories[0]);
                    });
            },

            view(category) {
                this.$http.get('/api/categories/' + category.id)
                    .then(response => Event.fire('category-items', response.body));

                this.active = category.id;

                Event.fire('checkout', false);
            }
        },

        created() {
            this.setup();
        }
    }
</script>
