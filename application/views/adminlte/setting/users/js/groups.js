(function ($, window, undefined) {
	debug('app/setting/groups.js loaded');
	
	/* Groups */
    var Groups = null;
	var Groups_CONTAINER_SELECTOR = '#groups-editor';
	var Groups_Config = {
		CONTAINER_SELECTOR: Groups_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/setting/users/get_groups', type: 'POST' },
			table: Groups_CONTAINER_SELECTOR,
            canRemove: true,
			fields: [
				{ label: 'Group Name', name: 'name' },
				{ label: 'Group Description', name: 'description' },
			]
		},
		DATATABLE_CONFIG: {
            responsive: false,
			ajax: { url: '/setting/users/get_groups', type: 'POST' },
			columns: [
                {
                    data: 'id',
                    title: 'ID',
                },
				{
					data: 'name',
					title: 'Group Name',
					sClass: 'editable exportable',
				},
				{
					data: 'description',
					title: 'Group Description',
					sClass: 'editable exportable',
				},
            ]
		}
	};
	
	Groups = InitDatatableEditor( Groups_Config );
	
})(jQuery, window);