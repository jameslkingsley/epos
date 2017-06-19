window.formatAsCurrency = (value) => {
    let langage = (navigator.language || navigator.browserLanguage).split('-')[0];

    return (value / 100).toLocaleString(langage, {
        style: 'currency',
        currency: epos.app.currency
    });
}
