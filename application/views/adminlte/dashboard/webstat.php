<style>
iframe {
    display: block;       /* iframes are inline by default */
    background: #000;
    border: none;         /* Reset default border */
    height: 100vh;        /* Viewport-relative units */
    --width: 100vw;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>it all starts here</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content" styl="padding-left: 0; padding-right: 0">
		<!-- Default box -->
		<div class="box">
			
			<div class="box-body">Start creating your amazing application!
				<form>
					<div class="form-group">
						<label class="col-sm-2 control-label">Choose Host</label>
						<div class="col-sm-8">
							<select name="host" class="form-control">
								<option value="//sip2.mediavista.id/dashboard/dashboard/goaccess">Prod 1</option>
								<option value="//pdsi.mediavista.id/webstat.php">Prod 2</option>
								<option value="//getlost.id/app/webstat.php">GetLost</option>
							</select>
						</div>
						<div class="col-sm-2">
							<button type="submit">Submit</button>
						</div>
					</div>
				</form>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	

	
		<iframe src="<?php echo "$host?host=$host"; ?>" width="100%" style="overflow:hidden;width:100%"></iframe>
	</section>
	<!-- /.content -->
	
	
</div>
<!-- /.content-wrapper -->
