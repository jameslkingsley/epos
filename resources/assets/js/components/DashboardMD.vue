<template>
    <div class="container">
        <categories></categories>

        <div class="page-content">
            <div class="main-content">
                <items></items>
            </div>
        </div>

        <basket></basket>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                app: window.epos.app
            }
        },

        methods: {
            emptyBasket() {
                this.$http.delete('/basket')
                    .then(response => Event.fire('basket-reload', response.body));
            }
        }
    }
</script>
