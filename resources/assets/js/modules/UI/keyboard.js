window.Keyboard = class Keyboard {
    constructor(options) {
        let extended = _.merge({}, window.KeyboardOptions, options || {});

        Event.fire('keyboard-options', extended);
    }

    open() {
        Event.fire('keyboard', true);

        return new Promise((resolve, reject) => {
            Event.listenOnce('keyboard-confirm', text => resolve(text));
            Event.listenOnce('keyboard-cancel', reject);
        });
    }

    close() {
        Event.fire('keyboard', false);
    }
}

window.KeyboardOptions = {
    //
};
