<template>
    <div class="container">
        <!-- <md-layout md-gutter> -->
            <categories></categories>

            <div class="page-content">
                <div class="main-content">
                    <items></items>
                </div>
            </div>

            <!-- <md-layout md-column md-flex="15" class="categories">
            </md-layout>

            <md-layout md-column>Test 2</md-layout>
            <md-layout md-column md-flex="25">Test 3</md-layout> -->
        <!-- </md-layout> -->
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
