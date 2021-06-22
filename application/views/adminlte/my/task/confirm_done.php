
<?php
echo form_open('/my/my_task/set_done/');
?>
	<input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
	<div class="form-group">
		<label>Notes:</label>
		<textarea name="notes" label="Notes" placeholder="Notes" class="form-control" rows="3" /></textarea>
		<div class="help-block"><em class="note ">input notes (optional)</em></div>
	</div>
</form>
Update this task as DONE ?