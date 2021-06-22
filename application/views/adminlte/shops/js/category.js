
(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Cats;
	
	var Cats_CONTAINER_SELECTOR = '#category-editor';
	var Cats_Config = {
		CONTAINER_SELECTOR: Cats_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/shops/products/get_categories', type: 'POST' },
			table: Cats_CONTAINER_SELECTOR,
			fields: [
				{ label: 'Category Name', name: 'shop_product_category.name' },
			],
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/shops/products/get_categories', type: 'POST' },
			columns: [
				{
					data: 'shop_product_category.name',
					title: 'Category Name',
					sClass: '',
					
				},
				
			]
		}
	}
	
	Cats = InitDatatableEditor( Cats_Config );
	

	
}) (jQuery, window);