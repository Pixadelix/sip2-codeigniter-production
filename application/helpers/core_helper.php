<?php



if ( ! function_exists( 'set_message' ) )
{
	function set_message($type, $message) {
		$CI =& get_instance();
		$CI->session->set_flashdata($type, $message);
	}
}

if ( ! function_exists( 'set_message_error' ) )
{
	function set_message_error($message) {
		set_message(TYPE_MESSAGE_ERROR, $message);
	}
}

if ( ! function_exists( 'set_message_success' ) )
{
	function set_message_success($message) {
		set_message(TYPE_MESSAGE_SUCCESS, $message);
	}
}

if ( ! function_exists( 'set_message_warning' ) )
{
	function set_message_warning($message) {
		set_message(TYPE_MESSAGE_WARNING, $message);
	}
}

if ( ! function_exists( 'get_info_message' ) )
{
	function get_info_message() {
		$CI =& get_instance();
		if($msg = validation_errors()) {
			return array($msg, 'modal-danger red', 'Validation Error');
		}
		if($msg = $CI->ion_auth->errors()) {
			return array($msg, 'modal-danger red', 'Auth Error');
		}
		if($msg = $CI->session->flashdata(TYPE_MESSAGE_ERROR)) {
			return array($msg, 'modal-danger red', 'Error');
		}
		if($msg = $CI->session->flashdata(TYPE_MESSAGE_WARNING)) {
			return array($msg, 'modal-warning black', 'Warning');
		}
		if($msg = $CI->session->flashdata(TYPE_MESSAGE_SUCCESS)) {
			return array($msg, 'modal-success green', 'Success');
		}
		
		
		return array($CI->session->flashdata('message'), 'modal-primary blue', 'Info');
		//return (validation_errors() ? validation_errors() : ($CI->ion_auth->errors() ? $CI->ion_auth->errors() : $CI->session->flashdata('message')));
	}
}

/*
if ( ! function_exists( 'in_group' ) )
{
	function in_group($groups) {
		$CI =& get_instance();
		if(!$CI->in_group($groups)) {
			return false;
		}
		return true;
	}
}
*/



if ( ! function_exists('get_resource'))
{
	function get_resource() {
		$CI =& get_instance();
		return $CI->get_resource();
	}
}

if ( ! function_exists('get_menu_resource'))
{
	function get_menu_resource() {
		$CI =& get_instance();
		return $CI->get_menu_resource();
	}
}

if ( ! function_exists('can_access_resource'))
{
	function can_access_resource($resource_code) {
		$CI =& get_instance();
		$acl = $CI->user_resources($resource_code);
		//var_dump($acl); die;
		return $acl;
	}
	
	function acl($var1) {
		return can_access_resource($var1);
	}
}

if ( ! function_exists('get_task_icon'))
{
	function get_task_icon($type)
	{
		$icons = $GLOBALS['TASK_TYPE_ICONS'];
		return $icons[$type];
	}
}

if ( ! function_exists('is_serial') )
{
	function is_serial($string) {
		return (@unserialize($string) !== false);
	}
}

if ( ! function_exists('check_serial') )
{
	function check_serial($badData) {
		$data = preg_replace_callback(
			'/(?<=^|\{|;)s:(\d+):\"(.*?)\";(?=[asbdiO]\:\d|N;|\}|$)/s',
				static function($m){
					return 's:' . mb_strlen($m[2]) . ':"' . $m[2] . '";';
				},
			$badData
		);
		return $data;
	}
	
}

if ( ! function_exists('romanic_number') )
{
	function romanic_number($integer, $upcase = true) 
	{
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
		$return = '';
		while($integer > 0)
		{
			foreach($table as $rom=>$arb)
			{
				if($integer >= $arb)
				{
					$integer -= $arb;
					$return .= $rom;
					break;
				}
			}
		}
		return $return;
	}
}

if (!is_callable('getallheaders')) {
	# Convert a string to mixed-case on word boundaries
	function uc_all($string) {
		$temp = preg_split('/(\W)/', str_replace("_", "-", $string), -1, PREG_SPLIT_DELIM_CAPTURE);
		foreach ($temp as $key=>$word) {
			$temp[$key] = ucfirst(strtolower($word));
		}
		return join ('', $temp);
	}

	function getallheaders() {
		$headers = array();
		foreach ($_SERVER as $h => $v)
			if (preg_match('/HTTP_(.+)/', $h, $hp))
				$headers[str_replace("_", "-", uc_all($hp[1]))] = $v;
		return $headers;
	}

	function apache_request_headers() { return getallheaders(); }
}

if ( ! function_exists('restricted') ) {
    function restricted($resource, $blocking = true)
    {
        $CI =& get_instance();
        return $CI->restricted($resource, $blocking);
    }
}