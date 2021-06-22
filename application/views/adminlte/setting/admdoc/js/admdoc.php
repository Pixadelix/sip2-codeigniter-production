//<script><?php restricted('admin'); ?>

$(document).ready(function() {

	/* AdminDocument */
	var AdminDocument_CONTAINER_SELECTOR = '#admin-document-editor';
	var AdminDocument_Config = {
		CONTAINER_SELECTOR: AdminDocument_CONTAINER_SELECTOR,
		DATATABLE_CONFIG: {
			ajax: { url: '/setting/archived_admdoc/get', type: 'POST' },
			order: [ [ 1, 'desc' ] ],
            responsive: false,
            customButtons: [{
                text: '<i class="fa fa-archive"></i>',
                titleAttr: 'Archive & Reset',
                action: function ( e, dt, node, config ) {
                    $.confirm({
                        icon: 'fa fa-archive',
                        title: 'Archive and Reset',
                        theme: 'supervan red',
                        content: 'Are you sure want to archive and reset Document table?',
                        columnClass: 'medium',
                        buttons: {
                            OK: {
                                btnClass: 'btn-green',
                                action: function() {
                                    $.ajax({
                                        type: 'post',
                                        url: '/setting/archived_admdoc/archive',
                                        success: function (response) {
                                            $.confirm({
                                                'title': 'Completed',
                                                'title': 'Completed',
                                                icon: 'fa fa-check',
                                                theme: 'supervan black',
                                                content: 'Archiving completed.<br/>'+response.Archived+' row(s) archived.<br/>'+response.Deleted+' row(s) deleted.',
                                                buttons: {
                                                    Close: function() {
                                                        dt.ajax.reload();
                                                    }
                                                }
                                            })
                                        }
                                    });
                                }
                            },
                            Cancel: {
                                btnClass: 'btn-red',
                            }
                        }
                    });
                }
            }],
			columns: [
				{
					data: 'id',
					title: 'ID'
                }, {
					data: null,
					title: 'Ref. Code',
					sClass: 'exportable monospace',
					render: function ( data, type, row ) {
						var _day = row.refdate ? row.refdate.substr(0, 2) : '';
						var _mon = row.refdate ? row.refdate.substr(3, 2) : '';
						var _yea = row.refdate ? row.refdate.substr(6, 2) : '';
						
						return row.id+'/'+row.type+'/'+row.group+'/'+_mon+_yea;
					},
					orderable: false,
					searchable: false,
				}, {
					data: 'refdate',
					title: 'Date',
					sClass: 'exportable'
				}, {
					data: 'type',
					title: 'Type',
					sClass: 'exportable'
				}, {
					data: 'group',
					title: 'Group',
					sClass: 'exportable',
				}, {
					data: 'notes',
					title: 'Notes',
					sClass: 'editable exportable',
				}, {
					data: "content",
					title: 'Content',
					sClass: 'exportable doc-content'
				}
			]
		}
	};
	
	InitDatatableEditor( AdminDocument_Config );
	
});