<template>
    <md-whiteframe md-elevation="1" :class="classes" @click.native="handle">
        <span class="item-title">
            Fast Cash
        </span>

        <span class="item-price"></span>
        <span class="item-meta"></span>
    </md-whiteframe>
</template>

<script>
    export default {
        props: ['payment'],

        computed: {
            classes() {
                return {
                    'item-wrapper': true,
                    'cursor-pointer': true
                };
            }
        },

        methods: {
            handle() {
                this.$http.post('/api/payments', this.payment);
            }
        }
    }
</script>
