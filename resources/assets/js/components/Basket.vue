<template>
    <div></div>
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

            selected(product) {
                console.log('Adding ' + product.name);
                this.reload();
            }
        },

        created() {
            this.reload();

            Event.listen(
                'product-select',
                product => this.selected(product)
            );

            Event.listen(
                'basket-reload',
                () => this.reload()
            );
        }
    }
</script>
