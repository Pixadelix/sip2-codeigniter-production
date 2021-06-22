<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>manager</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<!-- Default box -->
				<div class="box crowded-box box-purple with-border">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-send-o"></i> Telegram User</h3>
						<div class="box-tools pull-right"></div>
					</div>
					<div class="box-body">
						<table id="tlgrm-user-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%"></table>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
					</div>
					<!-- /.box-footer-->
				</div>
				<!-- /.box -->
			</div>
			<div class="col-lg-6">
				<div id="content-preview"></div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
