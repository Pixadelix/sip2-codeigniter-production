<style>
    img.with-border {
        border: 1px solid rgba(200,200,200,0.60);
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small></small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Digital Magazines</h3>
				<div class="box-tools pull-right"></div>
			</div>
            <div class="box-body">
                
                
<?php
$cnt = 0;
foreach ( $digimags as $digimag ) {
    $attachment = Model\Posts::find($digimag->post_parent);
    if ( $attachment ) {
        
        if ( $cnt == 0 ) {
?>
                
                <div class="row">
                    <div class="col-md-3">
                        <a href="<?php echo base_url().$attachment->post_content; ?>" data-title="<?php echo $digimag->post_title; ?>">
                            <img class="img-responsive with-border" src="/<?php echo $attachment->post_excerpt; ?>">
                        </a>
                    </div>
                    <div class="col-md-9">
                        <h2 class="">
                            <a href="<?php echo base_url().$attachment->post_content; ?>" data-title="<?php echo $digimag->post_title; ?>"><?php echo $digimag->post_title; ?></a>
                        </h2>
                        <p class="clearfix"><?php echo $digimag->post_content; ?></p>
                    </div>
                </div>
            </div>
            <div class="box-body">

                
                <div class="row pad">

<?php
        }
        
        if ( $cnt >= 1 ) {
?>
                    <div class="col-md-2">
                        <a href="<?php echo base_url().$attachment->post_content; ?>" data-title="<?php echo $digimag->post_title; ?>">
                            <img class="img-responsive with-border" src="/<?php echo $attachment->post_excerpt; ?>">
                        </a>
                        <h4 class="">
                            <a href="<?php echo base_url().$attachment->post_content; ?>" data-title="<?php echo $digimag->post_title; ?>"><?php echo $digimag->post_title; ?></a>
                        </h4>
                    </div>
<?php
        }
        $cnt++;
        
        if ( $cnt % 6 == 1) {
            echo '</div><div class="row pad">';
        }
    }
}
?>

                </div>
                
            </div>
			<!-- /.box-body -->
			<div class="box-footer"></div>
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

