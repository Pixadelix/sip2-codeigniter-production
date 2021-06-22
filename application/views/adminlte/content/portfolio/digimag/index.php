<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>flip magazine</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<!-- Default box -->
				<div class="box crowded-box box-purple with-border">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> Flip Magazines</h3>
						<div class="box-tools pull-right"></div>
					</div>
					<div class="box-body">
						<table id="digimag-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%"></table>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
                        <ol>
                            <li>Only upload using a compressed zip file.</li>
                            <li>If the file already exists on the server, it will be overwritten.</li>
                            <li>Please provide 1 (one) html file as an index target page (*.html).</li>
                            <li>For Flipmag please provide 1 (one) image file as a cover page in folder `$(root)/files/page/' (*.jpg).</li>
                            <li>For DPS like please provide 1 (one) image file as cover page in folder `$(root)' (*.png).</li>
                        </ol>
					</div>
					<!-- /.box-footer-->
				</div>
				<!-- /.box -->
			</div>
			<div class="col-lg-12">
				
                <!-- Default box -->
				<div class="box crowded-box box-purple with-border">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-file-text-o"></i> Preview</h3>
						<div class="box-tools pull-right"></div>
					</div>
					<div class="box-body">
						<div id="content-preview"></div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
					</div>
					<!-- /.box-footer-->
				</div>
				<!-- /.box -->
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
