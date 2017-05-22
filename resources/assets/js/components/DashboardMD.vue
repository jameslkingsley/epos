<template>
    <div class="container">
        <categories></categories>

        <div class="page-content">
            <div class="main-content">
                <items v-show="!checkout"></items>
                <checkout v-show="checkout"></checkout>
            </div>
        </div>

        <basket></basket>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                app: window.epos.app,
                checkout: false
            }
        },

        methods: {
            emptyBasket() {
                this.$http.delete('/basket')
                    .then(response => Event.fire('basket-reload', response.body));
            }
        },

        created() {
            Event.listen('checkout', state => this.checkout = state);
        }
    }
</script>
