<?php
if ( !isset($carts) ) return;

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
        Invoices
        <small>List</small>
      </h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Examples</a></li>
			<li class="active">Invoice</li>
		</ol>
	</section>
	
	<!-- Main content -->
	
	<div class="pad margin no-print">
		<div class="callout callout-info" style="margin-bottom: 0!important;">
			<h4><i class="fa fa-info"></i> Note:</h4> This page has been enhanced for printing. Click the print button at the bottom of the invoice to test. </div>
	</div>
	
	
	
	<div class="row">
		<div class="col-lg-8 col-md-12">
<?php
for ( $i = 0; $i < count($carts); $i++ ) {
	
	$cart = $carts[$i];
	
	$shop = $cart->shop();
	$shop_owner = $shop->owner();
	
	$customer = $cart->customer();
	
?>
	
	
	<section class="invoice">
		<!-- title row -->
		<div class="row">
			<div class="col-xs-12">
				<h2 class="page-header">
            <i class="fa fa-shopping-cart"></i> <?php echo $shop->name; ?>
            <small class="pull-right">Date: <?php echo _ldate_($cart->create_at, '%d %B %Y'); ?></small>
          </h2> </div>
			<!-- /.col -->
		</div>
		<!-- info row -->
		<div class="row invoice-info">
			<div class="col-sm-4 invoice-col"> From <address>
            <strong><?php echo $shop_owner->first_name.' '.$shop_owner->last_name;?></strong><br>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            Phone: (804) 123-5432<br>
            Email: info@almasaeedstudio.com
          </address> </div>
			<!-- /.col -->
			<div class="col-sm-4 invoice-col"> To <address>
            <strong><?php echo $customer->first_name.' '.$customer->last_name; ?></strong><br>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            Phone: (555) 539-1037<br>
            Email: john.doe@example.com
          </address> </div>
			<!-- /.col -->
			<div class="col-sm-4 invoice-col"> <b>Invoice #FIXME<?php echo $cart->invoice_number; ?></b>
				<br>
				<br> <b>Order ID:</b> <?php echo $cart->id; ?>
				<br> <b>Payment Due:</b> <?php echo _ldate_($cart->due_date); ?>
				<br> <b>Account:</b> VIRTUAL ACCOUNT NUMBER </div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
		<!-- Table row -->
		<div class="row">
			<div class="col-xs-12 table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Qty</th>
							<th>Product</th>
							<th>Serial #</th>
							<th>Description</th>
							<th>Price</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>
<?php
	$items = $cart->items();
	$sub_total = 0;
	for ( $j = 0; $j < count($items); $j++ ) {	
		$item = $items[$j];
		$product = $item->product();
		
		$product_price = $item->base_price * $item->qty;
		$sub_total += $product_price;
?>
						<tr>
							<td class="text-center"><?php echo $item->qty; ?></td>
							<td><?php echo $product->name; ?></td>
							<td class="text-center"><?php echo $product->id; ?></td>
							<td><?php echo $product->description; ?></td>
							<td class="text-right"><?php echo _money_($item->base_price); ?></td>
							<td class="text-right"><?php echo _money_($sub_total); ?></td>
						</tr>
<?php
	}
	$tax            = 0.10;
	$shipping_price = 0;
	
	$tax_price      = $sub_total * $tax;
	$grand_total    = $sub_total + $tax_price + $shipping_price;
?>
					</tbody>
				</table>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
		<div class="row">
			<!-- accepted payments column -->
			<div class="col-xs-6">
				<p class="lead">Payment Methods:</p> <img src="/assets/static/adminlte/img/credit/visa.png" alt="Visa"> <img src="/assets/static/adminlte/img/credit/mastercard.png" alt="Mastercard"> <img src="/assets/static/adminlte/img/credit/american-express.png" alt="American Express"> <img src="/assets/static/adminlte/img/credit/paypal2.png" alt="Paypal">
				<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra. </p>
			</div>
			<!-- /.col -->
			<div class="col-xs-6">
				<p class="lead">Amount Due <?php echo _ldate_($cart->due_date); ?></p>
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th style="width:50%">Subtotal:</th>
							<td class="text-right"><?php echo _money_($sub_total); ?></td>
						</tr>
						<tr>
							<th>Tax (10%) <small class="text-danger">fix this later, stil hard coded</small></th>
							<td class="text-right"><?php echo _money_($tax_price); ?></td>
						</tr>
						<tr>
							<th>Shipping:</th>
							<td class="text-right"><?php echo _money_($shipping_price); ?></td>
						</tr>
						<tr>
							<th>Total:</th>
							<td class="text-right"><?php echo _money_($grand_total); ?></td>
						</tr>
					</table>
				</div>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
		<!-- this row will not appear when printing -->
		<div class="row no-print">
			<div class="col-xs-12"> <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
				<button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment </button>
				<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"> <i class="fa fa-download"></i> Generate PDF </button>
			</div>
		</div>
	</section>
	<!-- /.content -->
	<div class="clearfix"></div>
<?php
}
?>
		</div>
	</div>
</div>
<!-- /.content-wrapper -->