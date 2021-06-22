<?php



?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Resources Editor </h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box box-solid box-primary crowded-box">
			<div class="box-header with-border">
				<h3 class="box-title">Table ACL Resources</h3>
			</div>

			
			<div class="box-body table-responsive no-padding">
			
				<table class="small-data-table-config table table-condensed table-striped table-bordered table-hover" data-page-length="25">
					<thead>
						<tr>
							<th class="export">#</th>
							<!--th class="export">ID.</th-->
							<th class="export">Label</th>
							<th class="export">Parent</th>
							<th class="export">Code</th>
							<th class="export">URI</th>
							<th data-orderable="false">Icon</th>
							<th class="export">Pos</th>
							<th class="export">Type</th>
							<th data-orderable="false">Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$i = 0;
					foreach($acl_resource as $r) {
						++$i;
					?>
						<tr>
							<td class="text-right"><?php echo $i;?>.</td>
							<!--td class="text-right"><?php echo $r['id'];?>.</td-->
							<td><!--small><?php echo !$r['parent_id'] ? '<i class="fa fa-bars fa-fw"></i>' : ''; ?></small--> <a href="/setting/resources/edit/<?php echo $r['id']; ?>"><?php echo ($r['parent_id'] ? ' - ' : '') . $r['label']; ?></a></td>
							<td><?php echo grl($r['parent_id'], $acl_resource); ?></td>
							<td><?php echo $r['code']; ?></td>
							
							<td><?php echo $r['url']; ?></td>
							<td><i class="fa <?php echo $r['icon']; ?>"></i></td>
							<td>
								<?php echo $r['position']; ?>
							</td>
							<td><?php echo $r['menu_type']; ?></td>
							<td>
								<!--div class="btn-group dropdown">
									<button type="button" class="btn btn-default">Action</button>
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu"-->
									<style>
									ul.buttons { list-type: none outside none; }
									ul.buttons li { display: inline; }
									</style>
									<ul class="buttons text-center">
										<li><a href="<?php echo current_url().'/edit/'.$r['id']; ?>"><i class="fa fa-edit text-success"></i></a></li>
										<li><a href="<?php echo current_url().'/delete/'.$r['id']; ?>"><i class="fa fa-trash text-danger"></i></a></li>
										<li><a href="<?php echo current_url().'/up/'.$r['id']; ?>"><i class="fa fa-chevron-up"></i></a></li>
										<li><a href="<?php echo current_url().'/down/'.$r['id']; ?>"><i class="fa fa-chevron-down"></i></a></li>
									</ul>
									<!--/ul-->
								</div>
							</td>
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			
			
			
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<a href="<?php echo base_url('/setting/resources'); ?>" class="btn btn-app"><i class="fa fa-refresh"></i>Refresh</a>
				<a href="<?php echo base_url('/setting/resources/create_menu'); ?>" class="btn btn-app"><i class="fa fa-plus"></i>Add Resources</a>
				<a href="<?php echo base_url('/setting/resources/rearrange'); ?>" class="btn btn-app"><i class="fa fa-sort-amount-asc"></i>Rearrange</a>
			</div>
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
document.addEventListener("DOMContentLoaded", function(event) {
	$(function () {
		
	});
});
</script>