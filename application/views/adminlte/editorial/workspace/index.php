<script>
	var $WORKSPACE_ID = <?php echo ($id ? $id : 'false'); ?>;
</script>


<div class="content-wrapper">
	
	<section class="content-header">
		<h1>Workspace Editor
		<small>all workspace gather here</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	
	<section class="content">
	
		<div class="row">
			<section class="col-lg-5 connectedSortable">
				
				<div class="box crowded-box box-solid box-orchid collapsed-box">
					<div class="box-header with-border">
						<i class="fa fa-briefcase"></i><h3 class="box-title"> Choose Projects</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<table id="projects-datatable" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
							<tr><td><center><button id="btn-load-projects" type="button" class="btn btn-app no-margin"><i class="fa fa-cloud-download"></i> Load Table</button></center></td></tr>
						</table>
					</div>
					
				</div>
				
				<div class="box box-success crowded-box with-border">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-table"></i> Available Workspace</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<table id="workspace-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
						</table>
					</div>
					<div class="box-footer"><button class="btn btn-sm btn-default"><i class="fa fa-question"></i></button></div>
				</div>
			
		
				
				
				<div class="row">
					<div class="col-lg-12 connectedSortable">
						<div class="box box-danger with-border">
							<div class="box-header with-border">
								<h3 class="box-title"><i class="fa fa-pie-chart"></i> Workload <small class="title-window"></small></h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body">
								<div id="task-workload-chart"></div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 connectedSortable">
						<div class="box box-warning with-border">
							<div class="box-header with-border">
								<h3 class="box-title"><i class="fa fa-pie-chart"></i> Overall Workload <small class="">(All Active Project)</small></h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body">
								<div id="overall-workload-chart"></div>
							</div>
						</div>
						
					</div>
					
				</div>

			</section>

			<div class="col-lg-7">
			
				<?php echo isset($WORKSHEET_CONTAINER) ? $WORKSHEET_CONTAINER : ''; ?>
				
				<?php echo isset($TASK_CONTAINER) ? $TASK_CONTAINER : ''; ?>
				
				<div class="box box-danger with-border">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-bar-chart"></i> Progress <small class="title-window"></small></h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div id="task-progress-chart"></div>
					</div>
				</div>
				
			
				<div class="box box-warning with-border">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-line-chart"></i> Overall Progress <small class="">(All Active Project)</small></h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div id="overall-progress-chart"></div>
					</div>
				</div>

			</div>
			

				

			
		</div>
		
		

	</section>
</div>



