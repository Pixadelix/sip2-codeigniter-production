<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo lang('deactivate_heading');?>
			<small><?php echo sprintf(lang('deactivate_subheading'), $user->first_name.' '.$user->last_name);?></small>
		</h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>

	<!-- Main content -->
    <section class="content">
	
		<?php echo form_open("auth/deactivate/".$user->id);?>	
	
			<div class="row">
				<div class="col-md-8 col-lg-6">
		
					<!-- Default box -->
					<div class="box box-solid box-danger">
						<div class="box-header">
							<h3 class="box-title"><div id="infoMessage"><?php echo $user->first_name.' '.$user->last_name;?></div></h3>
						</div>
					
						<div class="box-body">
							<div class="form-group">
								<label class="col-md-1">
									<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
									<input type="radio" name="confirm" value="yes" checked="checked" class="minimal"/>
								</label>
							
								<label class="col-md-1">
									<?php echo lang('deactivate_confirm_n_label', 'confirm');?>
									<input type="radio" name="confirm" value="no" class="minimal"/>
								</label>
							</div>
						</div>
						<!-- /.box-body -->
					
						<div class="box-footer">
							<button type="submit" class="btn btn-app"><i class="fa fa-chevron-right"></i> <?php echo lang('deactivate_submit_btn'); ?></button>
							<button type="button" class="btn-go-back btn btn-app"><i class="fa fa-arrow-left"></i> <?php echo ('Back'); ?></button>
						</div>
						<!-- /.box-footer-->
					
					</div>
					<!-- /.box -->
				
		
					<?php echo form_hidden($csrf); ?>
					<?php echo form_hidden(array('id'=>$user->id)); ?>
				
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		
		<?php echo form_close();?>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

