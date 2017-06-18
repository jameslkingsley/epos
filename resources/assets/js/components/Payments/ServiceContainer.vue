<template>
    <md-dialog ref="dialog" style="min-width: 400px">
        <md-dialog-title>Payment Service Container</md-dialog-title>

        <md-dialog-content>
            <form action="/api/payments/service" method="post" id="payment-form">
                <div class="form-row">
                    <label for="card-element">
                        Credit or debit card
                    </label>

                    <div id="card-element">
                        <!-- Stripe Element will be inserted here -->
                    </div>

                    <!-- Used to display Element errors -->
                    <div id="card-errors" role="alert"></div>
                </div>

                <md-button type="submit" class="md-primary">Submit Payment</md-button>
            </form>
        </md-dialog-content>

        <md-dialog-actions>
            <md-button class="md-primary" @click.native="close">Cancel</md-button>
        </md-dialog-actions>
    </md-dialog>
</template>

<script>
    export default {
        methods: {
            open() {
                this.$refs.dialog.open();
            },

            close() {
                this.$refs.dialog.close();
            },

            submit() {
                //
            }
        },

        created() {
            Event.listen(
                'payments-service-container',
                state => {
                    if (state) this.open()
                    else this.close()
                }
            );
        }
    }
</script>
