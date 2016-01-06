Organizations.window.Users = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-users-window';
	}
	Ext.applyIf(config, {
		title: _('organizations_orgs_create'),
		width: 900,
		height: 700,
		url: Organizations.config.connector_url,
		//action: 'mgr/users/create',
		layout: 'anchor',
		fields: [{
				xtype: 'hidden',
				fieldLabel: _('organizations_org_id'),
				name: 'id',
				id: config.id + '-' + 'id',
				anchor: '99%'
			},{
				title: _('organizations_org_users'),
				layout: 'anchor',
				items: [{
					xtype: 'organizations-grid-users',
					cls: 'main-wrapper',
					org_id: config.record.object.id
				}]
			}],
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				//this.submit()
			}, scope: this
		}]
		,buttons: [{
            text: config.cancelBtnText || _('cancel')
            ,scope: this
            ,handler: function() { config.closeAction !== 'close' ? this.hide() : this.close(); }
        }]
	});
	Organizations.window.Users.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.window.Users, MODx.Window, {});
Ext.reg('organizations-users-window', Organizations.window.Users);

Organizations.grid.Users = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-grid-users';
	}
	Ext.applyIf(config, {
		url: Organizations.config.connector_url,
		fields: this.getFields(config),
		columns: this.getColumns(config),
		tbar: this.getTopBar(config),
		sm: new Ext.grid.CheckboxSelectionModel(),
		baseParams: {
			action: 'mgr/users/getlist',
			org_id: config.org_id
		},
		pageSize: 10,
		save_action: 'mgr/users/update',
		autosave: true,
		viewConfig: {
			forceFit: true,
			enableRowBody: true,
			autoFill: true,
			showPreview: true,
			scrollOffset: 0,
			getRowClass: function (rec, ri, p) {
				return !rec.data.active
					? 'organizations-grid-row-disabled'
					: '';
			}
		},
		paging: true,
		remoteSort: true,
		autoHeight: true,
	});
	Organizations.grid.Users.superclass.constructor.call(this, config);

	// Clear selection on grid refresh
	this.store.on('load', function () {
		if (this._getSelectedIds().length) {
			this.getSelectionModel().clearSelections();
		}
	}, this);
};
Ext.extend(Organizations.grid.Users, MODx.grid.Grid, {
	windows: {},

	getMenu: function (grid, rowIndex) {
		var ids = this._getSelectedIds();

		var row = grid.getStore().getAt(rowIndex);
		var menu = Organizations.utils.getMenu(row.data['actions'], this, ids);

		this.addContextMenuItem(menu);
	},

	addUser: function (btn, e) {
		org_id = this.config.org_id;
		var w = MODx.load({
			xtype: 'organizations-adduser-window',
			id: Ext.id(),
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		});
		w.reset();
		w.setValues({org_id:org_id});
		w.show(e.target);
	},
	getFieldsShow: function (response) {
		
	},
	
	removeUser: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.msg.confirm({
			title: ids.length > 1
				? _('organizations_users_remove')
				: _('organizations_user_remove'),
			text: ids.length > 1
				? _('organizations_users_remove_confirm')
				: _('organizations_user_remove_confirm'),
			url: this.config.url,
			params: {
				action: 'mgr/users/remove',
				ids: Ext.util.JSON.encode(ids),
			},
			listeners: {
				success: {
					fn: function (r) {
						this.refresh();
					}, scope: this
				}
			}
		});
		return true;
	},

	disableUser: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.Ajax.request({
			url: this.config.url,
			params: {
				action: 'mgr/users/disable',
				ids: Ext.util.JSON.encode(ids),
			},
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		})
	},

	enableUser: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.Ajax.request({
			url: this.config.url,
			params: {
				action: 'mgr/users/enable',
				ids: Ext.util.JSON.encode(ids),
			},
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		})
	},

	getFields: function (config) {
		
		return ['id','org_id','shortname','user_id','username','user_perm','discount', 'active', 'actions'];
	},

	getColumns: function (config) {
		
		return [ {
			header: _('organizations_grid_id'),
			dataIndex: 'id',
			sortable: false,
			width: 50,
		},{
			header: _('organizations_grid_shortname'),
			dataIndex: 'shortname',
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_user_username'),
			dataIndex: 'username',
			sortable: true,
			width: 100,
			renderer: Organizations.utils.userLink,
		},{
			header: _('organizations_grid_user_user_perm'),
			dataIndex: 'user_perm',
			sortable: true,
			width: 100,
			editor: {xtype: 'combo-boolean', renderer: 'boolean'}
		},{
			header: _('organizations_grid_user_discount'),
			dataIndex: 'discount',
			sortable: true,
			width: 100,
			editor: {xtype: 'textfield'},
		},{
			header: _('organizations_item_active'),
			dataIndex: 'active',
			renderer: Organizations.utils.renderBoolean,
			sortable: true,
			width: 100,
			editor: {xtype: 'combo-boolean', renderer: 'boolean'}
		},{
			header: _('organizations_grid_actions'),
			dataIndex: 'actions',
			renderer: Organizations.utils.renderActions,
			sortable: false,
			width: 100,
			id: 'actions'
		}];
	},

	getTopBar: function (config) {
		return [{
			text: '<i class="icon icon-plus"></i>&nbsp;' + _('organizations_user_add'),
			handler: this.addUser,
			scope: this
		}, '->', {
			xtype: 'textfield',
			name: 'query',
			width: 200,
			id: config.id + '-search-field',
			emptyText: _('organizations_grid_search'),
			listeners: {
				render: {
					fn: function (tf) {
						tf.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
							this._doSearch(tf);
						}, this);
					}, scope: this
				}
			}
		}, {
			xtype: 'button',
			id: config.id + '-search-clear',
			text: '<i class="icon icon-times"></i>',
			listeners: {
				click: {fn: this._clearSearch, scope: this}
			}
		}];
	},

	onClick: function (e) {
		var elem = e.getTarget();
		if (elem.nodeName == 'BUTTON') {
			var row = this.getSelectionModel().getSelected();
			if (typeof(row) != 'undefined') {
				var action = elem.getAttribute('action');
				if (action == 'showMenu') {
					var ri = this.getStore().find('id', row.id);
					return this._showMenu(this, ri, e);
				}
				else if (typeof this[action] === 'function') {
					this.menu.record = row.data;
					return this[action](this, e);
				}
			}
		}
		return this.processEvent('click', e);
	},

	_getSelectedIds: function () {
		var ids = [];
		var selected = this.getSelectionModel().getSelections();

		for (var i in selected) {
			if (!selected.hasOwnProperty(i)) {
				continue;
			}
			ids.push(selected[i]['id']);
		}

		return ids;
	},

	_doSearch: function (tf, nv, ov) {
		this.getStore().baseParams.query = tf.getValue();
		this.getBottomToolbar().changePage(1);
		this.refresh();
	},

	_clearSearch: function (btn, e) {
		this.getStore().baseParams.query = '';
		Ext.getCmp(this.config.id + '-search-field').setValue('');
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}
});
Ext.reg('organizations-grid-users', Organizations.grid.Users);

