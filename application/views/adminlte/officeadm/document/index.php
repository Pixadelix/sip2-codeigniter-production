<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>list of all documents</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">


		<div class="row">
			<div class="col-md-8">
				<!-- Default box -->
				<div class="box crowded-box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">All Documents</h3>
						<div class="box-tools pull-right"></div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<table id="admin-document-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
								</table>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			
			<div class="col-md-4">
		
				<!-- Default box -->
				<div class="box crowded-box collapsed-box box-aqua">
					<div class="box-header with-border" data-widget="collapse">
						<i class="fa"></i><h3 class="box-title">Document Type list</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<table id="admin-document-type-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
								</table>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			
				<!-- Default box -->
				<div class="box crowded-box collapsed-box box-aqua">
					<div class="box-header with-border">
						<h3 class="box-title">Document Group list</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<table id="admin-document-group-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
								</table>
							</div>
						</div>
					</div>
					<!-- /.box-body -->

				</div>
				<!-- /.box -->
			</div>		
		
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->