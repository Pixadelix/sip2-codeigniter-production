<script>
	var $WORKSPACE_ID = <?php echo ($id ? $id : 'false'); ?>;
</script>

<div class="content-wrapper">

	<section class="content-header">
		<h1>
			Project
			<small>status</small>
		</h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>

	<section class="content">

		
		
			<div class="row ">
				<div class="col-md-5 connectedSortable">
					<div class="box crowded-box box-solid box-orchid">
						<div class="box-header with-border">
							<i class="fa fa-briefcase"></i><h3 class="box-title"> Choose Projects</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							<table id="projects-datatable" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
							</table>
						</div>
						<!-- /.box-body -->
					</div>
					
					<div class="box crowded-box box-success">
						<div class="box-header with-border">
							<i class="fa fa-table"></i><h3 class="box-title"> Workspace</h3>
						</div>
						<div class="box-body">
							<table id="workspace-datatable" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
							</table>
						</div>
						<!-- /.box-body -->
					</div>
				</div>
				
				<div class="col-md-7 connectedSortable">
					<div class="box crowded-box box-aqua with-border">
						<div class="box-header with-border">
							<i class="fa fa-book"></i><h3 class="box-title"> Worksheet</h3>
						</div>
						<div class="box-body">
							<table id="worksheet-datatable" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
							</table>
						</div>
						<!-- /.box-body -->
					</div>
				
					<div class="box crowded-box box-purple with-border">
						<div class="box-header with-border">
							<i class="fa fa-tasks"></i><h3 class="box-title"> Task</h3>
						</div>
						<div class="box-body">
							<table id="task-datatable" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
							</table>
						</div>
						<!-- /.box-body -->
					</div>
				</div>
			
		</div>

			
	</section>
	
</div>