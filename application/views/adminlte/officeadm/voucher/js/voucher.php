//<script><?php restricted('office-admin'); ?>


$(document).ready(function() {

	/* VoucherType */
	var VoucherType_CONTAINER_SELECTOR = '#voucher-type-editor';
	var VoucherType_Config = {
		CONTAINER_SELECTOR: VoucherType_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/officeadm/voucher_manager/get_voucher_type', type: 'POST' },
			table: VoucherType_CONTAINER_SELECTOR,
			fields: [
				{
					label: 'Code:',
					name: 'type',
					fieldInfo: 'input voucher type code (required)',
				},
				{
					label: 'Desc:',
					name: 'desc',
					fieldInfo: 'input voucher type description (optional)',
				}
			]
		},
		DATATABLE_CONFIG: {
            responsive: false,
			ajax: { url: '/officeadm/voucher_manager/get_voucher_type', type: 'POST' },
			columns: [
				{
					data: 'type',
					title: 'Code',
					sClass: 'editable exportable',
				}, {
					data: 'desc',
					title: 'Description',
					sClass: 'editable exportable',
				}
			]
		}
	};

	/* VoucherGroup */
	var VoucherGroup_CONTAINER_SELECTOR = '#voucher-group-editor';
	var VoucherGroup_Config = {
		CONTAINER_SELECTOR: VoucherGroup_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/officeadm/voucher_manager/get_voucher_group', type: 'POST' },
			table: VoucherGroup_CONTAINER_SELECTOR,
			fields: [
				{
					label: 'Group:',
					name: 'group',
					fieldInfo: 'input voucher group (required)',
				},
				{
					label: 'Desc:',
					name: 'desc',
					fieldInfo: 'input voucher group description (optional)',
				}
			]
		},
		DATATABLE_CONFIG: {
            responsive: false,
			ajax: { url: '/officeadm/voucher_manager/get_voucher_group', type: 'POST' },
			columns: [
				{
					data: 'group',
					title: 'Group',
					sClass: 'editable exportable',
				}, {
					data: 'desc',
					title: 'Description',
					sClass: 'editable exportable',
				}
			]
		}
	};

	/* Voucher */
	var Voucher_CONTAINER_SELECTOR = '#voucher-editor';
	var Voucher_Config = {
		CONTAINER_SELECTOR: Voucher_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
		
			ajax: { url: "/officeadm/voucher_manager/get/avail", type: 'POST' },
			table: Voucher_CONTAINER_SELECTOR,
			fields: [
                {
                    label: "Voucher Name",
                    name: "sip_voucher.name",
                    fieldInfo: 'voucher name (required)'
                },
                {
                    label: "Voucher Code",
                    name: "sip_voucher.code",
                    fieldInfo: 'voucher code (required)'
                },
				{
					label: "Type:",
					name: "sip_voucher.type",
					type: "select2",
					def: 1,
					fieldInfo: 'choose voucher type (required)',
				}, {
					label: "Group:",
					name: "sip_voucher.group",
					type: "select2",
					def: 1,
					fieldInfo: 'choose voucher group (required)',
                }, {
					label: "Starting Date:",
					name: "sip_voucher.starting_date",
					type: "datetime",
					//format: "DD\/MM\/YYYY HH:mm:ss",
                    format: 'D MMM YYYY',
					def: function () { return new Date(); },
					fieldInfo: 'input starting date (required)',
				}, {
					label: "Expired Date:",
					name: "sip_voucher.expired_date",
					type: "datetime",
					//format: "DD\/MM\/YYYY HH:mm:ss",
                    format: 'D MMM YYYY',
					def: function () { return new Date(); },
					fieldInfo: 'input expired date (required)',
				}, {
					label: 'Notes:',
					name: 'sip_voucher.notes',
					fieldInfo: 'input document notes (required)',
				}, {
                    label: 'Used By:',
                    name: 'sip_voucher.used_by',
                    type: 'select2',
                    fieldInfo: 'user who used this voucher',
                }, {
                    label: 'Used At:',
                    name: 'sip_voucher.used_at',
                    fieldInfo: 'date voucher being used',
                    type: 'datetime',
                    format: "DD\/MM\/YYYY HH:mm:ss",
                }, {
                    label: 'Status:',
                    name: 'sip_voucher.status',
                    fieldInfo: 'status voucher',
                    type: 'radio',
                    options: [
                        { 'label': 'Valid', value: 1 },
                        { 'label': 'Not Valid', value: 0 },
                    ]
                }
			]
		},
		DATATABLE_CONFIG: {
            responsive: false,
			ajax: { url: "/officeadm/voucher_manager/get/avail", type: 'POST' },
            //order: [ [8, 'asc'], [1, 'asc'] ],
			columns: [
				{
					data: 'sip_voucher.id',
					title: 'ID',
                    visible: false,
                }, {
                    data: 'sip_voucher.name',
                    title: 'Name',
                    sClass: 'exportable',
				}, {
					data: 'sip_voucher.code',
					title: 'Code',
					sClass: 'exportable monospace'
				}, {
					data: 'sip_voucher.type',
					title: 'Type',
					sClass: 'exportable',
                    render: function(d, t, r) {
                        if ( t == 'display' ) {
                            return r.sip_voucher_type.type;
                        }
                        return d;
                    }
				}, {
					data: 'sip_voucher.group',
					title: 'Group',
					sClass: 'exportable',
                    render: function(d, t, r) {
                        if ( t == 'display' ) {
                            return r.sip_voucher_group.group;
                        }
                        return d;
                    }
                }, {
                    data: 'sip_voucher.starting_date',
                    title: 'Starting Date',
                    sClass: 'editable exportable',
                }, {
                    data: 'sip_voucher.expired_date',
                    title: 'Expired Date',
                    sClass: 'editable exportable',
				}, {
					data: 'sip_voucher.notes',
					title: 'Notes',
					sClass: 'editable exportable',
                    visible: false,
                }, {
                    data: 'sip_voucher.used_by',
                    title: 'Used By',
                    visible: false,
                    render: function ( d, t, r ) {
                        if ( 'display' == t ) {
                            return r.sip_users.first_name;
                        }
                        return d;
                    }
				}, {
                    data: 'sip_voucher.used_at',
                    title: 'Used At',
                    visible: false,
                }, {
                    data: 'sip_voucher.status',
                    title: 'Status',
                    render: function ( d, t, r ) {
                        if ( 'display' === t ) {
                            return d == 1 ? 'Valid' : 'Not Valid';
                        }
                        return d;
                    }
                }
			],
            createdRow: function ( row, data, index ) {
				if ( data.sip_voucher.status == 0 ) {
                    $('td', row).addClass('bg-red');
					//$('td', row).eq(7).addClass('bg-red');
				} else if ( data.sip_voucher.status == 1 ) {
                    $('td', row).addClass('bg-lightgreen');
					//$('td', row).eq(7).addClass('bg-lightgreen');
				}
			}
		}
	};
    
    /* UsedVoucher */
	var UsedVoucher_CONTAINER_SELECTOR = '#used-voucher-editor';
	var UsedVoucher_Config = {
		CONTAINER_SELECTOR: UsedVoucher_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
		
			ajax: { url: "/officeadm/voucher_manager/get/used", type: 'POST' },
			table: UsedVoucher_CONTAINER_SELECTOR,
			fields: [
                {
                    label: "Voucher Name",
                    name: "sip_voucher.name",
                    fieldInfo: 'voucher name (required)'
                },
                {
                    label: "Voucher Code",
                    name: "sip_voucher.code",
                    fieldInfo: 'voucher code (required)'
                },
				{
					label: "Type:",
					name: "sip_voucher.type",
					type: "select2",
					def: 1,
					fieldInfo: 'choose voucher type (required)',
				}, {
					label: "Group:",
					name: "sip_voucher.group",
					type: "select2",
					def: 1,
					fieldInfo: 'choose voucher group (required)',
                }, {
                    label: "Starting Date:",
                    name: "sip_voucher.starting_date",
                    type: "datetime",
                    format: 'D MMM YYYY',
                    def: function() { return new Date(); },
                    fieldInfo: 'input starting date (required)',
				}, {
					label: "Expired Date:",
					name: "sip_voucher.expired_date",
					type: "datetime",
					//format: "DD\/MM\/YYYY HH:mm:ss",
                    format: 'D MMM YYYY',
					def: function () { return new Date(); },
					fieldInfo: 'input expired date (required)',
				}, {
					label: 'Location:',
					name: 'sip_voucher.notes',
					fieldInfo: 'input document notes (required)',
				}, {
                    label: 'Used By:',
                    name: 'sip_voucher.used_by',
                    type: 'select2',
                    fieldInfo: 'user who used this voucher',
                }, {
                    label: 'Used At:',
                    name: 'sip_voucher.used_at',
                    fieldInfo: 'date voucher being used',
                    type: 'datetime',
                    format: "DD\/MM\/YYYY HH:mm:ss",
                }
			]
		},
		DATATABLE_CONFIG: {
            responsive: false,
			ajax: { url: "/officeadm/voucher_manager/get/used", type: 'POST' },
            order: [ [8, 'desc'], [1, 'desc'] ],
			columns: [
				{
					data: 'sip_voucher.id',
					title: 'ID',
                    visible: false,
                }, {
                    data: 'sip_voucher.name',
                    title: 'Name',
                    sClass: 'exportable',
				}, {
					data: 'sip_voucher.code',
					title: 'Code',
					sClass: 'exportable monospace'
				}, {
					data: 'sip_voucher.type',
					title: 'Type',
					sClass: 'exportable',
                    render: function(d, t, r) {
                        if ( t == 'display' ) {
                            return r.sip_voucher_type.type;
                        }
                        return d;
                    }
				}, {
					data: 'sip_voucher.group',
					title: 'Group',
					sClass: 'exportable',
                    render: function(d, t, r) {
                        if ( t == 'display' ) {
                            return r.sip_voucher_group.group;
                        }
                        return d;
                    }
                }, {
                    data: 'sip_voucher.expired_date',
                    title: 'Expired Date',
                    sClass: 'editable exportable',
				}, {
					data: 'sip_voucher.notes',
					title: 'Location',
					sClass: 'editable exportable',
                }, {
                    data: 'sip_voucher.used_by',
                    title: 'Used By',
                    render: function ( d, t, r ) {
                        if ( 'display' == t ) {
                            return r.sip_users.first_name;
                        }
                        return d;
                    }
				}, {
                    data: 'sip_voucher.used_at',
                    title: 'Used At',
                }, {
                    data: 'sip_voucher.status',
                    title: 'Status',
                    render: function ( d, t, r ) {
                        if ( 'display' === t ) {
                            return d == 1 ? 'Valid' : 'Not Valid';
                        }
                        return d;
                    }
                }, {
                    data: 'sip_tasks.event_name',
                    title: 'Event',
                }
			],
            createdRow: function ( row, data, index ) {
				if ( data.sip_voucher.status == 0 ) {
                    $('td', row).addClass('bg-red');
					//$('td', row).eq(7).addClass('bg-red');
				} else if ( data.sip_voucher.status == 1 ) {
                    $('td', row).addClass('bg-lightgreen');
					//$('td', row).eq(7).addClass('bg-lightgreen');
				}
			}
		}
	};
	
	InitDatatableEditor( Voucher_Config );
    
    InitDatatableEditor( UsedVoucher_Config );
	
	InitDatatableEditor( VoucherType_Config );
	
	InitDatatableEditor( VoucherGroup_Config );
	
});