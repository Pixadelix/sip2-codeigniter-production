

<div class="content-wrapper">

	<section class="content-header">
		<h1><?php echo (isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'); ?> 
		<small></small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>

	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Query Parameter</h3>
				<div class="box-tools pull-right"></div>
			</div>
			<div class="box-body">

				<!-- Date range -->
				<div class="form-group">
					<label>Date range:</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control pull-right" id="range-date" name="range_date">
					</div>
					
				</div>
				
			</div>
			<div class="box-footer"><button id="load" class="btn btn-app"><i class="fa fa-database"></i> Execute</button></div>
		</div>
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Monthly Load Report</h3>
				<div class="box-tools pull-right"></div>
			</div>
			<div class="box-body" style="height: 400px">
				<div id="load-chart" style="width: 100%; height: 100%"></div>
			</div>
		</div>
	</section>
	
</div>


