<template>
    <md-dialog ref="dialog" class="payments-service-container">
        <md-dialog-title>Payment Service Container</md-dialog-title>

        <md-dialog-content>
            <component
                :form="form"
                :is="component">
            </component>
        </md-dialog-content>

        <md-dialog-actions>
            <md-button class="md-primary" @click.native="submit">Complete</md-button>
            <md-button class="md-primary" @click.native="cancel">Cancel</md-button>
        </md-dialog-actions>
    </md-dialog>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    payment: null,
                    component: 'default'
                }
            };
        },

        computed: {
            component() {
                if (! 'component' in this.form) {
                    console.error('Component was expected in payment service container, but was not defined.');
                    return null;
                }

                return 'payment-component-' + this.form.component;
            }
        },

        methods: {
            open() {
                this.$refs.dialog.open();
            },

            close() {
                this.$refs.dialog.close();
            },

            cancel() {
                this.close();
                Event.fire('payments-service-container-cancel', this.form.payment);
            },

            submit() {
                Event.fire('payments-service-container-submit', this.form);
            }
        },

        created() {
            Event.listen('payments-service-container-data', data => this.form = data);

            Event.listen(
                'payments-service-container',
                state => {
                    if (state) this.open()
                    else this.close()
                }
            );

            Event.listen(
                'payments-service-container-cancel',
                payment => {
                    ajax.delete('/api/payments/service/' + payment.id);
                }
            );
        }
    }
</script>
