<li class="dropdown tasks-menu">
	<a id="refresh-notif-task" href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-flag-o"></i>
		<span id="task-total" class="label label-danger"><?php echo $notif_task_total; ?></span>
	</a>

	<ul class="dropdown-menu">
		<li class="header">You have <?php echo $notif_task_total; ?> tasks <i class="fa fa-times pull-right" style="cursor: pointer;" data-toggle="dropdown"></i></li>
		<li>
			<ul id="task-list" class="menu">
				
				<i class="fa fa-spin fa-refresh"></i> Loading data, please wait...
				
			</ul>
		</li>
		
		<li class="footer">
			<a>
				<span> data loaded on: <span id="task-last-update"></span>
					<button id="btn-refresh-notif-task" type="button" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Loading..." class="btn btn-xs btn-default pull-right">
						<i class="fa fa-refresh"></i>
					</button>
				</span>
			</a>
		</li>
	</ul>
</li>

<script type="text/x-jsrender" id="task-list-template">
	<li>
		<a href="{{:url}}">
		
			<div class="row">
				<div class="col-xs-6">
					<em class="note">#:
						<span data-content="task_id">{{:task_id}}</span>
					</em>
				</div>
				<div class="col-xs-6">
					<em class="note">PIC:
						<span>{{:first_name}}</span>
						<span>{{:last_name}}</span>
					</em>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-6">
					<em class="note">workspace: </em>
					<p>{{:workspace_name}}</p>
				</div>
				<div class="col-xs-6">
					<em class="note">edition: </em>
					<div>{{:edition}}</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-6">
					<em class="note">worksheet: </em>
					<p>{{:rubric}}</p>
				</div>
				<div class="col-xs-6">
					
					<em class="note">task: </em>
					<p>{{:type}}</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-6">
					<em class="note">content: </em>
					<p class="break-word">{{:content}}</p>
				</div>
				<div class="col-xs-6">
					<em class="note">notes: </em>
					<p class="break-word">{{:notes}}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-6">
					<em class="note">date:</em>
					<p class="list-group-item-text">{{ldate:event_date}}</p>
				</div>
				<div class="col-xs-6">
					<em class="note">deadline:</em>
					<p class="list-group-item-text">{{ldate:due_date}}</p>
				</div>
			</div>			

				
			
			<em class="note">event:</em>
			<p class="list-group-item-text break-word">{{:event_name}}</p>
			
			<em class="note">location:</em>
			<p class="list-group-item-text break-word">{{:event_place}}</p>
			
			
			<div class="progress progress-xs progress-striped">
				<div class="progress-bar progress-bar-red" style="width: 5%" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
			
			<div class="row">
				<div class="col-xs-6">
					<em class="note">status:</em>
					<p class="list-group-item-text">{{:status}}</p>
				</div>
				<div class="col-xs-6">
					<em class="note">progress:</em>
					<p class="list-group-item-text">5% (coming soon)</p>
				</div>
			</div>
			
		</a>
	
	</li>
</script>






<?php


/*
<li class="dropdown tasks-menu">
	
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-flag-o"></i>
		<span id="task-total" class="label label-danger"></span>
	</a>

	<ul class="dropdown-menu">
		<li class="header">You have 9 tasks</li>
		<li>
			<ul class="menu">
	<li>
		<span>
			<div class="bar-holder no-padding">
				<p class="margin-bottom-5"><i class="fa fa-warning text-warning"></i> <strong>PRIMARY:</strong> <i>Upgrade Infestructure</i> <span class="pull-right semi-bold text-muted">85%</span></p>
				<div class="progress progress-md progress-striped">
					<div class="progress-bar bg-color-teal"  style="width: 85%;"></div>
				</div>
				<em class="note no-margin">last updated on 12/12/2013</em>
			</div>
		</span>
	</li>
	<li>
		<span>
			<div class="bar-holder no-padding">
				<p class="margin-bottom-5"><strong>URGENT:</strong> <i> Code foundation</i> <span class="pull-right semi-bold text-muted">65%</span></p>
				<div class="progress progress-sm">
					<div class="progress-bar bg-color-teal" style="width: 65%;"></div>
				</div>
				<em class="note no-margin">last updated on 12/12/2013</em>
			</div>
		</span>
	</li>
	<li>
		<span>
			<div class="bar-holder no-padding">
				<p class="margin-bottom-5"><strong>URGENT:</strong> <i>Project Plan</i> <span class="pull-right semi-bold text-muted">25%</span></p>
				<div class="progress progress-xs">
					<div class="progress-bar bg-color-teal" style="width: 25%;"></div>
				</div>
				<em class="note no-margin">last updated on 12/12/2013</em>
			</div>
		</span>
	</li>
	<li>
		<span>
			<div class="bar-holder no-padding">
				<p class="margin-bottom-5"><strong>CRITICAL:</strong> <i> Wireframes</i> <span class="pull-right semi-bold text-danger">5%</span></p>
				<div class="progress progress-xs">
					<div class="progress-bar progress-bar-danger" style="width: 5%;"></div>
				</div>
				<em class="note no-margin">last updated on 12/12/2013</em>
			</div>
		</span>
	</li>
	<li>
		<span>
			<div class="bar-holder no-padding">
				<p class="margin-bottom-5"><strong>NORMAL:</strong> <i>Compile hotfix</i> <span class="pull-right semi-bold text-muted">99%</span></p>
				<div class="progress progress-xs">
					<div class="progress-bar progress-bar-success" style="width: 99%;"></div>
				</div>
				<em class="note no-margin">last updated on 12/12/2013</em>
			</div>
		</span>
	</li>
	<li>
		<span>
			<div class="bar-holder no-padding">
				<p class="margin-bottom-5"><strong>MINOR:</strong> <i>Bug fix #213</i><span class="pull-right semi-bold text-muted"><i class="fa fa-check text-success"></i> Complete</span></p>
				<div class="progress progress-micro">
					<div class="progress-bar progress-bar-success" style="width: 100%;"></div>
				</div>
				<em class="note no-margin">last updated on 12/12/2013</em>
			</div>
		</span>
	</li>
	<li>
		<span>
			<div class="bar-holder no-padding">
				<p class="margin-bottom-5"><strong>MINOR:</strong> <i>Bug fix #134</i><span class="pull-right semi-bold text-muted"><i class="fa fa-check text-success"></i> Complete</span></p>
				<div class="progress progress-micro">
					<div class="progress-bar progress-bar-success" style="width: 100%;"></div>
				</div>
				<em class="note no-margin display-inline"><a href="javascript:void(0);">see notes</a></em>
			</div>
		</span>
	</li>
</ul>
</li>
	</ul>
</li>

*/

?>