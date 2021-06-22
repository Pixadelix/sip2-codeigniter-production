
(function ($, DataTable) {
    if ( ! DataTable.ext.editorFields ) {
        DataTable.ext.editorFields = {};
    }
    
    var Editor = DataTable.Editor;
    var _fieldTypes = DataTable.ext.editorFields;
    
    _fieldTypes.Users_status = {
        create: function ( conf ) {
            var that = this;
            
            conf._enabled = true;
            
            // Create the elements to use for the input
            conf._input = $(
                '<div id="'+Editor.safeId( conf.id )+'">'+
                    '<button class="inputButton btn-success" value="1"><i class="fa fa-check"></i>Active</button>'+
                    '<button class="inputButton btn-danger" value="0"><i class="fa fa-square"></i>Inactive</button>'+
                '</div>'
            );
            
            // Use the fact that we are called in the Editor instance's scope to call
            // the API method for setting the value when needed
            $('button.inputButton', conf._input).click( function() {
                if ( conf._enabled ) {
                    that.set( conf.name, $(this).attr('value') );
                }
                
                return false;
            })
            
            return conf._input;
        },
        
        get: function ( conf ) {
            return $('button.selected', conf._input).attr('value');
        },
        
        set: function ( conf, val ) {
            $('button.selected', conf._input).removeClass( 'selected' );
            $('button.inputButton[value='+val+']', conf._input).addClass('selected');
        },
        
        enable: function ( conf ) {
            conf._enabled = true;
            $(conf._input).removeClass( 'disabled' );
        },
        
        disable: function ( conf ) {
            conf._enabled = false;
            $(conf._input).addClass( 'disabled' );
        }
    }
})(jQuery, jQuery.fn.dataTable);

