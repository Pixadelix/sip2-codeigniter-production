<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo lang('create_group_heading');?>
			<small><?php echo lang('create_group_subheading');?></small>
		</h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>

	<!-- Main content -->
    <section class="content">
		
		<?php echo form_open("auth/create_group");?>
		
			<div class="row">
				<div class="col-md-8 col-lg-6">
		
					<!-- Default box -->
					<div class="box box-solid box-success">
						<div class="box-header">
							<h3 class="box-title">New Group</h3>
						</div>
					
						<div class="box-body">
							<div class="form-group">
								<?php echo lang('create_group_name_label', 'group_name');?> <br />
								<?php echo form_input($group_name, null, 'class="form-control"');?>
							</div>
							<div class="form-group">
								<?php echo lang('create_group_desc_label', 'description');?> <br />
								<?php echo form_input($description, null, 'class="form-control"');?>
							</div>

						</div>
						<!-- /.box-body -->
						
						<div class="box-footer">
							<button type="submit" class="btn btn-app"><i class="fa fa-users"></i> <?php echo lang('create_group_submit_btn'); ?></button>
							<button type="button" class="btn-go-back btn btn-app"><i class="fa fa-arrow-left"></i> <?php echo ('Back'); ?></button>
						</div>
						<!-- /.box-footer-->
					
					</div>
					<!-- /.box -->

				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		
		<?php echo form_close();?>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->
