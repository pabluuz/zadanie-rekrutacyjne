/**
 * This view is an example list of people.
 */
Ext.define('MyApp.view.main.List', {
    extend: 'Ext.grid.Panel',
    xtype: 'mainlist',

    requires: [
        'MyApp.store.Items'
    ],

    title: 'Items',

    store: {
        type: 'Items'
    },
    plugins: [
        Ext.create('Ext.grid.plugin.CellEditing', {
            clicksToEdit: 1
        })
    ],
    columns: [
        { text: 'ID',  dataIndex: 'ID', flex: 1  },
        { text: 'Name',  dataIndex: 'Name', flex: 1 ,
            editor: {
                xtype: 'textfield',
                allowBlank: false
            } },
        { text: 'DateCreated', dataIndex: 'DateCreated', flex: 1 },
        { text: 'Status', dataIndex: 'Status', flex: 1 },
        { text: 'DateLast', dataIndex: 'DateLast', flex: 1 },
        { text: 'History', dataIndex: 'History', flex: 1 }
    ],
    selType: 'cellmodel'
});
