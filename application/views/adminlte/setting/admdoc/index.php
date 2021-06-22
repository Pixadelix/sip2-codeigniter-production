<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>it all starts here</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> WARNING!</h4>
            This module can be used to reset document number. Use it with cautions.
        </div>
		<!-- Default box -->
		<div class="box">
            
			<div class="box-header with-border">
				<h3 class="box-title">Archived Documents</h3>
				<div class="box-tools pull-right"></div>
			</div>
			<div class="box-body crowded-box">
                <table id="admin-document-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
				</table>
            </div>
			<!-- /.box-body -->
			<div class="box-footer">
            </div>
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
