import StarWebPrintBuilder from './StarWebPrintBuilder';

export default class TextBuilder {
    constructor(transaction) {
        this.payload = '';
        this.builder = new StarWebPrintBuilder();
        this.payload += this.builder.createInitializationElement();
    }

    style(type, content) {
        let style = {
            heading: {
                characterspace: 0,
                emphasis: true,
                font: 'font_a',
                width: 2,
                height: 2,
                data: '',
                linespace: 24,
                binary: true
            },

            normal: {
                characterspace: 0,
                emphasis: false,
                font: 'font_a',
                width: 1,
                height: 1,
                data: '',
                linespace: 24,
                binary: true
            }
        }[type];

        style.data = content;

        return style;
    }

    text(content) {
        this.payload += this.builder.createTextElement(this.style('normal', content));

        return this;
    }

    heading(content) {
        this.payload += this.builder.createTextElement(this.style('heading', content));

        return this;
    }

    nl(count) {
        for (n in _.range(count || 1)) {
            this.payload += this.builder.createTextElement(this.style('normal', '\n'));
        }

        return this;
    }

    align(position) {
        this.payload += this.builder.createAlignmentElement({ position });

        return this;
    }

    cutPaper() {
        this.payload += this.builder.createCutPaperElement({ feed: true });

        return this;
    }

    openDraw() {
        this.payload += this.builder.createPeripheralElement({
            channel: 1,
            on: 200,
            off: 200
        });

        return this;
    }
}
