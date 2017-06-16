window.Actions = class Actions {
    constructor(params) {
        Event.fire('actions-options', params || []);
    }

    open() {
        Event.fire('actions', true);
    }

    close() {
        Event.fire('actions', false);
    }
}
