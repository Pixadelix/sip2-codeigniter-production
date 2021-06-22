
<?php
/* <form action="/my/task/set_cancel" method="post"> */
echo form_open('/my/my_task/set_cancel/');
?>
	<input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
	<div class="form-group">
		<label>Reason/Notes:</label>
		<textarea name="reason" label="Reason" placeholder="Reason" class="form-control" rows="5" required /></textarea>
		<div class="help-block"><em class="note ">input cancelation reason/notes (required)</em></div>
	</div>
</form>
Update this task as CANCEL ?