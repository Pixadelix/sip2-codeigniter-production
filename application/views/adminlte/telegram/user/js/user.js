
(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var TlgrmUser;
	
	var TlgrmUser_CONTAINER_SELECTOR = '#tlgrm-user-editor';
	var TlgrmUser_Config = {
		CONTAINER_SELECTOR: TlgrmUser_CONTAINER_SELECTOR,
		
		DATATABLE_CONFIG: {
			responsive: false,
			ajax: { url: '/telegram/get_user', type: 'POST' },
			columns: [
				{
					data: 'first_name',
					title: 'First Name',
					sClass: '',
				},
				{
					data: 'last_name',
					title: 'Last Name',
				},
				{
					data: 'username',
					title: 'Username',
				},
				{
					data: 'is_bot',
					title: 'Bot',
					render: function ( v, t, r ) {
						if ( 'display' === t ) {
							return v == 1 ? 'Yes' : 'No';
						}
						return v;
					}
				}
			]
		}
	}
	
	TlgrmUser = InitDatatableEditor( TlgrmUser_Config );
	
}) (jQuery, window);