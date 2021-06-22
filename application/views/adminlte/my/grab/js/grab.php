//<script><?php //restricted('request-grab-code'); ?>


$(document).ready(function() {


	/* Vouchers */
	var Vouchers_CONTAINER_SELECTOR = '#vouchers';
	var Vouchers_Config = {
		CONTAINER_SELECTOR: Vouchers_CONTAINER_SELECTOR,
		DATATABLE_CONFIG: {
            responsive: false,
			ajax: { url: "/my/my_grab/get", type: 'POST' },
            order: [ [1, 'desc'] ],
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
					sClass: 'exportable monospace upcase'
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
					title: 'Location',
					sClass: 'editable exportable',
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
			]
		}
	};
    
	InitDatatableEditor( Vouchers_Config );
    
});
