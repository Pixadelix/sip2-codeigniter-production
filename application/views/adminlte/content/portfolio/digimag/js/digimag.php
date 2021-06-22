//<script><?php restricted(array('office-admin', 'digimag')); ?>
    
var Digimag;
    
function selectPost(e, dt, node, config) {
	if ( ! dt ) return;
	var s = getSelectedRow( e, dt, node, config );
	var rs = s.data();
    var url = Digimag.editor.file( 'sip_posts', rs[0].sip_posts.post_parent ).post_content;
    debug(url);
    var iframe = '<iframe src="/'+url+'" width="100%" height="100%" style="width: 100%; height: 100%; overflow: visible;"></iframe>';
	$('#content-preview').html(iframe);
}

function deselectPost(e, dt, node, config) {
	if ( ! dt ) return;
	$('#content-preview').html('');
}

(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Digimag_CONTAINER_SELECTOR = '#digimag-editor';
	var Digimag_Config = {
		CONTAINER_SELECTOR: Digimag_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/contents/portfolio/digimag_manager/get', type: 'POST' },
			table: Digimag_CONTAINER_SELECTOR,
			fields: [
//				{ label: 'Name', name: 'sip_posts.post_name' },
				{ label: 'Title', name: 'sip_posts.post_title', fieldInfo: 'input title (required)' },
				{ label: 'Status', name: 'sip_posts.post_status', type: 'radio', def: 'draft' },
				{ label: 'Date', name: 'sip_posts.post_date', type: 'datetime' },
                {
					label: 'Attachment',
					name: 'sip_posts.post_parent',
					type: 'upload',
					display: function ( id ) {
						if ( id ) {
							try {
								return id ? '<img class="img-thumbnail" src="/'+Digimag.editor.file( 'sip_posts', id ).media_thumbnail_path+'"/>' : null;
							}
							catch ( err ) {
							}
						}
						return null;
					}
				},
                {
					label: 'Content',
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
			ajax: { url: '/contents/portfolio/digimag_manager/get', type: 'POST' },
            order: [ [ 1, 'desc' ] ],
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
                    data: 'sip_posts.post_date',
                    title: 'Date',
                    sClass: '',
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
                },
                {
                    data: 'sip_posts.post_content',
                    title: 'Content',
                    render: function ( d, t, r ) {
                        if ( 'display' === t && d ) {
                            if ( d ) {
                                return $(d).text().substring(0, 20);
                            }
                        }
                        return d;
                    }
                },
                {
                    data: 'sip_posts.post_parent',
                    title: 'Index',
                    render: function ( id, t, r ) {
						//debug(Post.editor.file('sip_posts', id));
						if ( t == 'display' && id ) {
                            return Digimag.editor.file( 'sip_posts', id ).post_content;
						}
						return null;
					}
                },
                {
                    data: 'sip_posts.post_parent',
                    title: 'Cover',
                    render: function ( id, t, r ) {
						//debug(Post.editor.file('sip_posts', id));
						if ( t == 'display' && id ) {
                            return id ? '<img class="img-tumbnail" style="height:80px" src="/'+Digimag.editor.file( 'sip_posts', id ).post_excerpt+'"/>' : null;
						}
						return null;
					}
                },
                {
					data: 'sip_posts.post_parent',
					title: 'Type',
					sClass: 'editable',
					render: function ( id, t, r ) {
						//debug(Post.editor.file('sip_posts', id));
						if ( t == 'display' && id ) {
							try {
	                            return id ? '<img class="img-thumbnail" style="height:40px" src="/'+Digimag.editor.file( 'sip_posts', id ).media_thumbnail_path+'"/>' : null;
	                        }
	                        catch (err) {
	                        }
						}
						return null;
					}
				}
			]
		}
	}
	
	Digimag = InitDatatableEditor( Digimag_Config );
    Digimag.datatable.on('select', selectPost);
	Digimag.datatable.on('deselect', deselectPost);
    
    $( Digimag.editor.field( 'sip_posts.post_parent' ).input() ).on( 'upload.editor', function (e, val) {
        console.log( 'Image field has changed value', val );
    } );
	
})(jQuery, window);

