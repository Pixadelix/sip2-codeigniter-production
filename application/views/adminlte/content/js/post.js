
function selectPost(e, dt, node, config) {
	if ( ! dt ) return;
	var s = getSelectedRow( e, dt, node, config );
	var rs = s.data();
	$('#content-preview').html((rs[0].sip_posts.post_content));
}

function deselectPost(e, dt, node, config) {
	if ( ! dt ) return;
	$('#content-preview').html('');
}

(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Post;
	
	var Post_CONTAINER_SELECTOR = '#post-editor';
	var Post_Config = {
		CONTAINER_SELECTOR: Post_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/content/get', type: 'POST' },
			table: Post_CONTAINER_SELECTOR,
			fields: [
//				{ label: 'Name', name: 'sip_posts.post_name' },
				{ label: 'Title', name: 'sip_posts.post_title' },
				{ label: 'Status', name: 'sip_posts.post_status', type: 'radio', def: 'draft' },
				{ label: 'Date', name: 'sip_posts.post_date', type: 'datetime' },
				{
					label: 'Content',
					name: 'sip_posts.post_content',
					type: 'ckeditor',
				}, {
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
				}, {
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
				}
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/content/get', type: 'POST' },
			columns: [
				{
					data: 'sip_posts.post_name',
					title: 'Name',
					sClass: 'exportable',
				}, {
					data: 'sip_posts.post_title',
					title: 'Title',
					sClass: 'editable',
				}, {
					data: 'sip_posts.post_status',
					title: 'Status',
					sClass: 'editable',
					render: function(v, t, r) {
						if ( t === 'display' ) {
							var status = v.replace('-', ' ');
							return status.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
						}
						return v;
					}
				}, {
					data: 'sip_posts.post_author',
					title: 'Author',
					sClass: 'editable',
					render: function(d, t, r) {
						return r.sip_users.first_name;
					}
				}, {
					data: 'sip_posts.post_date',
					title: 'Date',
					sClass: 'editable',
				}, {
					data: 'sip_posts.post_content',
					title: 'Content',
					sClass: '',
					visible: false,
				}, {
					data: 'sip_posts.post_parent',
					title: 'Attachment',
					sClass: 'editable',
					render: function ( id, t, r ) {
						
						if ( t == 'display' ) {
							try {
	                            return id ? '<img class="img-thumbnail" style="height:40px" src="/'+Post.editor.file( 'sip_posts', id ).media_thumbnail_path+'"/>' : null;
	                        }
	                        catch (err) {
	                        }
						}
						return null;
					}
				}, {
					data: 'sip_posts.menu_order',
					title: 'Menu',
					sClass: 'editable',
					render: function( v, t, r ) {
						return v == 1 ? 'Yes' : 'No';
					}
				}, {
					data: 'sip_posts.front_page',
					title: 'Front Page',
					sClass: 'editable',
					render: function( v, t, r ) {
						return v == 1 ? 'Yes' : 'No';
					}
				}, {
					data: null,
					title: 'Perma Link',
					sClass: 'nowrap',
					sortable: false,
					searchable: false,
					render: function ( data, type, row, meta ) {
						var post_date = new Date(row.sip_posts.post_date);
						//debug(post_date);
						if ( post_date != 'Invalid Date' ) {
							var yr = post_date.getFullYear();
							var mo = post_date.getMonth();
							var dt = post_date.getDate();
							
							var ss_url = "http:<?php echo base_url('/post/'); ?>"+yr+'/'+mo+'/'+dt+'/'+row.sip_posts.id+'/'+row.sip_posts.post_name;
							return '<a href="'+ss_url+'" target="_blank">'+ss_url+'</a> '+
							'<button class="btn btn-sm btn-default btn-clipboard" data-clipboard-action="copy" data-clipboard-text="'+ss_url+'"><i class="fa fa-clipboard"></i></button>';
						}
						return null;
					}
				}, {
					data: 'sip_posts.post_excerpt',
					title: 'Excerpt',
					sClass: 'editable',
				}, {
					data: 'sip_posts.post_author',
					title: 'Author',
					sClass: 'editable',
					render: function ( data, type, row ) {
						return row.sip_users.first_name;
					}
				}
			]
		}
	}
	
	Post = InitDatatableEditor( Post_Config );
	Post.datatable.on('select', selectPost);
	Post.datatable.on('deselect', deselectPost);
	
})(jQuery, window);

