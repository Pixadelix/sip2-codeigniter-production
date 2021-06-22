<?php

if ( isset($post) && $post ) {
	
?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo $post->post_title; ?></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $post->post_title; ?></h3>
				<div class="box-tools pull-right"></div>
			</div>
			
<?php if ( isset($post) && $post->post_content ) { ?>
			<div class="box-body">
				<?php echo $post->post_content; ?>
			</div>
			<!-- /.box-body -->
<?php } ?>
			
<?php if ( isset($post_attachment) && $post_attachment ) { ?>
			<div class="box-footer">
				
				<a href="/<?php echo $post_attachment->media_web_path; ?>"  class="html5lightbox" title="<?php echo $post_attachment->media_filename; ?>" data-group="" data-thumbnail="/<?php echo $post_attachment->media_thumbnail_path; ?>">
					<img class="img-thumbnail" src="/<?php echo $post_attachment->media_thumbnail_path; ?>" class="with-border" style="max-width: 50px;">
				</a>
			</div>
			<!-- /.box-footer-->
<?php } ?>
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
	
}

?>