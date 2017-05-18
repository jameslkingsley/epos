<template>
    <div class="sidebar" data-background-color="white" data-active-color="danger">
        <div class="sidebar-wrapper">
            <slot></slot>

            <ul class="nav">
                <li :class="classes(category)" v-for="category in categories">
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
            }
        },

        created() {
            this.setup();
        }
    }
</script>
