<?php
$photo = null;
if ( isset($profile->profile_photo) ||$profile->profile_photo ) {
    $photo = Model\Posts::find($profile->profile_photo);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small></small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content" data-editor-id="<?php echo $profile->id; ?>">
		<div class="row">
			<div class="col-md-3">
				<!-- Profile Image -->
				<div class="box box-primary">
					<div class="box-body box-profile">
                        <dd><img data-editor-field="sip_users.profile_photo" class="profile-user-img img-responsive img-circle" src="/<?php echo $photo ? $photo->media_web_path : 'assets/static/img/avatar.jpeg'; ?>" alt="User profile picture"></dd>
						<h3 class="profile-username text-center"><?php echo "$profile->first_name $profile->last_name"; ?></h3>
						<p class="text-muted text-center">
                            <?php
                                $groups = $profile->groups();
                                for( $i = 0; $i < count($groups); $i++ ) {
                                    $g = $groups[$i];
                                    switch ($g->name) {
                                        case 'admin':
                                        case 'director':
                                        case 'pimred':
                                        case 'editor':
                                        case 'reporter':
                                        case 'fotografer':
                                            echo $g->description.' ';
                                            //echo $i < count($groups) - 1 ? ', ' : '.';
                                        default:
                                            break;
                                    }
                                }
                            ?>
                        </p>
						<ul class="list-group list-group-unbordered">
                            <?php
                            for ( $i = 0; $i < count($task_summary); $i++ ) {
                                echo '<li class="list-group-item"> <b>'.ucfirst($task_summary[$i]['status']).'</b> <a class="pull-right">'.number_format($task_summary[$i]['total'], 0, ',', '.').'</a> </li>';
                            }
                            ?>

						</ul>
                    </div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
				<!-- About Me Box -->
<?php /*
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">About Me</h3> </div>
					<!-- /.box-header -->
					<div class="box-body"> <strong><i class="fa fa-book margin-r-5"></i> Education</strong>
						<p class="text-muted"> B.S. in Computer Science from the University of Tennessee at Knoxville </p>
						<hr> <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
						<p class="text-muted">Malibu, California</p>
						<hr> <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
						<p> <span class="label label-danger">UI Design</span> <span class="label label-success">Coding</span> <span class="label label-info">Javascript</span> <span class="label label-warning">PHP</span> <span class="label label-primary">Node.js</span> </p>
						<hr> <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
*/ ?>
			</div>
			<!-- /.col -->
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
						<li><a href="#timeline" data-toggle="tab">Timeline</a></li>
						<?php if ( isset($settings) && $settings ) { ?><li><a href="#settings" data-toggle="tab">Settings</a></li><?php } ?>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="activity">
							<!-- Post -->
<?php /*
							<div class="post">
								<div class="user-block"> <img class="img-circle img-bordered-sm" src="/assets/static/adminlte/img/user1-128x128.jpg" alt="user image"> <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span> <span class="description">Shared publicly - 7:30 PM today</span> </div>
								<!-- /.user-block -->
								<p> Lorem ipsum represents a long-held tradition for designers, typographers and the like. Some people hate it and argue for its demise, but others ignore the hate as they create awesome tools to help create filler text for everyone from bacon lovers to Charlie Sheen fans. </p>
								<ul class="list-inline">
									<li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
									<li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a> </li>
									<li class="pull-right"> <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                        (5)</a></li>
								</ul>
								<input class="form-control input-sm" type="text" placeholder="Type a comment"> </div>
							<!-- /.post -->
							<!-- Post -->
							<div class="post clearfix">
								<div class="user-block"> <img class="img-circle img-bordered-sm" src="/assets/static/adminlte/img/user7-128x128.jpg" alt="User Image"> <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span> <span class="description">Sent you a message - 3 days ago</span> </div>
								<!-- /.user-block -->
								<p> Lorem ipsum represents a long-held tradition for designers, typographers and the like. Some people hate it and argue for its demise, but others ignore the hate as they create awesome tools to help create filler text for everyone from bacon lovers to Charlie Sheen fans. </p>
								<form class="form-horizontal">
									<div class="form-group margin-bottom-none">
										<div class="col-sm-9">
											<input class="form-control input-sm" placeholder="Response"> </div>
										<div class="col-sm-3">
											<button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Send</button>
										</div>
									</div>
								</form>
							</div>
							<!-- /.post -->
							<!-- Post -->
							<div class="post">
								<div class="user-block"> <img class="img-circle img-bordered-sm" src="/assets/static/adminlte/img/user6-128x128.jpg" alt="User Image"> <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span> <span class="description">Posted 5 photos - 5 days ago</span> </div>
								<!-- /.user-block -->
								<div class="row margin-bottom">
									<div class="col-sm-6"> <img class="img-responsive" src="/assets/static/adminlte/img/photo1.png" alt="Photo"> </div>
									<!-- /.col -->
									<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-6"> <img class="img-responsive" src="/assets/static/adminlte/img/photo2.png" alt="Photo">
												<br> <img class="img-responsive" src="/assets/static/adminlte/img/photo3.jpg" alt="Photo"> </div>
											<!-- /.col -->
											<div class="col-sm-6"> <img class="img-responsive" src="/assets/static/adminlte/img/photo4.jpg" alt="Photo">
												<br> <img class="img-responsive" src="/assets/static/adminlte/img/photo1.png" alt="Photo"> </div>
											<!-- /.col -->
										</div>
										<!-- /.row -->
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->
								<ul class="list-inline">
									<li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
									<li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a> </li>
									<li class="pull-right"> <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                        (5)</a></li>
								</ul>
								<input class="form-control input-sm" type="text" placeholder="Type a comment"> </div>
							<!-- /.post -->
*/ ?>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="timeline">
							<!-- The timeline -->
<?php /*
							<ul class="timeline timeline-inverse">
								<!-- timeline time label -->
								<li class="time-label"> <span class="bg-red">
                          10 Feb. 2014
                        </span> </li>
								<!-- /.timeline-label -->
								<!-- timeline item -->
								<li> <i class="fa fa-envelope bg-blue"></i>
									<div class="timeline-item"> <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
										<h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
										<div class="timeline-body"> Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle quora plaxo ideeli hulu weebly balihoo... </div>
										<div class="timeline-footer"> <a class="btn btn-primary btn-xs">Read more</a> <a class="btn btn-danger btn-xs">Delete</a> </div>
									</div>
								</li>
								<!-- END timeline item -->
								<!-- timeline item -->
								<li> <i class="fa fa-user bg-aqua"></i>
									<div class="timeline-item"> <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
										<h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3> </div>
								</li>
								<!-- END timeline item -->
								<!-- timeline item -->
								<li> <i class="fa fa-comments bg-yellow"></i>
									<div class="timeline-item"> <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>
										<h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
										<div class="timeline-body"> Take me to your leader! Switzerland is small and neutral! We are more like Germany, ambitious and misunderstood! </div>
										<div class="timeline-footer"> <a class="btn btn-warning btn-flat btn-xs">View comment</a> </div>
									</div>
								</li>
								<!-- END timeline item -->
								<!-- timeline time label -->
								<li class="time-label"> <span class="bg-green">
                          3 Jan. 2014
                        </span> </li>
								<!-- /.timeline-label -->
								<!-- timeline item -->
								<li> <i class="fa fa-camera bg-purple"></i>
									<div class="timeline-item"> <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>
										<h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
										<div class="timeline-body"> <img src="http://placehold.it/150x100" alt="..." class="margin"> <img src="http://placehold.it/150x100" alt="..." class="margin"> <img src="http://placehold.it/150x100" alt="..." class="margin"> <img src="http://placehold.it/150x100" alt="..." class="margin"> </div>
									</div>
								</li>
								<!-- END timeline item -->
								<li> <i class="fa fa-clock-o bg-gray"></i> </li>
							</ul>
*/ ?>
						</div>
						<!-- /.tab-pane -->
                        <?php if ( isset($settings) && $settings ) { ?>
						<div class="tab-pane" id="settings">

						</div>
                        <?php } ?>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.nav-tabs-custom -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->