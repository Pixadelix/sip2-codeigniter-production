<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo lang('index_heading');?>
			<small><?php echo lang('index_subheading');?></small>
		</h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>

	<!-- Main content -->
	<section class="content">
	
		<!-- Default box -->
		<div class="box box-solid box-primary crowded-box">
			<div class="box-header">
				<h3 class="box-title">Table Users</h3>
			</div>

			<div class="box-body table-responsive no-padding">

				<table class="small-data-table-config table table-condensed table-striped table-bordered table-hover" data-page-length="25">
					<thead>
					<tr>
						<th class="export"><?php echo lang('index_fname_th');?></th>
						<th class="export"><?php echo lang('index_lname_th');?></th>
						<th class="export"><?php echo lang('index_email_th');?></th>
						<th class="export">Phone</th>
						<th class="export">Company</th>
						<th class="export"><?php echo lang('index_groups_th');?></th>
						<th data-orderable="false"><?php echo lang('index_status_th');?></th>
						<th data-orderable="false"><?php echo lang('index_action_th');?></th>
						<th class="export">Last Login</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($users as $user):?>
						<tr>
							<td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($user->phone,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($user->company,ENT_QUOTES,'UTF-8');?></td>
							<td>
								<?php foreach ($user->groups as $group):?>
									<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?></br>
								<?php endforeach?>
							</td>
							<td class="text-center">
								<?php
								echo
									($user->active) ?
									anchor("auth/deactivate/".$user->id, '<i class="fa fa-toggle-on"></i> ', 'class="tn tn-default tn-block"')/*.lang('index_active_link')*/ :
									anchor("auth/activate/". $user->id, '<i class="fa fa-toggle-off"></i> ', 'class="tn tn-default tn-block"')/*.lang('index_inactive_link')*/;?>
								
							</td>
							<td>
								<a class="btn btn-default btn-xs" href="<?php echo base_url('auth/edit_user/'.$user->id); ?>"><i class="fa fa-edit"></i> Edit</a>
							</td>
							<td><?php echo htmlspecialchars((gmdate("Y-m-d H:i:s", $user->last_login)),ENT_QUOTES,'UTF-8');?></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>

			</div>
			<!-- /.box-body -->
			
			<div class="box-footer">
				<a href="<?php echo base_url('auth/create_user'); ?>" class="btn btn-app"><i class="fa fa-user-plus"></i>Add User</a>
				<a href="<?php echo base_url('auth/create_group'); ?>" class="btn btn-app"><i class="fa fa-group"></i>Add Group</a>
			</div>
			<!-- /.box-footer-->
			
		</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->