Organizations.window.addUser = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-adduser-window';
	}
	Ext.applyIf(config, {
		title: _('organizations_orgs_create'),
		width: 500,
		height: 500,
		url: Organizations.config.connector_url,
		action: 'mgr/users/create',
		layout: 'anchor',
		
		fields: [{
				xtype: 'hidden',
				fieldLabel: _('organizations_grid_user_org_id'),
				name: 'org_id',
				id: config.id + '-' + 'org_id',
				anchor: '99%'
			},{
				xtype: 'organizations-combo-user',
				fieldLabel: _('organizations_grid_user_username'),
				//name: 'user_id',
				id: config.id + '-' + 'user_id',
				anchor: '99%'
			},{
				xtype: 'xcheckbox',
				fieldLabel: _('organizations_grid_user_user_perm'),
				name: 'user_perm',
				id: config.id + '-' + 'user_perm',
				anchor: '99%'
			},{
				xtype: 'textfield',
				fieldLabel: _('organizations_grid_user_discount'),
				name: 'discount',
				id: config.id + '-' + 'discount',
				anchor: '99%'
			},{
				xtype: 'xcheckbox',
				fieldLabel: _('organizations_user_active'),
				name: 'active',
				id: config.id + '-' + 'active',
				anchor: '99%'
			}],
			//'id','org_id','user_id','user_perm','discount', 'active',
			//textfield xcheckbox
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	Organizations.window.addUser.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.window.addUser, MODx.Window, {
});
Ext.reg('organizations-adduser-window', Organizations.window.addUser);

Organizations.combo.User = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		baseParams:{
            action: 'mgr/users/getuser',
        },
		fields: ['id' , 'username', 'search'],
		displayField: 'search',
		valueField: 'id',
		hiddenName:'user_id',
		hiddenValue: '',
    });
    Organizations.combo.User.superclass.constructor.call(this,config);
};
Ext.extend(Organizations.combo.User ,Organizations.combo.Dadata);
Ext.reg('organizations-combo-user',Organizations.combo.User);