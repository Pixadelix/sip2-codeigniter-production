<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>setting</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box crowded-box box-purple">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
				<div class="box-tools pull-right"></div>
			</div>
			<div class="box-body">
				<table id="task-types-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%"></table>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">Footer</div>
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
