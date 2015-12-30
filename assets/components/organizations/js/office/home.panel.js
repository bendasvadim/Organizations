Organizations.panel.Home = function (config) {
	config = config || {};
	Ext.apply(config, {
		baseCls: 'modx-formpanel',
		layout: 'anchor',
		/*
		 stateful: true,
		 stateId: 'organizations-panel-home',
		 stateEvents: ['tabchange'],
		 getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
		 */
		hideMode: 'offsets',
		items: [{
			xtype: 'modx-tabs',
			defaults: {border: false, autoHeight: true},
			border: false,
			hideMode: 'offsets',
			items: [{
				title: _('organizations_items'),
				layout: 'anchor',
				items: [{
					html: _('organizations_intro_msg'),
					cls: 'panel-desc',
				}, {
					xtype: 'organizations-grid-items',
					cls: 'main-wrapper',
				}]
			}]
		}]
	});
	Organizations.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.panel.Home, MODx.Panel);
Ext.reg('organizations-panel-home', Organizations.panel.Home);