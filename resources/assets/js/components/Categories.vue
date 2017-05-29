<template>
    <md-sidenav md-fixed class="md-left main-sidebar" ref="leftSidenav">
        <div class="main-sidebar-links" style="background: white">
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
                    .then(response => {
                        Event.fire('category-items', response.body)
                        Event.fire('checkout', false);
                        this.active = category.id;
                    });
            }
        },

        created() {
            this.setup();
        }
    }
</script>
