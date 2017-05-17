<template>
    <div>
        <product v-for="product in products" :key="product.id" :product="product"></product>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: []
            }
        },

        created() {
            Event.listen('products', products => this.products = products);
        }
    }
</script>
