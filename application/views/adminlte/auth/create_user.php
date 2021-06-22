<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo lang('create_user_heading');?>
			<small><?php echo lang('create_user_subheading');?></small>
		</h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>

	<!-- Main content -->
    <section class="content">

		<?php echo form_open("auth/create_user");?>
		
			<div class="row">
				<div class="col-md-8 col-lg-6">
					<!-- Default box -->
					<div class="box box-solid box-success">
						<div class="box-header">
							<h3 class="box-title">New User</h3>
						</div>
						
						<div class="box-body">

							<div class="form-group">
								<?php echo lang('create_user_fname_label', 'first_name');?> <br />
								<?php echo form_input($first_name, null, 'class="form-control"');?>
							</div>

							<div class="form-group">
								<?php echo lang('create_user_lname_label', 'last_name');?> <br />
								<?php echo form_input($last_name, null, 'class="form-control"');?>
							</div>

							<?php
							if($identity_column !== 'email') {
								echo '<div class="form-group">sds';
								echo lang('create_user_identity_label', 'identity');
								echo '<br />';
								echo form_error('identity');
								echo form_input($identity, null, 'class="form-control"');
								echo '</div>';
							}
							?>

							<div class="form-group">
								<?php echo lang('create_user_company_label', 'company');?> <br />
								<?php echo form_input($company, null, 'class="form-control"');?>
							</div>

							<div class="form-group">
								<?php echo lang('create_user_email_label', 'email');?> <br />
								<?php echo form_input($email, null, 'class="form-control"');?>
							</div>

							<div class="form-group">
								<?php echo lang('create_user_phone_label', 'phone');?> <br />
								<?php echo form_input($phone, null, 'class="form-control"');?>
							</div>

							<div class="form-group">
								<?php echo lang('create_user_password_label', 'password');?> <br />
								<?php echo form_input($password, null, 'class="form-control"');?>
							</div>

							<div class="form-group">
								<?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
								<?php echo form_input($password_confirm, null, 'class="form-control"');?>
							</div>

						</div>
						<!-- /.box-body -->
						
						<div class="box-footer">
							<button type="submit" class="btn btn-app"><i class="fa fa-user-plus"></i> <?php echo lang('create_user_submit_btn'); ?></button>
							<button type="button" class="btn-go-back btn btn-app"><i class="fa fa-arrow-left"></i> <?php echo ('Back'); ?></button>
						</div>
						<!-- /.box-footer-->
						
					</div>
					<!-- /.box -->
					
				
				</div>
				<!-- /.col-md-4 -->
			
			</div>
			<!-- /.row -->
			
		<?php echo form_close();?>


	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->


