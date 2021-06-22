
(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Lpse;
	
	var Lpse_CONTAINER_SELECTOR = '#package-editor';
	var Lpse_Config = {
		CONTAINER_SELECTOR: Lpse_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/eprocs/package/get', type: 'POST' },
			table: Lpse_CONTAINER_SELECTOR,
			fields: [
				{ label: 'Name', name: 'eproc_package.name' },
			],
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/eprocs/package/get', type: 'POST' },
			order: [ [ 1, 'desc' ] ],
			columns: [
				{
					data: 'eproc_package.id',
					title: 'Code',
				},
				{
					data: 'eproc_package.name',
					title: 'Name',
					sClass: '',
					render: function ( v, t, r ) {
						if ( t === 'display' ) {
							var ver = r.eproc_package.spse_version;
							var text = '<p><a href="'+r.eproc_lpse.scheme+'://'+r.eproc_lpse.host+'/eproc4/lelang/'+r.eproc_package.id+'/pengumumanlelang" target="_blank">'+v+'</a> <span class="label '+(ver == '2' ? 'label-success' : 'label-danger')+'">'+(ver == '2' ? 'spse 4' : 'spse 3')+'</span></p>';
							text += '<p>'+r.eproc_package.category+'. '+r.eproc_package.method+'. '+r.eproc_package.doc_method+'. '+r.eproc_package.elimination_method+'</p>';
							return text;
						}
						return v;
					}
				},
				{
					data: 'eproc_package.instance',
					title: 'Instance',
					sClass: '',
				},
				{
					data: 'eproc_package.status',
					title: 'Status',
					sClass: '',
					render: function ( v, t, r ) {
						if ( t === 'display' ) {
							return '<a href="'+r.eproc_lpse.scheme+'://'+r.eproc_lpse.host+'/eproc4/lelang/'+r.eproc_package.id+'/jadwal" target="_blank">'+v+'</a>';
						}
						return v;
					}
				},
				{
					data: 'eproc_package.est_price',
					title: 'Est. Value',
					sClass: 'text-right',
				},
				/*
				{
					data: null,
					title: 'Last Updated',
					searchable: false,
					render: function ( v, t, r ) {
						if ( t === 'display' ) {
							return r.eproc_package.update_at ? r.eproc_package.update_at : r.eproc_package.create_at;
						}
						return v;
					}
				},
				/*
				{
					data: 'eproc_package.spse_version',
					title: 'Version',
					sClass: 'text-center',
					render: function ( v, t, r ) {
						if ( t === 'display' ) {
							//<span class="label '+highlight+'">'+flag+'</span>
							return '<span class="label '+(v == '2' ? 'label-success' : 'label-danger')+'">'+(v == '2' ? 'spse 4' : 'spse 3')+'</span>';
						}
						return v;
					}
				}
				*/
			]
		}
	}
	
	Lpse = InitDatatableEditor( Lpse_Config );
	
}) (jQuery, window);