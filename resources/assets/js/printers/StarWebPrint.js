import StarWebPrintTrader from './StarWebPrint/StarWebPrintTrader';
import TextBuilder from './StarWebPrint/TextBuilder';

export default class StarWebPrint {
    constructor(transaction) {
        this.transaction = transaction;
        this.builder = new TextBuilder();
        this.traderUrl = _.template('http://<%= ip %>:<%= port %>/StarWebPRNT/SendMessage');
    }

    connector() {
        return new StarWebPrintTrader({
            papertype: 'normal',
            blackmark_sensor: 'front_side',
            url: this.traderUrl({
                ip: epos.app.printers.star_web_print.ip,
                port: epos.app.printers.star_web_print.port
            })
        });
    }

    render() {
        var payload = '';
        let connector = this.connector();

        connector.onError = (e) => console.log(e);

        this.builder.align('center')
            .heading(epos.app.name)
            .nl()
            .text('01872 571479')
            .nl(2)
            .cutPaper()
            .openDraw();

        connector.sendMessage({ request: payload });
    }
}
