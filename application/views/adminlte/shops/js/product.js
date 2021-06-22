
(function( factory ){
    if ( typeof define === 'function' && define.amd ) {
        // AMD
        define( ['jquery', 'datatables', 'datatables-editor'], factory );
    }
    else if ( typeof exports === 'object' ) {
        // Node / CommonJS
        module.exports = function ($, dt) {
            if ( ! $ ) { $ = require('jquery'); }
            factory( $, dt || $.fn.dataTable || require('datatables') );
        };
    }
    else if ( jQuery ) {
        // Browser standard
        factory( jQuery, jQuery.fn.dataTable );
    }
}(function( $, DataTable ) {
'use strict';
 
 
if ( ! DataTable.ext.editorFields ) {
    DataTable.ext.editorFields = {};
}
 
var _fieldTypes = DataTable.Editor ?
    DataTable.Editor.fieldTypes :
    DataTable.ext.editorFields;
 
 
_fieldTypes.mask = {
    create: function ( conf ) {
        conf._input = $('<input/>').attr( $.extend( {
            id: DataTable.Editor.safeId( conf.id ),
            type: 'text'
        }, conf.attr || {} ) );
 
        conf._input.mask( conf.mask, $.extend( {
            placeholder: conf.placeholder || conf.mask.replace(/[09#AS]/g, '_')
        }, conf.maskOptions ) );
 
        return conf._input[0];
    },
 
    get: function ( conf ) {
        return conf._input.cleanVal();
    },
 
    set: function ( conf, val ) {
        conf._input
            .val( val )
            .trigger( 'change' )
            .trigger( 'input.mask' )
            .trigger( 'keyup.mask' );
    },
 
    enable: function ( conf ) {
        conf._input.prop( 'disabled', false );
    },
 
    disable: function ( conf ) {
        conf._input.prop( 'disabled', true );
    }
};
 
}));



(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Product;
	
	var Product_CONTAINER_SELECTOR = '#product-editor';
	var Product_Config = {
		CONTAINER_SELECTOR: Product_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/shops/products/get', type: 'POST' },
			table: Product_CONTAINER_SELECTOR,
			fields: [
				{ label: 'Shop', name: 'shop_product.shop_id', type: 'select2' },
				{ label: 'Product Name', name: 'shop_product.name' },
				{ label: 'Product Description', name: 'shop_product.description', type: 'ckeditor' },
				{
					label: 'Product Category:',
					name: 'shop_product_category[].id',
					type: 'select2',
					opts: {
						multiple: true,
					}
				},
				{ label: 'Base Price', name: 'shop_product.base_price', type: 'mask', mask: '#.##0', maskOptions: { reverse: true, placeholder: '50.000' } },
			],
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/shops/products/get', type: 'POST' },
			columns: [
				{
					data: 'shop_product.shop_id',
					title: 'Shop',
					sClass: '',
					render: function ( v, t, r ) {
						if ( 'display' === t ) {
							return r.shop_shop.name;
						}
						return v;
					}
				},
				{
					data: 'shop_product.name',
					title: 'Product Name',
					sClass: 'editable',
				},
				{
					data: 'shop_product.description',
					title: 'Description',
					sClass: 'editable',
				},
				{
					data: 'shop_product_category',
					title: 'Category',
					render: "[, ].name",
					sClass: 'exportable',
                    searchable: false,
				},
				{
					data: 'shop_product.base_price',
					title: 'Base Price',
					sClass: 'editable text-right',
					render: $.fn.dataTable.render.number( '.', ',', 0 )
				}
				
			]
		}
	}
	
	Product = InitDatatableEditor( Product_Config );
	

	
}) (jQuery, window);