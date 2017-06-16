import StarWebPrintTrader from './StarWebPrint/StarWebPrintTrader';
import TextBuilder from './StarWebPrint/TextBuilder';

export default class StarWebPrint {
    constructor(transaction) {
        this.transaction = transaction;
        console.log(this.transaction);
        this.builder = new TextBuilder({ paperCharacterWidth: 48 });
        this.traderUrl = _.template('http://<%= ip %>:<%= port %>/StarWebPRNT/SendMessage');
    }

    connector() {
        return new StarWebPrintTrader({
            papertype: 'normal',
            blackmark_sensor: 'front_side',
            url: this.traderUrl({
                ip: setting('peripheral:printer:ip'),
                port: setting('peripheral:printer:port')
            })
        });
    }

    render() {
        let connector = this.connector();

        connector.onError = (e) => console.log(e);

        // Company Header
        this.builder.align('center')
            .heading(epos.app.company.name).nl()
            .text('01872 571479').nl(2)
            .align('left')
            .text(this.transaction.created_at, epos.app.company.vat_number)
            .nl();

        // Basket Mode
        if (this.transaction.mode != 0) {
            this.builder.align('center')
                .bold(this.transaction.mode_name)
                .nl();
        }

        // Transaction Header
        this.builder.align('left')
            .text('Served by: TODO', 'Ref: ' + this.transaction.id)
            .nl(2);

        // Items
        this.builder.bold('QTY', 'DESCRIPTION', 'AMOUNT').nl();

        for (let item of this.transaction.items) {
            this.builder.text(
                item.qty,
                item.model.name,
                formatAsCurrency(item.gross_total)
            ).nl();
        }

        // Deals
        if (this.transaction.deals.length > 0) {
            this.builder.nl().bold('DISCOUNTS', 'AMOUNT').nl();

            for (let deal of this.transaction.deals) {
                this.builder.text(
                    deal.title,
                    formatAsCurrency(deal.discount_total)
                ).nl();
            }
        }

        // Payments
        this.builder.nl().bold('PAYMENTS', 'AMOUNT').nl();

        for (let payment of this.transaction.payments) {
            this.builder.text(
                payment.title,
                formatAsCurrency(payment.amount_total)
            ).nl();
        }

        // TODO If card payment used show card details

        // Total
        this.builder.nl().bold(
            'TOTAL',
            formatAsCurrency(this.transaction.due_from_customer)
        );

        // Change
        this.builder.nl().bold(
            'CHANGE',
            formatAsCurrency(this.transaction.change_given)
        );

        // Padding
        this.builder.nl(5);

        // Finish Receipt
        this.builder.cutPaper()
            .openDraw();

        connector.sendMessage({ request: this.builder.get() });
    }
}
