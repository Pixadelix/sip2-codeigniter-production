<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo lang('edit_user_heading');?>
			<small><?php echo sprintf(lang('edit_user_subheading'), $user->first_name.' '.$user->last_name);?></small>
		</h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>

	<!-- Main content -->
    <section class="content">
	
		<?php echo form_open(uri_string());?>
			<div class="row">
				<div class="col-md-8 col-lg-6">
			
					<!-- Default box -->
					<div class="box box-solid box-warning">
						<div class="box-header">
							<h3 class="box-title"><?php echo $user->first_name.' '.$user->last_name;?></h3>
						</div>
						
						<div class="box-body">
							<div class="form-group">
								<?php echo lang('edit_user_fname_label', 'first_name');?>
								<?php echo form_input($first_name, null, 'class="form-control"');?>
							</div>
							
							<div class="form-group">
								<?php echo lang('edit_user_lname_label', 'last_name');?> <br />
								<?php echo form_input($last_name, null, 'class="form-control"');?>
							</div>
							
							<div class="form-group">
								<?php echo lang('edit_user_email_label', 'email');?> <br />
								<?php echo form_input($email, null, 'class="form-control"');?>
							</div>
							
							<div class="form-group">
								<?php echo lang('edit_user_company_label', 'company');?> <br />
								<?php echo form_input($company, null, 'class="form-control"');?>
							</div>
							
							<div class="form-group">
								<?php echo lang('edit_user_phone_label', 'phone');?> <br />
								<?php echo form_input($phone, null, 'class="form-control"');?>
							</div>
							
							<div class="form-group">
								<?php echo lang('edit_user_password_label', 'password');?> <br />
								<?php echo form_input($password, null, 'class="form-control"');?>
							</div>
							
							<div class="form-group">
								<?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
								<?php echo form_input($password_confirm, null, 'class="form-control"');?>
							</div>
			
							<?php if ($this->ion_auth->is_admin() || acl('user-manager')): ?>
							<div class="form-group">
								<h3><?php echo lang('edit_user_groups_heading');?></h3>
								<?php foreach ($groups as $group):?>
									<label class="checkbox">
									<?php
									$gID=$group['id'];
									$checked = null;
									$item = null;
									foreach($currentGroups as $grp) {
										if ($gID == $grp->id) {
											$checked= ' checked="checked"';
											break;
										}
									}
									?>
									<input class="minimal" type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>&nbsp;
									<?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
									</label>
								<?php endforeach?>
							</div>
							<?php endif ?>

						</div>
						<!-- /.box-body -->
						
						<div class="box-footer">
							<button type="submit" class="btn btn-app"><i class="fa fa-save"></i> <?php echo lang('edit_user_submit_btn'); ?></button>
							<button type="button" class="btn-go-back btn btn-app"><i class="fa fa-arrow-left"></i> <?php echo ('Back'); ?></button>
						</div>
						<!-- /.box-footer-->
						
					</div>
					<!-- /.box -->
					
					<?php echo form_hidden('id', $user->id);?>
					<?php echo form_hidden($csrf); ?>
				
				</div>
				<!-- /.col-md-8 -->

			</div>
			<!-- /.row -->
			
		<?php echo form_close();?>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->
