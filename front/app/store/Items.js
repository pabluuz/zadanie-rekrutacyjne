Ext.define('MyApp.store.Items', {
    extend: 'Ext.data.JsonStore',

    alias: 'store.Items',
    autoLoad: true,
    model: 'MyApp.model.Items',

    proxy: {
        type: 'ajax',
        url : 'Sample-201207.json',
        reader: {
            type: 'json'
        }
    }
});
