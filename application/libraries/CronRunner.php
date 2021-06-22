<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CronRunner {
	private $CI;
	
	public function __construct() {
    	$this->CI =& get_instance();
	}

	private function calculateNextRun($obj) {
		return (time() + $obj->interval_sec);
	}

	public function run() {
		$query = $this->CI->db->where('is_active', 1)->where('now() >= next_run_at OR next_run_at IS NULL', '', false)->from('cron')->get();
		
		if ($query->num_rows() > 0) {
			
			foreach ($query->result() as $row) {
				$cmd = "{$row->command}";
				$this->CI->db->set('next_run_at', 'FROM_UNIXTIME('.$this->calculateNextRun($row).')', false)->where('id', $row->id)->update('cron');
//				echo "shell_exec: $cmd\n";
				$output = shell_exec($cmd);
//				echo $output;
				$this->CI->db->set('last_run_at', 'now()', false)->where('id', $row->id)->update('cron');
			}
		}
	}
}
