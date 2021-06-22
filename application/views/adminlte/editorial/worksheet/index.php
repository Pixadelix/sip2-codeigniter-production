<?php

$tabs = $workspace->tabs();

?>
<div class="box box-solid box-success crowded-box">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-book"></i> Workspace items for: <?php echo $workspace->name.' - '.$workspace->edition; ?></h3>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool"><i class="fa fa-file-text-o"></i></button>
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
	</div>
	<div class="box-body table-responsive">
	
		<table class="crowded-data-table-config table table-bordered table-condensed table-hover table-striped" data-order="[[ 0, &quot;asc&quot; ]]">
			<thead>
				<th>#</th>
				<th style="width: 10px;">P.Num</th>
				<th style="width: 20px;">P.Cnt</th>
				<th>Item</th>
				<th>Content</th>
				<th>Source</th>
				<th>Notes</th>
				<th>Task</th>
			</thead>
			<tbody>
				<?php
				$total_pages = 0;
				$start_page = 1;
				for ($i = 0; $i < count($tabs) ; $i++ ) {
					
					$t = $tabs[$i];
					
					$total_pages = $total_pages + $t->pages;
					$start_page = $total_pages - $t->pages + 1;
					
					$s = str_pad($start_page, 2, '0', STR_PAD_LEFT);
					$e = str_pad($total_pages, 2, '0', STR_PAD_LEFT);
					
				?>
				<tr>
					<td class="text-right"><?php echo $t->position; ?>.</td>
					<td class="text-center"><?php echo "$s - $e" ; ?></td>
					<td class="text-center"><?php echo $t->pages; ?></td>
					<td>
						<a href="/editorial/tasks/get/<?php echo $t->id; ?>" class="ajax"
							data-key-id="<?php echo $t->id; ?>"
							data-action-url="/editorial/tasks/get/"
							data-target-container=".tasks-container"><?php echo $t->rubric; ?>
						</a>
					</td>
					<td><?php echo nl2br(htmlspecialchars($t->content, ENT_QUOTES, 'UTF-8')); ?></td>
					<td><?php echo $t->source; ?></td>
					<td><?php echo $t->notes; ?></td>
					<td><?php echo count($t->tasks()); ?>
				</tr>		
				<?php
				}
				?>
		</table>
		
	</div>
</div>
