
(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Shop;
	
	var Shop_CONTAINER_SELECTOR = '#shop-editor';
	var Shop_Config = {
		CONTAINER_SELECTOR: Shop_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/shops/shop/get', type: 'POST' },
			table: Shop_CONTAINER_SELECTOR,
			fields: [
				{ label: 'Shop Name', name: 'shop_shop.name' },
				{ label: 'Shop Owner', name: 'shop_shop.user_id', type: 'select2' },
				{ label: 'Shop Description', name: 'shop_shop.description', type: 'ckeditor' },
				{ label: 'Status', name: 'shop_shop.status', type: 'select' },
				{
					label: 'Manager',
					name: 'sip_users[].id',
					type: 'select2',
					opts: {
						multiple: true,
					}
				}
			],
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/shops/shop/get', type: 'POST' },
			columns: [
				{
					data: 'shop_shop.name',
					title: 'Shop Name',
					sClass: 'editable',
				},
				{
					data: 'shop_shop.user_id',
					title: 'Owner',
					sClass: 'editable',
					render: function ( v, t, r ) {
						if ( 'display' === t ) {
							return r.su1.first_name + ' ' + r.su1.last_name;
						}
						return v;
					}
				},
				{
					data: 'shop_shop.description',
					title: 'Description',
					sClass: 'editable',
				},
				{
					data: 'shop_shop.status',
					title: 'Status',
					sClass: 'editable',
					render: function ( v, t, r ) {
						if ( 'display' === t ) {
							return v.toUpperCase();
						}
						return v;
					}
				},
				{
					data: 'sip_users',
					title: 'Manager',
					render: "[, ].first_name",
					sClass: 'exportable',
					searchable: false,
				}
			]
		}
	}
	
	Shop = InitDatatableEditor( Shop_Config );
	

	
}) (jQuery, window);