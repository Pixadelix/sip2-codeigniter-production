
(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Lpse;
	
	var Lpse_CONTAINER_SELECTOR = '#lpse-editor';
	var Lpse_Config = {
		CONTAINER_SELECTOR: Lpse_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/eprocs/lpse/get', type: 'POST' },
			table: Lpse_CONTAINER_SELECTOR,
			fields: [
				{ label: 'Name', name: 'eproc_lpse.name' },
			],
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/eprocs/lpse/get', type: 'POST' },
			columns: [
				{
					data: 'eproc_lpse.name',
					title: 'Name',
					sClass: 'editable',
				},
				{
					data: 'eproc_lpse.url_spse',
					title: 'URL',
					sClass: 'editable',
					render: function ( v, t, r ) {
						if ( t === 'display' ) {
							return '<a href="'+v+'" target="_blank">'+v+'</a>';
						}
						return v;
					}
				},
				{
					data: 'eproc_lpse.status',
					title: 'Status',
					sClass: '',
				},
				{
					data: null,
					title: 'Last Updated',
					render: function ( v, t, r ) {
						if ( t === 'display' ) {
							return r.eproc_lpse.update_at ? r.eproc_lpse.update_at : r.eproc_lpse.create_at;
						}
						return v;
					}
				},
			]
		}
	}
	
	Lpse = InitDatatableEditor( Lpse_Config );
	
}) (jQuery, window);