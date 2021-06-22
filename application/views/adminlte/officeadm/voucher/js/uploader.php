//<script><?php restricted('office-admin'); ?>

(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Post;
	
	var Post_CONTAINER_SELECTOR = '#voucher-uploader';
	var Post_Config = {
		CONTAINER_SELECTOR: Post_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/officeadm/voucher_manager/get_files', type: 'POST' },
			table: Post_CONTAINER_SELECTOR,
			fields: [
//				{ label: 'Name', name: 'sip_posts.post_name' },
				{ label: 'Voucher Name', name: 'sip_posts.post_title', fieldInfo: 'input voucher name for identification (required)' },
				/*{ label: 'Status', name: 'sip_posts.post_status', type: 'radio', def: 'draft' },
				{ label: 'Date', name: 'sip_posts.post_date', type: 'datetime' },
				*/
                {
					label: 'Attachment',
					name: 'sip_posts.post_parent',
					type: 'upload',
					display: function ( id ) {
						if ( id ) {
							try {
								return id ? '<img class="img-thumbnail" src="/'+Post.editor.file( 'sip_posts', id ).media_thumbnail_path+'"/>' : null;
							}
							catch ( err ) {
							}
						}
						return null;
					}
				},
                {
					label: 'Notes',
					name: 'sip_posts.post_content',
					type: 'ckeditor',
				},
                /*{
					label: 'As Main Menu',
					name: 'sip_posts.menu_order',
					type: 'radio',
					options: [ { label: 'Yes', value: 1 }, { label: 'No', value: 0 } ]
				}, {
					label: 'Shot in Front Page',
					name: 'sip_posts.front_page',
					type: 'radio',
					options: [ { label: 'Yes', value: 1 }, { label: 'No', value: 0 } ]
				}, {
					label: 'Excerpt',
					name: 'sip_posts.post_excerpt',
					type: 'ckeditor',
				}, {
					label: 'Author',
					name: 'sip_posts.post_author',
					type: 'select2',
				}*/
			]
		},
		DATATABLE_CONFIG: {
            responsive: false,
			ajax: { url: '/officeadm/voucher_manager/get_files', type: 'POST' },
            order: [ [ 1, 'desc' ] ],
            customButtons: [
                {
                    extend: 'selectedSingle',
                    text: '<i class="fa fa-cloud-upload"></i>',
                    titleAttr: 'Upload',
                    enabled: false,
                    action: function ( e, dt, node, config ) {
                        var s = getSelectedRow( e, dt, node, config );
                        var rows = s.data();
                        var row = rows[0];
                        //debug('Attachment ID: '+row.sip_posts.post_parent);
                        //data = { post_parent: row.sip_posts.post_parent };
                        
                        $.confirm({
                            icon: 'fa fa-ticket',
                            title: 'Type and Group',
                            theme: 'supervan blue',
                            
                            onContentReady: function() {
                                var self = this;
                                $('.select2').select2({
                                    dropdownCssClass: 'on-top'
                                });
                            },
                            content: function() {
                                var self = this;
                                return $.ajax({
                                    url: '/officeadm/voucher_manager/form_group_and_type',
                                    method: 'get',
                                }).done(function (response) {
                                    self.setContentPrepend(response);
                                }).fail(function (response) {
                                    debug(response);
                                    self.setContentPrepend('ERROR');
                                }).always(function(response) {
                                          
                                });
                            },
                            
                            buttons: {
                                Yes: {
                                    btnClass: 'btn-green',
                                    action: function() {
                                        $form = this.$content.find('form');
                                        $form.submit(function(e) {
                                            e.preventDefault();
                                            data = $form.serialize();
                                            data += '&post_parent='+row.sip_posts.post_parent;
                                            debug(data);
                                            $.ajax({
                                                type: $form.attr('method'),
                                                url: $form.attr('action'),
                                                data: data,
                                                success: function(response) {
                                                    $form.empty();
                                                    $.confirm({
                                                        title: 'Success',
                                                        icon: 'fa fa-check',
                                                        theme: 'supervan green',
                                                        content: 'Voucher updated/imported successful. '+response+' row(s) affected',
                                                        buttons: {
                                                            Close: function() {
                                                                dt.ajax.reload();
                                                            }
                                                        }
                                                        
                                                    });
                                                }
                                            });
                                        })
                                        $form.trigger('submit');
                                    }
                                },
                                Cancel: {
                                    btnClass: 'btn-default btn-red',
                                    action: function() {
                                        self.close();
                                    }
                                }
                            }
                        });
                    }
                }
                
            ],
			columns: [
                {
                    data: 'sip_posts.id',
                    title: 'ID',
                },
				{
					data: 'sip_posts.post_title',
					title: 'Title',
					sClass: 'editable',
				}, {
					data: 'sip_posts.post_status',
					title: 'Status',
					sClass: 'editable',
					render: function(v, t, r) {
						if ( t === 'display' ) {
							var status = v.replace(/-/g, ' ');
							return status.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
						}
						return v;
					}
				},
                {
					data: 'sip_posts.post_parent',
					title: 'Type',
					sClass: 'editable',
					render: function ( id, t, r ) {
						//debug(Post.editor.file('sip_posts', id));
						if ( t == 'display' ) {
							try {
	                            return id ? '<img class="img-thumbnail" style="height:40px" src="/'+Post.editor.file( 'sip_posts', id ).media_thumbnail_path+'"/>' : null;
	                        }
	                        catch (err) {
	                        }
						}
						return null;
					}
				}
			],
            createdRow: function ( row, data, index ) {
				if ( data.sip_posts.post_status == 'in-system-invalid' ) {
                    $('td', row).addClass('bg-red');
					//$('td', row).eq(7).addClass('bg-red');
				} else if ( data.sip_posts.post_status == 'in-system-valid' ) {
                    $('td', row).addClass('bg-lightgreen');
					//$('td', row).eq(7).addClass('bg-lightgreen');
				}
			}
		}
	}
	
	Post = InitDatatableEditor( Post_Config );
    
    $( Post.editor.field( 'sip_posts.post_parent' ).input() ).on( 'upload.editor', function (e, val) {
        console.log( 'Image field has changed value', val );
    } );
	
})(jQuery, window);

