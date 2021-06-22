<?php 


$tabs = isset($tabs) ? array($tabs) : $workspace->tabs();


?>
<div class="box box-solid box-warning crowded-box">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-tasks"></i> Tasks for: <?php echo $workspace->name.' - '.$workspace->edition; ?></h3>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool"><i class="fa fa-file-text-o"></i></button>
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
		
	</div>
	<div class="box-body table-responsive">
		<table class="crowded-data-table-config table table-bordered table-condensed table-hover table-striped" data-order="[[ 3, &quot;asc&quot; ]]">
			<thead>
				<th>Item</th>
				<th>PIC</th>
				<th>Assignment</th>
				<th>Deadline</th>
				<th>Place</th>
				<th>Date</th>
				<th>Notes</th>
				<th>Status</th>
			</thead>
			<tbody>
				<?php
				for ( $i = 0; $i < count($tabs); $i++ ) {
					$tasks = $tabs[$i]->tasks();
					for ( $j = 0; $j < count($tasks) ; $j++ ) {
						$t = $tasks[$j];
				?>
				<tr>
					<td><?php echo $t->tabs()->rubric; ?></td>
					<td><?php echo $t->user()->first_name; ?></td>
					<td><?php echo $t->type; ?></td>
					<td data-sort="<?php echo $t->due_date; ?>"><?php echo _ldate_($t->due_date); ?></td>
					<td><?php echo $t->event_place; ?></td>
					<td><?php echo _ldate_($t->event_date); ?></td>
					<td><?php echo nl2br(htmlspecialchars($t->notes, ENT_QUOTES, 'UTF-8')); ?></td>
					<td><?php echo $t->status; ?></td>
				</tr>		
				<?php
					}
				}
				?>
		</table>
	</div>
</div>
