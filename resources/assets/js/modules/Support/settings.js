window.Settings = class Settings {
    constructor(name) {
        //
    }

    register(items) {
        this.items = items;

        return this;
    }

    get(name, defaultValue) {
        for (let item of this.items) {
            if (name == item.name) {
                if (!item.values) {
                    return item.value;
                } else {
                    return item.values[0].value;
                }
            }
        }

        return defaultValue || null;
    }
}

window.epos.settings = new Settings().register(window.epos.settings);

window.setting = (name) => {
    return window.epos.settings.get(name);
}
