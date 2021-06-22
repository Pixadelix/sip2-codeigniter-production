
(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	/* MONITORED */
	
	var Monitored;
	
	var Monitored_CONTAINER_SELECTOR = '#monitored-editor';
	var Monitored_Config = {
		CONTAINER_SELECTOR: Monitored_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/eprocs/settings/get_monitored', type: 'POST' },
			table: Monitored_CONTAINER_SELECTOR,
			canRemove: true,
			fields: [
				{ label: 'LPSE', name: 'eproc_monitored.lpse_id', type: 'select2' },
			],
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/eprocs/settings/get_monitored', type: 'POST' },
			columns: [
				{
					data: 'eproc_monitored.lpse_id',
					title: 'LPSE',
					sClass: '',
					visible: false,
					render: function ( v, t, r ) {
						if ( 'display' === t ) {
							return r.eproc_lpse.name;
						}
						return v;
					}
				},
				{
					data: 'eproc_lpse.name',
					title: 'LPSE',
					sClass: '',
				}
			]
		}
	}
	
	Monitored = InitDatatableEditor( Monitored_Config );
	
	
	/* KEYWORD */
	
	var Keyword;
	
	var Keyword_CONTAINER_SELECTOR = '#keyword-editor';
	var Keyword_Config = {
		CONTAINER_SELECTOR: Keyword_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/eprocs/settings/get_keyword', type: 'POST' },
			table: Keyword_CONTAINER_SELECTOR,
			canRemove: true,
			fields: [
				{ label: 'Keyword', name: 'eproc_keyword.keyword' },
			],
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/eprocs/settings/get_keyword', type: 'POST' },
			columns: [
				{
					data: 'eproc_keyword.keyword',
					title: 'Keyword',
					sClass: 'editable',
				}
			]
		}
	}
	
	Keyword = InitDatatableEditor( Keyword_Config );
	
}) (jQuery, window);