<?php

$posts = Model\Posts::where(
	array(
		'post_type' => 'post',
		'post_status' => 'published',
		'front_page' => 1
	))
	->order_by('post_date', 'desc')
	->get();

//return;

if ( ! $posts ) return;

$posts = is_array($posts) ? $posts : array($posts);

?>

				<div class="box box-info with-border">
					<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
						<i class="fa fa-newspaper-o"></i> News
						<div class="pull-right box-tools">
							<button type="button" class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					
					<div class="box-body">
						<ul class="products-list product-list-in-box">
							
<?php

foreach ( $posts as $post ) {
	$dt = explode('/', date('Y/m/d', strtotime($post->post_date) ) );
	$perma_link = '';
	$perma_link = '/post/'.$dt[0].'/'.$dt[1].'/'.$dt[2].'/'.$post->id.'/'.$post->post_name;
	$author = $post->author() ? $post->author()->first_name.', ' : '';
	
	$post_attachment = Model\Posts::find($post->post_parent);
	//var_dump($post_attachment);
	
	$img_thumbnail = $post_attachment && $post_attachment->media_thumbnail_path ? '/'.$post_attachment->media_thumbnail_path : '/assets/static/adminlte/img/default-50x50.gif';
?>

							<li class="item">
								<div class="product-img">
									<img src="<?php echo $img_thumbnail; ?>" alt="Product Image" class="mg-thumbnail ith-border">
								</div>
								<div class="product-info">
									<a href="<?php echo $perma_link; ?>" class="product-title"><?php echo $post->post_title; ?>
									<span class="label label-info pull-right"><?php echo $author._ldate_($post->post_date); ?></span></a>
									<span class="product-description"><?php echo $post->post_excerpt; ?></span>
								</div>
							</li>
<?php 
}
?>
						</ul>
					</div>
				</div>
