window.Keyboard = new class {
    open(options) {
        Event.fire('keyboard-options', options || {});
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