(function ($, window, undefined) {
	debug('app/setting/users.js loaded');
	
	/* User */
    var Users = null;
	var Users_CONTAINER_SELECTOR = '#users-editor';
	var Users_Config = {
		CONTAINER_SELECTOR: Users_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/setting/users/get', type: 'POST' },
			table: Users_CONTAINER_SELECTOR,
			fields: [
				{ label: 'First Name', name: 'sip_users.first_name' },
				{ label: 'Last Name', name: 'sip_users.last_name' },
				{ label: 'E-mail', name: 'sip_users.email' },
				{ label: 'Company', name: 'sip_users.company' },
				{ label: 'Phone', name: 'sip_users.phone' },
				{ label: 'Telegram Username', name: 'sip_users.telegram_username' },
				{
					label: 'Groups:',
					name: 'sip_groups[].id',
					type: 'select2',
					opts: {
						multiple: true,
					}
				},
				{
					label: 'Projects:',
					name: 'sip_projects[].id',
					type: 'select2',
					opts: {
						multiple: true,
					}
				},
                {
                    label: 'Password',
                    name: 'sip_users.password',
                    type: 'password',
                    def: '',
                },
                {
                    label: 'Status',
                    name: 'sip_users.active',
                    type: 'radio',
                    separator: '|',
                    options: [
                        { label: '<span class="text-success">Enabled</span>', value: 1 },
                        { label: '<span class="text-danger">Disabled</span>', value: 0 }
                    ]
                },
                {
                    label: 'Photo',
                    name: 'sip_users.profile_photo',
                    type: 'upload',
                    display: function ( id ) {
                        try {
                            return '<img src="/'+Users.editor.file( 'sip_posts', id ).media_web_path+'"/>';
                        }
                        catch (err) {
                        }
                    },
                    clearText: 'Clear',
                    noImageText: 'No Photo'
                }
			]
		},
		DATATABLE_CONFIG: {
            responsive: false,
			ajax: { url: '/setting/users/get', type: 'POST' },
            orderFixed: [[4, 'asc']],
            rowGroup : {
                dataSrc: 'sip_users.company',
                startRender: function ( rows, group ) {
                    debug(group);
                    /*
                    retval = '';
                    for ( var i = 0; i < group.length; i++ ) {
                        retval += retval ? ', ' + group[i].description : group[i].description;
                    }
                    return retval;
                    */
                    return group + ' ('+rows.count()+')';
                },
                endRender: null,
            },
            scroller: false,
			customButtons: [
				{
					extend: 'selectedSingle',
					text: '<i class="fa fa-key"></i>',
				}
			],
			columns: [
				{
					data: 'sip_users.first_name',
					title: 'First Name',
					sClass: 'editable exportable',
				},
				{
					data: 'sip_users.last_name',
					title: 'Last Name',
					sClass: 'editable exportable',
				},
				{
					data: 'sip_users.email',
					title: 'E-mail',
					sClass: 'editable exportable nowrap',
				},
				{
					data: 'sip_users.company',
					title: 'Company',
					sClass: 'editable exportable',
				},
				{
					data: 'sip_users.phone',
					title: 'Phone',
					sClass: 'editable exportable nowrap',
				},
				{
					data: 'sip_users.telegram_username',
					title: 'Telegram Username',
					sClass: '',
				},
				{
					data: "sip_groups",
					title: 'Groups',
					render: "[, ].name",
					sClass: 'exportable',
                    searchable: false,
                    orderable: false,
				},
				{
					data: "sip_projects",
					title: 'Projects',
					render: "[, ].name",
					sClass: 'exportable',
                    searchable: false,
                    orderable: false,
				},
				{
					data: 'sip_users.last_login',
					title: 'Last login',
					render: function ( data, type, row ) {
						return timestampToDate( row.sip_users.last_login );
						//return $.fn.dataTable.render.moment( 'X', 'DD/MMM/YY HH:mm', 'id' );
					},
					sClass: 'exportable nowrap',
				},
                {
                    data: 'sip_users.active',
                    title: 'Status',
                    sClass: 'exportable',
                    render: function ( data, type, row ) {
                        if ( type == 'display' ) {
                            if ( data == 1 ) {
                                return '<input type="checkbox" class="editor-active"> <span class="text-success">Enabled</span>';
                            } else {
                                return '<input type="checkbox" class="editor-active"> <span class="text-danger">Disabled</span>';
                            }
                        }
                        return data;
                    }
                    
                },
                {
                    data: 'sip_users.profile_photo',
                    render: function ( id ) {
                        //debug(Users.editor.files());
                        try {
                            return id ? '<img src="/'+Users.editor.file( 'sip_posts', id ).media_thumbnail_path+'"/>' : null;
                        }
                        catch (err) {
                        }
                    },
                    Srender: function ( d, t, r ) {
                        debug( r ); return;
                        if( !d.length ) {
								return 'No Photo';
							}
							str_val = '';
							for( i = 0; i < d.length; i++ ) {
								str_val += '<a href="/'+d[i].media_web_path+'"  class="html5lightbox" title="Profile photo #: '+r.sip_users.id+'" data-group="profile-photo-'+r.sip_users.id+'" data-thumbnail="/'+d[i].media_thumbnail_path+'">' +
											//'<i class="fa fa-file-image-o"></i> ' +
											'<img class="img-thumbnail with-border" src="/'+d[i].media_thumbnail_path+'">' +
										'</a>';
							}
							return str_val;
                        }
                    ,
                    defaultContent: 'No Photo',
                    title: 'Profile Photo'
                }
			
			],
            rowCallback: function ( row, data ) {
                // Set the checked state of the checkbox in the table
                $('input.editor-active', row).prop( 'checked', data.active == 1 );
            }
            
		}
	};
	
	Users = InitDatatableEditor( Users_Config );
    
    $(Users_CONTAINER_SELECTOR).on('change', 'input.editor-active', function() {
        Users.editor
            .edit( $(this).closest('tr'), false )
            .set( 'active', $(this).prop( 'checked' ) ? 1 : 0 )
            .submit();
    } );
	
})(jQuery, window);