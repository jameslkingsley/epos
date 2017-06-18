export default class StripeService {
    constructor(payment) {
        this.payment = payment;
    }

    handle() {
        // Show payment processing modal
        // Start listening for card reader events
        const stripe = Stripe(epos.app.services.stripe.key);
        const elements = stripe.elements();

        // Show the payment service container modal
        Event.fire('payments-service-container', true);

        // Custom styling for Stripe elements
        const style = {
            base: {}
        };

        // Create an instance of the card Element
        const card = elements.create('card', {style});

        // Add an instance of the card Element
        card.mount('#card-element');

        card.addEventListener('change', ({error}) => {
            const displayError = document.getElementById('card-errors');

            if (error) {
                displayError.textContent = error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Create a token or display an error when the form is submitted.
        const form = document.getElementById('payment-form');

        form.addEventListener('submit', event => {
            event.preventDefault();

            stripe.createToken(card).then(result => {
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server
                    this.handleToken(result.token);
                }
            });
        });

        console.log(this.payment);

        // Submit the card charge
        // this.$http.post('/api/payments/service', { ... });
    }

    handleToken(token) {
        // Insert the token ID into the form so it gets submitted to the server
        const form = document.getElementById('payment-form');
        const hiddenInput = document.createElement('input');

        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);

        form.appendChild(hiddenInput);
        form.submit();
    }
}
