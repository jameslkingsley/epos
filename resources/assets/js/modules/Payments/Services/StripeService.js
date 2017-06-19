Vue.component('payment-component-stripe', require('../Components/Stripe.vue'));

export default class StripeService {
    constructor(payment) {
        this.payment = payment;
        this.stripe = Stripe(epos.app.services.stripe.key);
        this.elements = this.stripe.elements();
    }

    handle() {
        let container = new ServiceContainer({
            payment: this.payment,
            component: 'stripe'
        });

        // Show the payment service container modal
        container.open();

        container.onSubmit(form => {
            container.complete(form).then(response => container.close());
        });

        // Create the Stripe input card
        // const card = this.createCard();

        // Create the form token events
        // const form = this.createForm(card);
    }

    createForm(card) {
        // Create a token or display an error when the form is submitted.
        const form = document.getElementById('payment-form');

        form.addEventListener('submit', event => {
            event.preventDefault();

            this.stripe.createToken(card).then(result => {
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

        return form;
    }

    createCard() {
        // Custom styling for Stripe elements
        const style = {
            base: {}
        };

        // Create an instance of the card Element
        const card = this.elements.create('card', {style});

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

        return card;
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
