<template>
    <md-whiteframe md-elevation="1" :class="classes" @click.native="handle">
        <span class="item-title">
            Card
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
                new Keypad({
                    minimum: 1
                }).open().then(value => {
                    let payment = this.payment;
                    payment.amount = value;
                    this.$http.post('/api/payments', payment);
                });
            }
        }
    }
</script>
