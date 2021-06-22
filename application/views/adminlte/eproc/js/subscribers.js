
(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Subs;
	
	var Subs_CONTAINER_SELECTOR = '#subscribers-editor';
	var Subs_Config = {
		CONTAINER_SELECTOR: Subs_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/eprocs/subscribers/get', type: 'POST' },
			table: Subs_CONTAINER_SELECTOR,
			fields: [
				{ label: 'Subscriber Name', name: 'eproc_subscribers.user_id', type: 'select2' },
				{ label: 'Expired Date', name: 'eproc_subscribers.expired_date', type: 'datetime', format: "YYYY-MM-DD", },
			],
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/eprocs/subscribers/get', type: 'POST' },
			columns: [
				{
					data: 'eproc_subscribers.user_id',
					title: 'Subscriber Name',
					sClass: '',
					render: function ( v, t, r ) {
						if ( 'display' === t ) {
							return r.sip_users.first_name+' '+r.sip_users.last_name;
						}
						return v;
					}
				},
				{
					data: 'eproc_subscribers.expired_date',
					title: 'Expired Date',
					sClass: '',
				}
			]
		}
	}
	
	Subs = InitDatatableEditor( Subs_Config );
	

	
}) (jQuery, window);