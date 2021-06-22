<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>list of all submitted reimburse documents</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
	
		<div class="row">
			<section class="col-lg-5 connectedSortable">
				
				<div class="box crowded-box box-solid box-purple">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-tag"></i> Requests list</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<table id="reim-mgr-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
						</table>
					</div>
				</div>
			
			</section>
			
			<section class="col-lg-7 connectedSortable">
				
				<div class="box box-warning crowded-box box-solid">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-tags"></i> Request items</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<table id="reim-dtl-mgr-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
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
			
			<section class="col-lg-8 connectedSortable">
				<div class="box box-primary crowded-box box-solid">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-history"></i> Change logs</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div id="change-log">Waiting for data</div>
					</div>
				</div>
			</section>
			
<script type="text/x-jsrender" id="change-log-template">
	{{if (logs.length == 0) }}
		No data
	{{else}}
		<ul class="todo-list">
		{{for logs}}
			{{if (date) }}
				<li>
					<!-- drag handle -->
					<span class="handle">
						<i class="fa fa-ellipsis-v"></i>
						<i class="fa fa-ellipsis-v"></i>
					</span>
					<?php /*
					<!-- checkbox -->
					<input type="checkbox" value="" class="square">
					*/ ?>
					<!-- todo text -->
					<span class="">{{:update_at}}<span class="label {{:labelcolor}}" style="font-weight: normal; width: 100px; display: inline-block; border: 1px solid #8a8a8a; margin-right: 10px; padding: 5px;"><i class="fa {{:icon}}"></i> {{:status}}</span> by: {{:update_by}}</span>
					<!-- Emphasis label -->
					
					<em class="note">(log size: {{:log_size}} bytes)</em>
					<?php /*
					<!-- General tools such as edit or delete-->
					<div class="tools">
						<i class="fa fa-edit"></i>
						<i class="fa fa-trash-o"></i>
					</div>
					*/ ?>
				</li>
			{{else}}
				{{if (change_log) }}
					{{:change_log}}
				{{else}}
					No data
				{{/if}}
			{{/if}}
		{{/for}}
		</ul>
	{{/if}}
</script>			
<?php
/*
			<section class="col-lg-8 connectedSortable">
				
				<div class="box box-primary crowded-box box-solid">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-image"></i> Receipts items</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<script type="text/x-jsrender" id="receipts-template">
							{{if (receipts.img.length == 0 && receipts.pdf.length == 0) }}
								No data
							{{else}}
								{{for receipts}}
									{{for img}}
										<a href="/{{:img_path}}"  class="html5lightbox" title="{{:ticket_dtl_id}}" data-group="receipts" data-thumbnail="/{{:thumbnail_path}}">
											<img src="/{{:thumbnail_path}}" class="with-border">
										</a>
									{{/for}}
									{{for pdf}}
										<a href="/{{:img_path}}"  class="html5lightbox" title="{{:ticket_dtl_id}}" data-group="receipts" data-thumbnail="/{{:thumbnail_path}}">
											<img src="/{{:thumbnail_path}}" width="50px">
										</a>
										{{/for}}
								{{/for}}
								{{/if}}
								
							
						</script>
						<div>
							<div id="receipts-list">Waiting for data</div>
						</div>
					</div>
				</div>
				
			</section>
*/ ?>
			
		</div>

	</section>
	
</div>