<style>
	#calendar {
		padding-top: 10px;
	}
	
	.fc-sat .fc-day-number,
	.fc-sun .fc-day-number {
		color: #f55;
		font-weight: bold;
	}
	
	.qtip-content ul {
		padding-left: 10px;
	}
	
	.past-event .fc-title {
		opacity: .3;
	}
	
	.allday-event {}
	
	.gcal-holiday-event,
	.gcal-holiday-event:hover {
		color: #b71c1c;
		border-color: transparent;
		background-color: transparent;
		/*background-color: #B71C1C !important;
	border-color: #B71C1C !important;*/
	}
	
	.gcal-us-holiday-event,
	.gcal-us-holiday-event:hover {
		color: #e71c1c;
		background-color: transparent;
		border-color: transparent;
	}
	
	@media (max-width: 768px) {
		.fc-toolbar h2 {
			padding-top: 16px;
			font-size: 16px;
		}
	}
	
	.fc-icon {
		font-family: 'FontAwesome' !important;
	}
	
	.fc-icon-calendar:before {
		content: "\f073";
	}
	
	.fc-event {
		border-radius: 0px;
	}
	
	.fc-day-grid-event {
		margin: 0px;
		padding: 2px;
	}
</style>
<div class="content-wrapper">
	<section class="content-header">
		<h1><?php echo (isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'); ?> 
		<small>home</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<section class="content">
		
		<div class="row">
			
			
			<section class="col-md-6 connectedSortable ui-sortable">
				
				<div class="box box-success with-border crowded-box">
					<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
						<i class="fa fa-calendar"></i> Calendar
						<div class="pull-right box-tools">
							<button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					
					<div class="box-body no-padding">
						<div id="calendar"></div>
					</div>
				</div>

				<?php echo isset($POST_CONTENTS) ? $POST_CONTENTS : ''; ?>

			</section>
            
            <?php
            if ( !restricted( 'user-web-services', false) ) {
            ?>
			
			<section class="col-md-6 connectedSortable ui-sortable">
				
				<?php echo isset($TASK_SUMMARY) ? $TASK_SUMMARY : ''; ?>
				
				<div class="col-xs-12">
					<div class="box box-warning with-border">
						<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
							<i class="fa fa-clock-o"></i> Timeline
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-warning btn-sm btn-timeline"><i class="fa fa-refresh"></i></button>
								<button type="button" class="btn btn-warning btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							<?php echo isset($TIMELINE_CONTAINER) ? $TIMELINE_CONTAINER : ''; ?>
						</div>
					</div>
				</div>
			</section>
            
            <?php
            }
            ?>
		</div>
		
	</section>
</div>