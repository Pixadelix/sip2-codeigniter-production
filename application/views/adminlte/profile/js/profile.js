debug('LOAD RESOURCE: <?php echo $path; ?>');

var editor; // use a global for the submit and return data rendering in the examples
var profile_photo;

// Template function to display the information panels. Editor will
// automatically keep the values up-to-date with any changes due to the use of
// the `data-editor-field` attribute. It knows which panel to update for each
// record through the use of `data-editor-id` in the container element.
function createPanel ( data )
{
    var id = data.DT_RowId;
     
    $(
        '<div class="panel form-horizontal" data-editor-id="'+id+'">'+
            '<dl>'+
                '<div class="form-group">'+
                    '<dt class="col-sm-2 control-label">Name:</dt>'+
                    '<div class="col-sm-10">'+
                        '<dd class="form-control">'+
                            '<span data-editor-field="sip_users.first_name">'+data.sip_users.first_name+'</span> '+
                            '<span data-editor-field="sip_users.last_name">'+data.sip_users.last_name+'</span>'+
                        '</dd>'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<dt class="col-sm-2 control-label">E-mail:</dt>'+
                    '<div class="col-sm-10">'+
                        '<dd class="form-control" data-editor-field="sip_users.email">'+data.sip_users.email+'</dd>'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<dt class="col-sm-2 control-label">Phone:</dt>'+
                    '<div class="col-sm-10">'+
                        '<dd class="form-control" data-editor-field="sip_users.phone">'+data.sip_users.phone+'</dd>'+
                    '</div>'+
                '</div>'+
				'<div class="form-group">'+
                    '<dt class="col-sm-2 control-label">Telegram Username:</dt>'+
                    '<div class="col-sm-10">'+
                        '<dd class="form-control" data-editor-field="sip_users.telegram_username">'+(data.sip_users.telegram_username?data.sip_users.telegram_username:'')+'</dd>'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<dt class="col-sm-2 control-label">Company:</dt>'+
                    '<div class="col-sm-10">'+
                        '<dd class="form-control" data-editor-field="sip_users.company">'+data.sip_users.company+'</dd>'+
                    '</div>'+
                '</div>'+
                '<div class="form-group hidden">'+
                    '<dt class="col-sm-2 control-label">Photo ID:</dt>'+
                    '<div class="col-sm-10">'+
                        '<dd class="form-control" data-editor-field="sip_users.profile_photo">'+data.sip_users.profile_photo+'</dd>'+
                    '</div>'+
                '</div>'+
            '</dl>'+
            '<button class="btn button-edit btn-primary btn-block" data-id="'+id+'"><b>Edit</b></button>'+
        '</div>'
    ).appendTo( '#settings' );
}

$(document).ready(function() {
    $.ajaxSetup({
        complete: function(res) {
            if ( profile_photo ) {
                debug(editor.file('sip_posts', profile_photo));
                $('.profile-user-img').attr('src', '/'+editor.file('sip_posts', profile_photo).media_web_path);
            }
        },
        success: function (e) {
            debug(e);
        }
    });

    
    editor = new $.fn.dataTable.Editor( {
        ajax: {
            edit: {
                url: "/profile/edit",
                type: 'POST'
            },
            upload: {
                url: "/profile/upload",
                type: 'POST'
            }            
        },
        fields: [ {
                label: "First name:",
                name: "sip_users.first_name"
            }, {
                label: "Last name:",
                name: "sip_users.last_name"
            }, {
                label: "Phone:",
                name: "sip_users.phone"
			}, {
				label: "Telegram Username",
				name: "sip_users.telegram_username"
            }, {
                label: "Company",
                name: "sip_users.company"
            }, {
                label: "Password",
                name: "sip_users.password",
                type: "password"
            }, {
                label: "Photo:",
                name: "sip_users.profile_photo",
                type: "upload",
                display: function ( id ) {
                    debug(editor);
                    try {
                        return '<img src="/'+editor.file('sip_posts', id).media_web_path+'"/>';
                    }
                    catch ( err ) {
                        debug ( err );
                    }
                }
            }
        ]
    } );
 
    // Create record - on create we insert a new panel
    editor.on( 'postCreate', function (e, json) {
        createPanel( json.data[0] );
    } );
 
    // Edit
    $('#settings').on( 'click', '.button-edit', function () {
        editor
            .title('Edit Profile')
            .buttons('Save Profile')
            .edit( $(this).data('id') );

    } );
    
    // Load the initial data and display in panels
    $.ajax( {
        url: '/profile/get',
        type: 'POST',
        dataType: 'json',
        success: function ( json ) {
            for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                createPanel( json.data[i] );
            }
            // bind files data to the global Editor instance
           	if ( json && json.files ) {
        		$.each( json.files, function ( name, files ) {
        			$.fn.DataTable.Editor.files[ name ] = files;
        		} );
	        }
        }
    } );
    
    $( editor.field( 'sip_users.profile_photo' ).input() ).on( 'upload.editor', function (e, val) {
        //debug(e);
        //console.log( 'Image field has changed value', val );
    } );
    
    
    
} );