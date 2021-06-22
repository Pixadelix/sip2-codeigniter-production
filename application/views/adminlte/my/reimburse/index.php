
<section class="content-header">
	<h1>My reimbursement request
	<small>list</small></h1>
	<?php echo isset($bread) ? $bread : null; ?>
</section>

<section class="content">
	<div class="row">
		<section class="col-lg-4 connectedSortable">
			
			<div class="box crowded-box box-solid box-purple">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-tag"></i> Requests list</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<table id="reim-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
					</table>
				</div>
			</div>
		
		</section>
		
		<section class="col-lg-8 connectedSortable">
				
			<div class="box box-warning crowded-box box-solid">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-tags"></i> Request items</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<table id="reim-dtl-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
						<thead>
							<tr>
								<th width="10px"></th>
								<th width="30px">ID</th>
								<th>Date</th>
								<th width="30%">Notes</th>
								<th>Type</th>
								<th>Status</th>
								<th>Qty</th>
								<th>Unit Price</th>
								<th>Open Amount</th>
								<th>Receipts</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								
								<th colspan="8" class="text-right">Total:</th>
								<th id="total" class="text-right monospace"></th>
								<th></th>
							</tr>
						</tfoot>
						<tbody></tbody>
					</table>
				</div>
			</div>
			
		</section>

</section>