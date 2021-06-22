<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo (isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'); ?> 
		<small>list</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
	
		<div class="row">

<?php

global $TASK_TYPE_ICONS;
$tasks = is_array($tasks) ? $tasks : array($tasks);

for ( $i = 0; $i < count($tasks); $i++ ) {
	
	$task = $tasks[$i];
	
	if (!$task) { continue; }

	$workspace = $task->workspace();
	$worksheet = $task->worksheet();
	$user      = $task->user();

	$status_style = get_status_style($task);
    
    $vouchers = $task->vouchers();
	?>



		
		
			<div class="col-md-6 col-lg-5">
				
				<div class="panel <?php echo $status_style['panel']; ?>">
					<div class="panel-heading clearfix">
						<div class="panel-title pull-left">
							<h4># <?php echo $task->id; ?></h4>
						</div>
						<div class="btn-toolbar pull-right">
							<div class="btn-group">
								<a href="/my/my_task/<?php echo $task->id; ?>" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
							</div>
						</div>
					</div>
			
					<div class="list-group">
                        
                        <?php
                        if ( $task->fgrab ) {
                        ?>
                        
                            <?php
                            if ( $vouchers ) {
                                ?>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-lg-12">
                                    <em class="note"><i class="fa fa-motorcycle fa-fw"></i> grab corporate voucher code (quota <?php echo $task->fgrab; ?>): </em>
                                    <ol class="todo-list">
                                <?php
                                foreach ( $vouchers as $voucher ) {
                                    $v = $voucher->voucher();

                                    if ( $v->used_by ) {
                                    ?>
                                        <li>
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>
                                            <span style="text-transform: uppercase; font-family: 'Overpass Mono', monospace; font-weight: regular;">
                                                <?php echo ($v->code); ?>
                                            </span>
                                        </li>
                                    <?php
                                    } else {
                                    ?>

                                    <?php
                                    }
                                }
                                ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                                <?php
                            }
                            ?>
                        <?php
                        }    
                        ?>

						<div class="list-group-item">
							<div class="row">
								<div class="col-xs-6">
									<em class="note"><i class="fa fa-table fa-fw"></i> workspace: </em>
									<h4 class="list-group-item-heading"><?php echo $workspace->name; ?></h4>
								</div>
								<div class="col-xs-6">
									<em class="note"><i class="fa fa-bookmark fa-fw"></i> edition: </em>
									<h4 class="list-group-item-heading"><?php echo $workspace->edition; ?></h4>
								</div>
							</div>
						<!--/div>
						<div class="list-group-item"-->
							<em class="note"><i class="fa fa-book fa-fw"></i> worksheet: </em>
							<h4 class="list-group-item-heading">
								<?php echo ucwords(strtolower($worksheet->rubric)); ?>
							</h4>
							
							<em class="note"><i class="fa  fa-file-o fa-fw"></i> content: </em>
							<p class="list-group-item-text"><?php echo $worksheet->content; ?></p>
							
							<em class="note"><i class="fa fa-file-text-o fa-fw"></i> notes: </em>
							<p class="list-group-item-text"><?php echo $worksheet->notes; ?></p>
						</div>
						<div class="list-group-item">
						
							<div class="row">
								<div class="col-xs-6">
									<em class="note">
										<i class="fa <?php echo isset($TASK_TYPE_ICONS[$task->type]) ? $TASK_TYPE_ICONS[$task->type] : 'fa-tasks'; ?> fa-fw"></i>
										<?php echo ucwords(strtolower($task->type)); ?>
										
									
									</em>
									<label class="label <?php echo $status_style['label']; ?>">
										<i class="fa fa-fw <?php echo $status_style['icon']; ?>"></i>
										<?php echo $task->status; ?>
									</label>
								</div>
								<div class="col-xs-6">
									<em class="note"><i class="fa fa-user fa-fw"></i> <?php echo $user->first_name.' '.$user->last_name; ?></em>
								</div>
							</div>
									
							
							<div class="row">
								<div class="col-xs-6">
									<em class="note"><i class="fa fa-calendar fa-fw note"></i> date:</em>
									<p class="list-group-item-text"> <?php echo _ldate_($task->event_date, '%d-%b-%y %H:%M'); ?></p>
								</div>
								<div class="col-xs-6">
									<em class="note"><i class="fa fa-calendar-check-o fa-fw note"></i> deadline:</em>
									<p class="list-group-item-text"> <?php echo _ldate_($task->due_date, '%d-%b-%y'); ?></p>
								</div>
							</div>
								
							
							<em class="note"><i class="fa fa-map-signs fa-fw note"></i> event:</em>
							<p class="list-group-item-text"><?php echo $task->event_name; ?></p>
							
							<em class="note"><i class="fa fa-map-marker fa-fw note"></i> location:</em>
							<p class="list-group-item-text"><?php echo $task->event_place; ?></p>
							
							<em class="note"><i class="fa fa-file-text-o fa-fw note"></i> notes:</em>
							<p class="list-group-item-text"><?php echo $task->notes; ?></p>
							
							<!--em class="note"><i class="fa fa-tag fa-fw note"></i> status:</em>
							<p class="list-group-item-text">
								<label class="label <?php echo $status_style['label']; ?>">
									<i class="fa fa-fw <?php echo $status_style['icon']; ?>"></i>
									<?php echo $task->status; ?>
								</label>
							</p-->
							
						</div>

						<div class="panel-footer">
							<div class="row note">
								<div class="col-xs-8">
									<i class="fa fa-database fa-fw"></i> <?php echo _ldate_($task->create_at, '%a, %d/%m/%Y %H:%M'); ?><br/>
									<i class="fa fa-edit fa-fw"></i> <?php echo _ldate_($task->update_at, '%a, %d/%m/%Y %H:%M'); ?><br/>
								</div>
								<div class="col-xs-4">
									<span class="pull-right">
										<?php echo Model\Users::find($task->create_by)->first_name; ?><br/>
										<?php echo $task->update_by ? Model\Users::find($task->update_by)->first_name : ''; ?>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
	
			</div>
		

<?php

}

?>
		</div>

	</section>

</div>