<?php
$r = $acl_resource;
//var_dump($r);

$parent_resources = Model\Acl_resource::result()->order_by('label')->all()->to_array();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Editing resource
		<small><?php echo $r->code; ?></small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
	
		<?php echo form_open(uri_string()); ?>
			<input type="hidden" name="id" value="<?php echo $r->id; ?>">
			<div class="row">
				<div class="col-md-8 col-lg-6">
		
					<!-- Default box -->
					<div class="box box-solid box-warning">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo $r->label; ?></h3>
							<div class="box-tools pull-right"></div>
						</div>
						<div class="box-body">
							
							
									<div class="form-group">
										<label class="control-label" for="code"><i class="fa fa-caret-right"></i> Parent</label>
										<select class="form-control select" name="parent_id">
											<option value="">-- No Parent --</option>
<?php
											foreach ($parent_resources as $p) {
												$selected = ($r->parent_id == $p['id']) ? ' selected="selected"' : '';
											
?>											<option value="<?php echo $p['id']; ?>"<?php echo $selected; ?>><?php echo $p['label']; ?></option>
<?php
											}
											?>
										</select>
										<span class="help-block">choose parent (optional)</span>
									</div>
								
							
							<div class="form-group has-warning">
								<label class="control-label" for="code"><i class="fa fa-caret-right"></i> Code</label>
								<input type="text" class="form-control" id="code" name="code" placeholder="Code" value="<?php echo gfsv('code', $r->code); ?>">
								<span class="help-block">enter value for 'Code' (required)</span>
							</div>
							
							<div class="form-group has-warning">
								<label class="control-label" for="label"><i class="fa fa-caret-right"></i> Label</label>
								<input type="text" class="form-control" id="label" name="label" placeholder="Label" value="<?php echo gfsv('label', $r->label); ?>">
								<span class="help-block">enter value for 'Label' (required)</span>
							</div>
							
							<div class="form-group has-warning">
								<label class="control-label" for="url"><i class="fa fa-caret-right"></i> Menu Type</label>
								<select class="form-control select" name="menu_type">
											<option value="">-- Choose Menu Type --</option>
<?php
											$menu_types = array(
												array('value' => 'core', 'label' => 'CORE'),
												array('value' => 'custom', 'label' => 'CUSTOM'),
											);
											foreach($menu_types as $menu_type) {
												$selected = ($menu_type['value'] == gfsv('menu_type', $r->menu_type)) ? ' selected="selected"' : '';
?>
											<option value="<?php echo $menu_type['value'];?>" <?php echo $selected; ?>><?php echo $menu_type['label']; ?></option>
<?php
											}
?>
										</select>
								<span class="help-block">choose 'Menu Type' (required)</span>
							</div>
							
							<div class="form-group">
								<label class="control-label" for="url"><i class="fa fa-caret-right"></i> URL</label>
								<input type="text" class="form-control" id="url" name="url" placeholder="URL" value="<?php echo gfsv('url', $r->url); ?>">
								<span class="help-block">enter value for 'URL' (optional)</span>
							</div>
							
							<div class="form-group">
								<label class="control-label" for="icon"><i class="fa fa-caret-right"></i> Icon</label>
								<div class="input-group iconpicker-container">
										<input id="icon" name="icon" data-placement="bottomRight" class="form-control icp icp-auto iconpicker-element iconpicker-input" type="text" value="<?php echo gfsv('icon', $r->icon); ?>">
										<span class="input-group-addon"><i class="fa fa-adn"></i></span>
									</div>
								<span class="help-block">choose 'Icon' (optional)</span>
							</div>
							
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<button type="submit" class="btn btn-app"><i class="fa fa-save"></i> <?php echo 'Save'; ?></button>
							<button type="button" class="btn-go-back btn btn-app"><i class="fa fa-arrow-left"></i> <?php echo ('Back'); ?></button>
						</div>
						<!-- /.box-footer-->
					</div>
					<!-- /.box -->
					
				</div>
				<!-- /.col-md-8 -->

			</div>
			<!-- /.row -->
		
		<?php echo form_close(); ?>
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