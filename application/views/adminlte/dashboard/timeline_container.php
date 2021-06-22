<h4><!--button class="btn-timeline btn btn-default"><i class="fa fa-refresh"></i> Refresh Timeline</button--></h4>
<ul id="timeline" class="timeine">
	<center><i class="fa fa-spin fa-refresh"></i> Loading data, please wait...</center>
</ul>

<script type="text/x-jsrender" id="timeline-template">
	{{for timeline}}
		<!-- timeline time label -->
		<li class="time-label">
			<span class="bg-purple">
				{{:day}}, {{:date}}
			</span>
		</li>
		<!-- /.timeline-label -->
	

		<!-- timeline item -->
		{{for items}}
		<li>
			<!-- timeline icon -->
			<i class="fa {{:task_icon}} {{:bg_task}}"></i>
			<div class="timeline-item">
				<span class="time"><i class="fa fa-clock-o"></i>
					<span data-content="timeline_date" data-format="ltime">{{:timeline_time}}</span>
				</span>

				<div class="timeline-header">
					<div class="user-block">
						<img class="img-circle" src="/{{if media_web_path}}{{:media_web_path}}{{else}}{{:'assets/static/img/avatar.jpeg'}}{{/if}}" alt="User Image">
						<span class="username"><a href="/profile/{{:user_id}}">{{:first_name}}</a></span>
						<span class="description">{{:workspace_name}} - {{:edition}}</span>
					</div>
				</div>

				<div class="timeline-body">
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
                            <em class="note">date:</em>
                            <p class="list-group-item-text">{{ldate:event_date}}</p>
                        </div>
                        <div class="col-xs-6">
                            <em class="note">deadline:</em>
                            <p class="list-group-item-text">{{ldate:due_date 'DD/MMM/YYYY'}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <em class="note">content: </em>
                            <p class="break-word">{{:content}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <em class="note">notes: </em>
                            <p class="break-word">{{:notes}}</p>
                        </div>
                    </div>

				
			
			<em class="note">event:</em>
			<p class="list-group-item-text break-word">{{:event_name}}</p>
			
			<em class="note">location:</em>
			<p class="list-group-item-text break-word">{{:event_place}}</p>

			<div class="row">
				<div class="col-xs-6">
					<em class="note">status:</em>
					<p class="list-group-item-text">{{:status}}</p>
				</div>
			</div>

				</div>

				<div class="timeline-footer">
					<!--a class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Add Comment</a-->
				</div>
			</div>
		</li>
		{{/for}}
		<!-- END timeline item -->
	{{/for}}
		<li>
			<i class="fa fa-clock-o bg-gray"></i>
		</li>
</script>