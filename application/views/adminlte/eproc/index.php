

<!--script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="VT-client-4ceymOCQcozPJliH">
</script-->

<form id="payment-form" method="post" action="<?=site_url()?>/snap/finish">
	<input type="hidden" name="result_type" id="result-type" value="">
	<input type="hidden" name="result_data" id="result-data" value="">
</form>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>Status</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
<?php
if ( $subscriptions ) {

	$dt_start = new DateTime($subscriptions->create_at);
	$dt_end = new DateTime($subscriptions->expired_date);
	$remain = $dt_end->diff(new DateTime());

	$total = $dt_end->diff($dt_start);

	$percent =  round ( ( (int) $total->format('%a') - (int) $remain->format('%a') ) / (int) $total->format('%a') * 100, 2 );


//echo $remain->d . ' days and ' . $remain->h . ' hours';

?>
<pre>
create at  : <?php echo $subscriptions->create_at; ?> 
expired at : <?php echo $subscriptions->expired_date; ?> 
running    : <?php echo $total->format('%a') - $remain->format('%a'); ?> day(s)
remains    : <?php echo $remain->format('%a'); ?> day(s)
total      : <?php echo $total->format('%a'); ?> day(s)
percent    : <?php echo $percent; ?>%
</pre>

		<div class="row">
			<div class="col-md-12 col-sm-6 col-xs-12">
				<div class="info-box bg-yellow"> <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
					<div class="info-box-content">

						<div class="col-xs-4">
							<span class="info-box-text">Active from</span> <span class="info-box-number"><?php echo _ldate_($subscriptions->create_at, '%A, %d %B %Y'); ?></span>
						</div>
						
						<div class="col-xs-4">
							<span class="info-box-text">Active until</span> <span class="info-box-number"><?php echo _ldate_($subscriptions->expired_date, '%A, %d %B %Y'); ?></span>
						</div>

						<div class="progress">
							<div class="progress-bar" style="width: <?php echo $percent; ?>%"></div>
						</div> <span class="progress-description">
                    <?php echo $remain->format('%a'); ?> Day(s) remaining
                  </span> </div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
		</div>
		
<?php
	
} else {
?>
		<div class="row">
			<div class="col-md-12 col-sm-6 col-xs-12">
				<div class="info-box bg-yellow"> <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
					<div class="info-box-content">

						<div class="col-xs-4">
							<span class="info-box-text">Subscription info</span>
							<span class="info-box-number">No Active Subscription Plan</span>
						</div>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
		</div>
<?php
}


if ( isset($products) && $products ) {
	
	$bg_colors = array(
		'bg-aqua',
		'bg-purple',
		'bg-green',
		'bg-green',
		'bg-purple',
		'bg-aqua',
	);

	setlocale(LC_MONETARY, 'id_ID');


	echo '<div class="row">';

	for ( $i = 0; $i < count($products); $i++ ) {

		$plan = $products[$i];
		$base_price = _money_($plan->base_price);

		echo <<<EOT
		<div class="col-lg-4 col-xs-6">
			<!-- small box -->
			<div class="small-box $bg_colors[$i]">
				<div class="inner">
					<h3>$plan->name</h3>
					<p>$plan->description</p>
					<p>@ $base_price</p>
				</div>
				<div class="icon"> <i class="fa fa-shopping-cart"></i> </div>
				<a href="/cart/add_item/$plan->id" class="small-box-footer" data-product-id="$plan->id">
					<i class="fa fa-plus-circle"></i> Add to cart
				</a>
			</div>
		</div>
EOT;
	}

	echo '</div>';
}
		
?>
	
	</section>
	
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>Settings</small></h1> </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-6">
				<!-- Default box -->
				<div class="box crowded-box box-purple with-border">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-bank"></i> Monitored LPSE</h3>
						<div class="box-tools pull-right"></div>
					</div>
					<div class="box-body">
						<table id="monitored-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%"></table>
					</div>
					<!-- /.box-body -->
					<div class="box-footer"> </div>
					<!-- /.box-footer-->
				</div>
				<!-- /.box -->
			</div>
			<div class="col-lg-6">
				<!-- Default box -->
				<div class="box crowded-box box-purple with-border">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-key"></i> Keywords</h3>
						<div class="box-tools pull-right"></div>
					</div>
					<div class="box-body">
						<table id="keyword-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%"></table>
					</div>
					<!-- /.box-body -->
					<div class="box-footer"> </div>
					<!-- /.box-footer-->
				</div>
				<!-- /.box -->
			</div>
			<div class="col-lg-6">
				<div id="content-additional-info"></div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->