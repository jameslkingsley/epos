<template>
    <div class="basket">
        <basket-line :item="item" :key="item.id" v-for="item in basket.items">
            <!-- TODO Context Actions -->
        </basket-line>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                basket: {}
            };
        },

        methods: {
            reload() {
                this.$http.get('/api/basket')
                    .then(response => this.basket = response.body);
            },

            selected(item) {
                this.$http.post('/api/basket-items', item)
                    .then(response => this.reload());
            }
        },

        created() {
            this.reload();

            Event.listen(
                'item-select',
                item => this.selected(item)
            );

            Event.listen(
                'basket-reload',
                () => this.reload()
            );
        }
    }
</script>
