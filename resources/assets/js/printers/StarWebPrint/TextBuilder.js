import StarWebPrintBuilder from './StarWebPrintBuilder';

export default class TextBuilder {
    constructor(options) {
        this.payload = '';
        this.options = options || {};
        this.builder = new StarWebPrintBuilder();
        this.payload += this.builder.createInitializationElement();
    }

    get() {
        return this.payload;
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
            },

            bold: {
                characterspace: 0,
                emphasis: true,
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

    stringOfSpaces(length) {
        let str = '';
        for (let n in _.range(length)) str += ' ';
        return str;
    }

    convertPounds(str) {
        if (!str || typeof str != 'string') return str;
        return str.replace('£', String.fromCharCode(156));
    }

    textAlign(left, middle, right) {
        if (left && typeof left != 'string') left = left.toString();
        if (middle && typeof middle != 'string') middle = middle.toString();
        if (right && typeof right != 'string') right = right.toString();

        left = this.convertPounds(left);
        middle = this.convertPounds(middle);
        right = this.convertPounds(right);

        if (!middle) return left;

        if (right) {
            // Align right-left-right
            if (left.length < 3 && left != '-') {
                left = ((this.stringOfSpaces(100)).slice(
                    0,
                    Math.abs((3 - left.length))
                )).concat(left);
            }

            let spacesStr = (this.stringOfSpaces(100)).slice(0,
                Math.abs(
                    (Math.ceil(
                        this.options.paperCharacterWidth
                        - (5 + middle.length + right.length)
                    ))
                )
            );

            if (left == '-') left = '   ';
            if (right == '-') right = '  ';

            let final = (left + '  ' + middle + spacesStr + right);

            if (final.length > this.options.paperCharacterWidth) {
                let diff = final.length - this.options.paperCharacterWidth;
                middle = middle.substring(0, middle.length - diff);
                return (left + '  ' + middle + spacesStr + right);
            }

            return final;
        } else {
            // Align left-right
            let spacesStr = (this.stringOfSpaces(100)).slice(0,
                Math.abs(
                    (Math.ceil(
                        this.options.paperCharacterWidth
                        - (left.length + middle.length)
                    ))
                )
            );

            return left + spacesStr + middle;
        }
    }

    formatAsLine(left, middle, right) {
        let text = left;

        if (middle || right) {
            if (right) {
                text = this.textAlign(left, middle, right);
            } else {
                text = this.textAlign(left, middle);
            }
        }

        return text;
    }

    text(left, middle, right) {
        this.payload += this.builder.createTextElement(
            this.style('normal', this.formatAsLine(left, middle, right))
        );

        return this;
    }

    bold(left, middle, right) {
        this.payload += this.builder.createTextElement(
            this.style('bold', this.formatAsLine(left, middle, right))
        );

        return this;
    }

    heading(left, middle, right) {
        this.payload += this.builder.createTextElement(
            this.style('heading', this.formatAsLine(left, middle, right))
        );

        return this;
    }

    hr() {
        this.payload += this.builder.createRuledLineElement({
            thickness: 'medium',
            width: 832
        });

        return this;
    }

    nl(count) {
        for (let n in _.range(count || 1)) {
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
