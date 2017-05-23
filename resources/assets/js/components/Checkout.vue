<template>
    <div>
        <md-layout md-gutter v-for="(chunk, index) in chunked" :key="index">
            <md-layout v-for="(payment, index) in chunk" :key="index">
                <component
                    :payment="payment"
                    v-bind:is="getComponent(payment)">
                </component>
            </md-layout>
        </md-layout>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                payments: []
            };
        },

        computed: {
            chunked() {
                return _.chunk(this.payments, 4);
            }
        },

        methods: {
            setup() {
                this.$http.get('/api/payments')
                    .then(response => this.payments = response.body);
            },

            componentExists(name) {
                return name in this.$options.components;
            },

            getComponent(payment) {
                let comp = 'payments-' + payment.handler_class.split('\\').pop().toLowerCase();
                return this.componentExists(comp) ? comp : 'payments-default';
            }
        },

        created() {
            this.setup();
        }
    }
</script>
