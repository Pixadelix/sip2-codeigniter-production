<?php

global $TASK_TYPE_ICONS;
$workspace = $task->workspace();
$worksheet = $task->worksheet();
$user      = $task->user();

$status_style = get_status_style($task);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo (isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'); ?> 
		<small>detail</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">

		<div class="row">
		
			<div class="col-md-6 col-lg-5">
				
				<div class="panel <?php echo $status_style['panel']; ?>">
					<div class="panel-heading clearfix">
						<div class="panel-title pull-left">
							<h4># <?php echo $task->id; ?></h4>
						</div>
						<div class="btn-toolbar pull-right">
						
						
						</div>
					</div>
					
			
					<div class="list-group">
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
							<p class="list-group-item-text"><?php echo htmlspecialchars($task->notes); ?></p>
							
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
		</div>
	</section>
<?php

/* HISTORY */

if ( $task->notes_hist && is_serial($task->notes_hist) ) {
	$hist = unserialize($task->notes_hist);
	//var_dump($hist);
?>
	<section class="content-header">
		<h1>History Log</h1>
	</section>
	
	<section class="content">

		<div class="row">
		
			<div class="col-md-6 col-lg-5">
<?php
	$hist_number = 1;
	for ( $i = 0; $i < count($hist); $i++ ) {
		
		$task_hist = $hist[$i];
		$workspace = $task->workspace();
		$worksheet = $task->worksheet();
		$user      = $task->user();
		//var_dump($task_hist);
		//continue;
		if( !$task_hist || !is_object($task_hist) ) {
			//echo $task_hist;
			continue;
		}
		
		$log_size = mb_strlen(serialize($task_hist));
		
		$status_style = get_status_style($task_hist);
		
?>				

				<div class="panel <?php echo $status_style['panel']; ?>">
					<div class="panel-heading clearfix">
						<div class="panel-title pull-left">
							<h4>History log #<?php echo $hist_number++; ?></h4>
						</div>
					</div>
					<div class="list-group">
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
										<i class="fa <?php echo isset($TASK_TYPE_ICONS[$task_hist->type]) ? $TASK_TYPE_ICONS[$task_hist->type] : 'fa-tasks'; ?> fa-fw"></i>
										<?php echo ucwords(strtolower($task_hist->type)); ?>
										
									
									</em>
									<label class="label <?php echo $status_style['label']; ?>">
										<i class="fa fa-fw <?php echo $status_style['icon']; ?>"></i>
										<?php echo $task_hist->status; ?>
									</label>
								</div>
								<div class="col-xs-6">
									<em class="note"><i class="fa fa-user fa-fw"></i> <?php echo $user->first_name.' '.$user->last_name; ?></em>
								</div>
							</div>
							
							<div class="row">
								<div class="col-xs-6">
									<em class="note"><i class="fa fa-calendar fa-fw note"></i> date:</em>
									<p class="list-group-item-text"> <?php echo _ldate_($task_hist->event_date, '%d-%b-%y %H:%M'); ?></p>
								</div>
								<div class="col-xs-6">
									<em class="note"><i class="fa fa-calendar-check-o fa-fw note"></i> deadline:</em>
									<p class="list-group-item-text"> <?php echo _ldate_($task_hist->due_date, '%d-%b-%y'); ?></p>
								</div>
							</div>
								
								
							<em class="note"><i class="fa fa-map-signs fa-fw note"></i> event:</em>
							<p class="list-group-item-text"><?php echo $task_hist->event_name; ?></p>
								
							<em class="note"><i class="fa fa-map-marker fa-fw note"></i> location:</em>
							<p class="list-group-item-text"><?php echo $task_hist->event_place; ?></p>
								
							<em class="note"><i class="fa fa-file-text-o fa-fw note"></i> notes:</em>
							<p class="list-group-item-text"><?php echo html_entity_decode($task_hist->notes); ?></p>
								
							<!--em class="note"><i class="fa fa-tag fa-fw note"></i> status:</em>
							<p class="list-group-item-text">
								<label class="label <?php echo $status_style['label']; ?>">
									<i class="fa fa-fw <?php echo $status_style['icon']; ?>"></i>
									<?php echo $task_hist->status; ?>
								</label>
							</p-->
							
						</div>

						<div class="panel-footer">
							<div class="row note">
								<div class="col-xs-8">
									<i class="fa fa-database fa-fw"></i> <?php echo _ldate_($task_hist->create_at, '%a, %d/%m/%Y %H:%M'); ?><br/>
									<i class="fa fa-edit fa-fw"></i> <?php echo _ldate_($task_hist->update_at, '%a, %d/%m/%Y %H:%M'); ?><br/>
								</div>
								<div class="col-xs-4">
									<span class="pull-right">
										<?php echo Model\Users::find($task_hist->create_by)->first_name; ?><br/>
										<?php echo $task_hist->update_by ? Model\Users::find($task_hist->update_by)->first_name : ''; ?>
									</span>
								</div>
								<div class="col-xs-12">
									<em class="note">(log size: <?php echo $log_size; ?> bytes)</em>
								</div>
							</div>
						</div>
					</div>
				</div>
		
<?php

	}
?>
			</div>
		</div>
	</section>	

<?php
}
?>

</div>



