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
			<div class="col-md-7">
				<!-- Default box -->
				<div class="box crowded-box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">Available Voucher</h3>
						<div class="box-tools pull-right"></div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<table id="voucher-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
								</table>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
                
                
                <!-- Default box -->
				<div class="box crowded-box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">Used/Expired Voucher</h3>
						<div class="box-tools pull-right"></div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<table id="used-voucher-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
								</table>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			
			<div class="col-md-5">
                <!-- Default box -->
				<div class="box crowded-box box-purple">
					<div class="box-header with-border">
						<h3 class="box-title">Voucher Uploader</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<table id="voucher-uploader" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%"></table>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
                    <div class="box-footer">
                        <ol>
                            <li>Please use standart Excel 2007-2013 (xlsx) format.</li>
                            <li>Column A for Voucher Code.</li>
                            <li>Column B for Starting Date.</li>
                            <li>Column C for Expired Date.</li>
                            <li>Row 1 will be used as header.</li>
                        </ol>
					</div>
					<!-- /.box-footer-->
				</div>
				<!-- /.box -->
		
				<!-- Default box -->
				<div class="box crowded-box collapsed-box box-darkred">
					<div class="box-header with-border" data-widget="collapse">
						<i class="fa"></i><h3 class="box-title">Voucher Type list</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<table id="voucher-type-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
								</table>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			
				<!-- Default box -->
				<div class="box crowded-box collapsed-box box-orchid">
					<div class="box-header with-border">
						<h3 class="box-title">Voucher Group list</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<table id="voucher-group-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
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