<?php
$ci =& get_instance();

$standby  = $ci->db->where( ['status' => 'standby'] )->from("sip_tasks")->count_all_results();
$done     = $ci->db->where( ['status' => 'done'] )->from("sip_tasks")->count_all_results();
$postpone = $ci->db->where( ['status' => 'postpone'] )->from("sip_tasks")->count_all_results();
$cancel   = $ci->db->where( ['status' => 'cancel'] )->from("sip_tasks")->count_all_results();

?>
				<div class="col-lg-6 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
							<h3><?php echo $standby; ?></h3>
							<p>Standby</p>
						</div>
						<div class="icon"> <i class="fa fa-arrow-right"></i> </div> <!--a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a--> </div>
				</div>
				<!-- ./col -->
				<div class="col-lg-6 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
							<h3><?php echo $done; ?></h3>
							<p>Done</p>
						</div>
						<div class="icon"> <i class="fa fa-check"></i> </div> <!--a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a--> </div>
				</div>
				<!-- ./col -->
				<div class="col-lg-6 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-purple">
						<div class="inner">
							<h3><?php echo $postpone; ?></h3>
							<p>Postpone</p>
						</div>
						<div class="icon"> <i class="fa fa-hourglass-start"></i> </div> <!--a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a--> </div>
				</div>
				<!-- ./col -->
				<div class="col-lg-6 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-red">
						<div class="inner">
							<h3><?php echo $cancel; ?></h3>
							<p>Cancel</p>
						</div>
						<div class="icon"> <i class="fa fa-times"></i> </div> <!--a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a--> </div>
				</div>
				<!-- ./col -->