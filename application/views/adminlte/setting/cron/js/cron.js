
(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Cron;
	
	var Cron_CONTAINER_SELECTOR = '#cron-editor';
	var Cron_Config = {
		CONTAINER_SELECTOR: Cron_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/cron/get', type: 'POST' },
			table: Cron_CONTAINER_SELECTOR,
			fields: [
				{ label: 'Name', name: 'cron.name' },
				{ label: 'Command', name: 'cron.command' },
				{ label: 'Interval', name: 'cron.interval_sec', type: 'select' },
				{
					label: 'Enable/Disable',
					name: 'cron.is_active',
					type: 'radio',
					options: [
						{ label: 'Enabled', value: 1 },
						{ label: 'Disabled', value: 0 },
					],
					def: 1
				}
				
			],
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/cron/get', type: 'POST' },
			columns: [
				{
					data: 'cron.name',
					title: 'Name',
					sClass: 'editable',
				},
				{
					data: 'cron.command',
					title: 'Command',
				},
				{
					data: 'cron.interval_sec',
					title: 'Interval (sec)',
				},
				{
					data: 'cron.last_run_at',
					title: 'Last Run at',
				},
				{
					data: 'cron.next_run_at',
					title: 'Next Run at',
				},
				{
					data: 'cron.is_active',
					title: 'Enabled/Disabled',
				}
			]
		}
	}
	
	Cron = InitDatatableEditor( Cron_Config );
	
}) (jQuery, window);