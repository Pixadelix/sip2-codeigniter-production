<div class="content-wrapper">

	<section class="content-header">
		<h1>
			Clients and Projects
			<small>configuration</small>
		</h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>

	<section class="content">
		
		<div class="row connectedSortable">
			<div class="col-md-6">
	
				<div class="box crowded-box box-purple">
					<div class="box-header with-border">
						<i class="fa fa-globe"></i><h3 class="box-title"> Clients</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<table id="clients-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
						</table>
					</div>
					<!-- /.box-body -->
				</div>

			</div>
			
			<div class="col-md-6">
	
				<div class="box crowded-box box-orchid">
					<div class="box-header with-border">
						<i class="fa fa-briefcase"></i><h3 class="box-title"> Projects</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<table id="projects-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
						</table>
					</div>
					<!-- /.box-body -->
				</div>

			</div>
			
		</div>
	</section>
	
</div>