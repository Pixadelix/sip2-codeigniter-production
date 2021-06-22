<?php

if ( ! function_exists( 'str_date' ))
{
	function str_date($input, $format = 'd/m/Y', $use_time = false) {
		if ( $use_time ) $format .= ' H:i:s';
		
		if(intval($input)) return date($format, $input);
		
		return '';
	}
}

if ( ! function_exists('_ldate_'))
{
	function _ldate_($date, $format = '%d-%b-%y') {
		// long format %A, %d %B %Y
		if(!$date) return;
		//echo PHP_OS;
		switch (PHP_OS) {
			case 'Linux':
				setlocale (LC_TIME, 'id_ID');
				break;
			case 'WINNT':
				setlocale (LC_TIME, 'IND');
				break;
			default:
				break;
		}
		//echo $date;
		if( is_int($date) ) {
			return date($format, $date);
		} else {
			return strftime($format, date_create($date)->getTimestamp());
		}
	}
}

if ( ! function_exists('get_user_id'))
{
	function get_user_id() {
		$CI =& get_instance();
		return $CI->ion_auth->get_user_id();
	}
}

if ( ! function_exists('get_userfullname'))
{
	function get_userfullname() {
		$CI =& get_instance();
        return $CI->user_profile->first_name.' '.$CI->user_profile->last_name;
		//return $CI->session->userdata('user_full_name');
	}
}

if ( ! function_exists('get_membersince'))
{
	function get_membersince() {
		$CI =& get_instance();
        return $CI->user_profile->created_on;
		//return $CI->session->userdata('user_created_on');
	}
}

if ( ! function_exists('get_usercompany'))
{
	function get_usercompany() {
		$CI =& get_instance();
        return $CI->user_profile->company;
		//return $CI->session->userdata('user_company');
	}
}

if ( ! function_exists('get_userphoto'))
{
    function get_userphoto() {
        $CI =& get_instance();
        if ( ! $CI->user_profile_photo || ! $CI->user_profile_photo->media_web_path ) {
            return '/assets/static/img/avatar.jpeg';
            //return '/assets/static/adminlte/img/1424804255.jpg';
        }
        return '/'.$CI->user_profile_photo->media_web_path;
    }
}

if ( ! function_exists('trim_all') ) {
	function trim_all( $str , $what = NULL , $with = ' ' )
	{
		if( $what === NULL )
		{
			//  Character      Decimal      Use
			//  "\0"            0           Null Character
			//  "\t"            9           Tab
			//  "\n"           10           New line
			//  "\x0B"         11           Vertical Tab
			//  "\r"           13           New Line in Mac
			//  " "            32           Space
		   
			$what   = "\\x00-\\x20";    //all white-spaces and control chars
		}
	   
		return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
	}
}

if ( ! function_exists( 'get_resource_label' ) ) {
	function get_resource_label($parent_id, $resource) {
		if ( ! $parent_id ) return '';
		
		$index = array_search($parent_id, array_column($resource, 'id'));
		return $resource[$index]['label'];
	}
	
	function grl($var1, $var2) {
		return get_resource_label($var1, $var2);
	}
}

if ( ! function_exists( 'get_project_name' ) ) {
	function get_project_name($project_id, $projects) {
		if ( ! $project_id ) return '';
		
		$index = array_search($project_id, array_column($projects, 'id'));
		return $projects[$index]['name'];
	}
	
	function gpn($var1, $var2) {
		return get_project_name($var1, $var2);
	}
}

if ( ! function_exists( 'get_workspace_status' ) ) {
	function get_workspace_status($status) {
		switch($status) {
			case MAGZ_ARCHIVED:
				echo '<i class="fa fa-archive"></i>';
				break;
			case MAGZ_ACTIVE:
				echo '<i class="fa fa-star-o"></i>';
				break;
			case MAGZ_PUBLISHED:
				echo '<i class="fa fa-star-half-o"></i>';
				break;
			case MAGZ_FINISHED:
				echo '<i class="fa fa-star"></i>';
				break;
			default:
				break;
		}
	}
	
	function gws($var1) {
		return get_workspace_status($var1);
	}
}

if ( ! function_exists( 'get_workspace_progress' ) ) {
	function get_workspace_progress($id, $workspaces) {
		if ( ! $id ) return '';
		$index = array_search($id, array_column($workspaces, 'mag_id') );
		return $workspaces[$index]['progress_task'];
	}
}

if ( ! function_exists( 'get_form_submited_value' ) ) {
	function get_form_submited_value($input_name, $initial_value = null) {
		$ci =& get_instance();
		
		if ($ci->input->post()) {
			return $ci->input->post($input_name);
		} else if ($ci->input->get()) {
			return $ci->input->get($input_name);
		}
		return $initial_value;
	}
	
	function gfsv($var1, $var2 = null) {
		return get_form_submited_value($var1, $var2);
	}
}

if ( ! function_exists('hilite_str') )
{
	function hilite_str($body_text, $search_letter, $color = 'yellow') {
		$length= strlen($body_text);    //this is length of your body
		$pos = strpos($body_text, $search_letter);   // this will find the first occurance of your search text and give the position so that you can split text and highlight it
		$lword = strlen($search_letter);    // this is the length of your search string so that you can add it to $pos and start with rest of your string
		$split_search = $pos+$lword; 
		$string0 = substr($body_text, 0, $pos); 
		$string1 = substr($body_text,$pos,$lword);
		$string2 = substr($body_text,$split_search,$length);
		$body = $string0."<span style='background-color:$color;'>".$string1."</span>".$string2;
		return $body;
	}
	
	function hs($var1, $var2, $var3 = 'yellow') {
		return hilite_str($var1, $var2, $var3);
	}
}

if ( ! function_exists('enqueued_styles' ) )
{
	function enqueued_styles() {
		$ci =& get_instance();
		return $ci->enqueued_styles();
	}
}

if ( ! function_exists('enqueued_scripts' ) )
{
	function enqueued_scripts() {
		$ci =& get_instance();
		return $ci->enqueued_scripts();
	}
}

if ( ! function_exists('enqueued_resources' ) )
{
    function enqueued_resources() {
        $ci =& get_instance();
        return $ci->enqueued_resources();
    }
}

if ( ! function_exists('get_status_style') )
{
	function get_status_style($task) {
		$style = array(
			'panel' => 'panel-primary',
			'label' => 'label-primary',
			'icon'  => 'fa-arrow-circle-down'
		);
		switch( $task->status ) {
			case TASK_STATUS_CANCEL:
				$style['panel'] = 'panel-danger';
				$style['label'] = 'label-danger';
				$style['icon']  = 'fa-times-circle';
				break;
			case TASK_STATUS_DONE:
				$style['panel'] = 'panel-success';
				$style['label'] = 'label-success';
				$style['icon']  = 'fa-check-circle';
				break;
			case TASK_STATUS_POSTPONE:
				$style['panel'] = 'panel-purple';
				$style['label'] = 'label-purple';
				$style['icon']  = 'fa-arrow-circle-left';
				break;
			case TASK_STATUS_ONGOING:
				$style['panel'] = 'panel-warning';
				$style['label'] = 'label-warning';
				$style['icon']  = 'fa-arrow-circle-right';
				break;
			case TASK_STATUS_STANDBY:
			default:
				break;
		}
		return $style;
	}
}

if ( ! function_exists('_money_') )
{
	function _money_($value, $format = '%.0n', $locale = 'id_ID') {
		setlocale(LC_MONETARY, $locale);
		return money_format($format, $value);
	}
}