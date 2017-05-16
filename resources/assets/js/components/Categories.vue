<template>
    <div class="sidebar" data-background-color="white" data-active-color="danger">
        <div class="sidebar-wrapper">
            <slot></slot>

            <ul class="nav">
                <li v-for="category in categories">
                    <a href="javascript:void(0)" @click="view(category)">
                        <i class="ti-panel"></i>
                        <p>{{ category.name }}</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                categories: []
            }
        },

        methods: {
            setup() {
                this.$http.get('/api/categories')
                .then(response => this.categories = response.body);
            },

            view(category) {
                this.$http.get('/api/categories/' + category.id)
                .then(response => Event.fire('products', response.body));
            }
        },

        created() {
            this.setup();
        }
    }
</script>
