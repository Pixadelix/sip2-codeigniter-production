<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>content</small></h1>
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
				<table id="splash-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%"></table>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<ol>
					<li>Only upload using a compressed zip file.</li>
					<li>If the file already exists on the server, it will be overwritten.</li>
					<li>Please provide 1 (one) html file as an index target page (*.html).</li>
					<li>The redirect script field is used to redirect the splash page.
						<code>example: redirect('http://www.yourwebsite.com', 10);</code>
						this will redirect the splash page to http://www.yourwebsite.com after 10 seconds.
						<code>Please include [http://] protocol in the redirect url.</code>
					</li>
				</ol>
			</div>
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
