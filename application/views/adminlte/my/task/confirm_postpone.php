<?php

echo form_open('/my/my_task/set_postpone/');

?>
	<input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
	<div class="form-group">
		<label>Postpone until:</label>

		<div class="form-group">
			<div class='input-group date datetimepicker'>
			<?php
			$event_date = _ldate_($task->event_date, '%d/%m/%Y %H:%M');
			?>
				<input name="event_date" readonly type="text" class="form-control" value="<?php echo $event_date; ?>">
				<span class="input-group-addon">
					<span class="fa fa-calendar"></span>
				</span>
			</div>
			<div class="help-block"><em class="note ">date of event</em></div>
		</div>
	</div>
	
	<div class="form-group">
		<label>Reason:</label>
		<textarea name="reason" placeholder="Reason" class="form-control" rows="3" required><?php echo $task->notes; ?></textarea>
		<div class="help-block"><em class="note ">input notes/reason (required)</em></div>
	</div>
	
	<div class="form-group">
		<label>Event:</label>
		<input name="event_name" type="text" class="form-control" value="<?php echo $task->event_name; ?>">
		<div class="help-block"><em class="note ">name of event</em></div>
	</div>
	
	
	
	<div class="form-group">
		<label>Location:</label>
		<div class="form-group">
			<div class='input-group'>
				<input id="event-place" name="event_place" type="text" class="form-control" value="<?php echo $task->event_place;?>">
				<span id="btn-locationpicker" class="input-group-addon"  style="cursor: pointer;">
					<span class="fa fa-map-marker"></span>
				</span>
			</div>
			<div class="help-block"><em class="note ">location of event</em></div>
			<div id="event-place-locationpicker" style="display: none;"></div>
		</div>

	</div>

</form>
Update this task as POSTPONE ?