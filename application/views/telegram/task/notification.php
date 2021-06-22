<?php
$task_type   = $task['type'];
$event_date  = _ldate_($task['event_date'], '%d %B %Y %H:%M');
$due_date    = _ldate_($task['due_date'], '%d %B %Y');
$event_name  = strip_tags($task['event_name']);
$event_place = strip_tags($task['event_place']);
$notes       = strip_tags($task['notes']);

//<a href="tg://user?id=123456789">inline mention of a user</a>
//[inline mention of a user](tg://user?id=123456789)

$url_profile = base_url().'profile/'.$user->id;
$content = <<<EOL
<em>task for</em>: <a href="http:$url_profile">$user->first_name $user->last_name</a>

<em>type</em>: <strong>$task_type</strong>
<em>event date</em>: <strong>$event_date</strong>
<em>deadline</em>: <strong>$due_date</strong>
<em>event name</em>: <strong>$event_name</strong>

<em>location</em>: <strong>$event_place</strong>

<em>notes</em>: <strong>$notes</strong>
<em>workspace</em>: <strong>$workspace->name</strong>
<em>worksheet</em>: <strong>$worksheet->rubric</strong>
EOL;

echo $content;
