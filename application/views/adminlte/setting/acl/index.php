
<!--link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/themes/default/style.min.css" /-->





<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Roles <small>below is roles access settings</small></h1>
		<?php echo $bread; ?>
    </section>

<!-- Main content -->
<section class="content">
	<div class="row">
	<?php
		$groups = Model\Groups::where_not_in('id', 1)->get();
		$groups = Model\Groups::all();
		foreach($groups as $g) {
			
			// skip for admin group because it privilege gets all (absolute power)
			if ( 1 == $g->id ) {
				continue;
			}
	?>
      
		<div class="col-md-3 connectedSortable">
			<div class="box box-warning collapsed-box box-solid">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $g->description; ?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
					</div>
				</div>
				<form class="form-role" action="<?php echo base_url('/setting/acl/roles/save'); ?>" method="post">
					<div class="box-body">
						<?php echo $g->name; ?>
						<div class="acl-resource-container-<?php echo $g->id; ?>"></div>
					</div>
					<div class="box-footer">
						<button type="button" class="btn btn-app btn-save-role" data-role-id="<?php echo $g->id; ?>"><i class="fa fa-save"></i>Save</button>
						<button type="button" data-role-id="<?php echo $g->id; ?>" class="btn-role btn btn-app"><i class="fa fa-refresh"></i>Reload</button>
					</div>
				</form>
				
				<div class="overlay overlay-<?php echo $g->id; ?> hidden">
					<i class="fa fa-refresh fa-spin"></i>
				</div>
			</div>
		</div>

	<?php
	}
	?>
	</div>
	
	<div id="event_result"></div>
	
</section>


<script>
function role_put(role_id) {
	var overlay = $('div.overlay-' + role_id);
	overlay.removeClass('hidden');
	var url = '<?php echo current_url().'/save'; ?>';
	var jstree = $('.acl-resource-container-' + role_id).jstree();
	
	if(jstree.get_selected == undefined) {
		overlay.addClass('hidden');
		return;
	}
	
	var resource = jstree.get_selected(), i, j;
	for(i = 0, j = resource.length; i < j; i++) {
		resource = resource.concat(jstree.get_node(resource[i]).parents);
	}
	resource = $.vakata.array_unique(resource);

	//console.log(resource);

	// Send the data using post
	var posting = $.post( url, { 'role_id': role_id, 'resource[]': resource } );

	// Put the results in a div
	posting.done(function( data ) {
//		var content = $( data ).find( "#content" );
//		$( "#result" ).empty().append( content );
		overlay.addClass('hidden');
	});
}

document.addEventListener('DOMContentLoaded',function(){

	$('button.btn-save-role').click(function (e) {
		var roleId = e.currentTarget.dataset['roleId'];
		role_put(roleId);
	});
	
	$('button.btn-role[data-role-id]').click(function (e) {
		e.preventDefault();
		var roleId = e.currentTarget.dataset['roleId'];
		var resourceRole = $('.acl-resource-container-'+roleId);
		
		if(resourceRole.jstree()) { resourceRole.jstree().destroy(); }
		
		resourceRole
			// listen for event
			.on('changed.jstree', function (e, data) {
				//console.log(data);
				resource = data.selected;
				$('#event_result').html('Selected: ' + roleId + ' = ' + resource);
			})
			.jstree({
				'core' : {
					'data' : {
						'url': function () { return '<?php echo current_url().'/get_menu_tree/'; ?>'+roleId; },
						'data': function (node) { return { 'id': node.id } },
					}
				},
				'checkbox' : {
					'keep_selected_style' : false,
					'three_state' : false,
					//'cascade' : 'up+undetermined',
				},
				'plugins' : [ 'checkbox', 'wholerow' ]
			});
	});
});

</script>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->