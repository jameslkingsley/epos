Vue.component('payment-component-default', require('./Components/Default.vue'));

window.ServiceContainer = class ServiceContainer {
    constructor(data) {
        this.data = data;
        this.hasCancelled = false;

        Event.fire('payments-service-container-data', data);

        Event.listen(
            'payments-service-container-cancel',
            () => this.hasCancelled = true
        );
    }

    open() {
        Event.fire('payments-service-container', true);
    }

    close() {
        Event.fire('payments-service-container', false);
    }

    cancel() {
        Event.fire('payments-service-container-cancel', this.data.payment);
    }

    onSubmit(closure) {
        Event.listenOnce(
            'payments-service-container-submit',
            form => {
                if (! this.hasCancelled) closure(form)
            }
        );
    }

    complete(data) {
        if (! 'payment' in data) {
            data.payment = this.data.payment;
        }

        return ajax.post('/api/payments/service', data);
    }
}
