window.Settings = class Settings {
    constructor(name) {
        //
    }

    register(items) {
        this.items = items;

        return this;
    }

    get(name) {
        for (let item of this.items) {
            if (name == item.name) {
                if (!item.values) {
                    return item.value;
                } else {
                    return item.values[0].value;
                }
            }
        }

        return null;
    }
}
