window.Keypad = class Keypad {
    constructor(options) {
        let extended = _.merge({}, window.KeypadOptions, options || {});

        Event.fire('keypad-options', extended);
    }

    open() {
        Event.fire('keypad', true);

        return new Promise((resolve, reject) => {
            Event.listenOnce('keypad-confirm', value => resolve(value));
            Event.listenOnce('keypad-cancel', reject);
        });
    }

    close() {
        Event.fire('keypad', false);
    }
}

window.KeypadOptions = {
    currency: window.epos.app.currency
};
