
(function ($, window, undefined) {
	debug('LOAD RESOURCE: <?php echo $path; ?>');
	
	var Splash;
	
	var Splash_CONTAINER_SELECTOR = '#splash-editor';
	var Splash_Config = {
		CONTAINER_SELECTOR: Splash_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/contents/splash/get', type: 'POST' },
			table: Splash_CONTAINER_SELECTOR,
			fields: [
				//{ label: 'Name', name: 'sip_posts.post_name' },
				{ label: 'Page Title', name: 'sip_posts.post_title' },
				{ label: 'Redirect Script', name: 'sip_posts.post_content', fieldInfo: "example: redirect('http://path/to/url/web');" },
				{ label: 'Status', name: 'sip_posts.post_status', type: 'select2' },
				{ label: 'Date', name: 'sip_posts.post_date', type: 'datetime' },
				{
					label: 'File',
					name: 'sip_posts.post_parent',
					type: 'upload',
					display: function ( id ) {
						try {
							return '<img class="pull-right img-thumbnail with-border" src="/assets/static/img/zip.png" style="width: 60px; height: 60px;"> ' + Splash.editor.file('sip_posts', id).media_filename;
						}
						catch ( err ) {
						}
					}
				}, {
					label: 'Author',
					name: 'sip_posts.post_author',
					type: 'select2',
				}
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/contents/splash/get', type: 'POST' },
			columns: [
				/*{
					data: 'sip_posts.post_name',
					title: 'Name',
					sClass: 'editable exportable',
				},*/
				{
					data: 'sip_posts.post_title',
					title: 'Page Title',
					sClass: 'editable',
				}, {
					data: 'sip_posts.post_content',
					title: 'Redirect Script',
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
					data: 'sip_posts.post_date',
					title: 'Date',
					sClass: 'editable',
					srender: $.fn.dataTable.render.moment( 'YYYY-MM-DD hh:mm:ss' ),
					render: $.fn.dataTable.render.moment( 'DD/MM/YYYY' )
				}, {
                    data: 'sip_posts.post_parent',
                    title: 'File',
                    sClass: 'editable',
					render: function ( id ) {
						try {
							file = Splash.editor.file('sip_posts', id);
							return file.media_thumbnail_path+'<img class="pull-right img-thumbnail with-border" src="/assets/static/img/zip.png" style="width: 60px; height: 60px;">';
						}
						catch ( err ) {
							return '';
						}
					}
				}, {
					data: null,
					title: 'Perma Link',
					sClass: 'nowrap',
					sortable: false,
					searchable: false,
					render: function ( data, type, row, meta ) {
						var post_date = new Date(row.sip_posts.post_date);
						debug(post_date);
						if ( post_date != 'Invalid Date' ) {
							var yr = post_date.getFullYear();
							var mo = post_date.getMonth()+1;
							var dt = post_date.getDate();
							debug(mo);
							
							//var ss_url = "http:<?php echo base_url('/contents/splash/'); ?>"+row.sip_posts.id + '/' + row.sip_posts.post_name;
							var ss_url = "http:<?php echo base_url('/splash/'); ?>"+yr+'/'+mo+'/'+dt+'/'+row.sip_posts.id+'/'+row.sip_posts.post_name;
							return '<a href="'+ss_url+'" target="_blank">'+ss_url+'</a> '+
							'<button class="btn btn-sm btn-default btn-clipboard" data-clipboard-action="copy" data-clipboard-text="'+ss_url+'"><i class="fa fa-clipboard"></i></button>';
						}
						return null;
					}
				}
			]
		}
	}
	
	Splash = InitDatatableEditor( Splash_Config );
	
	var clipboard = new Clipboard('.btn-clipboard');
	clipboard.on('success', function(e) {
		$.confirm({
			icon: 'fa fa-clipboard',
			title: 'Copy to clipboard',
			backgroundDismiss: true,
			content: 'Copied!',
			type: 'green',
			buttons: {
				ok: {
					btnClass: 'btn-green'
				}
			}
		});
	});

})(jQuery, window);

