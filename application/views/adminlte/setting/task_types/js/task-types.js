
(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Task_types_CONTAINER_SELECTOR = '#task-types-editor';
	var Task_types_Config = {
		CONTAINER_SELECTOR: Task_types_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/setting/task_types/get', type: 'POST' },
			table: Task_types_CONTAINER_SELECTOR,
			fields: [
				{ label: 'Name', name: 'label' },
				{ label: 'Description', name: 'description' },
				//{ label: 'Code', name: 'code' },
				{ label: 'Icon', name: 'icon' },
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/setting/task_types/get', type: 'POST' },
			columns: [
				{
					data: 'label',
					title: 'Name',
					sClass: 'editable exportable',
				},
				{
					data: 'description',
					title: 'Description',
					sClass: 'editable exportable',
				},
				/*
				{
					data: 'code',
					title: 'Code',
					sClass: 'editable exportable',
				},
				*/
				{
					data: 'icon',
					title: 'Icon',
					sClass: 'editable exportable',
					render: function ( data, type, row ) {
						return '<i class="fa fa-fw '+row.icon+'"></i> '+row.icon;
					}
				}
			]
		}
	}
	
	InitDatatableEditor( Task_types_Config );
	
})(jQuery, window)


