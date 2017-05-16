<template>
    <table class="table table-striped">
        <tbody>
            <tr v-for="product in products">
                <td v-text="product.name"></td>
                <td v-text="product.prices[0].trade"></td>
            </tr>
        </tbody>
    </table>
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
