<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Logger
{
	function Logger()
	{
		return;
	}
	
	var $_logger;
	
	function write_message($type = "debug", $message = "", $description = "")
	{
		$_logger =& get_instance();
		
		$data['ip_address'] = $_logger->input->ip_address();
		$data['user_agent'] = $_logger->input->user_agent();
		$data['action_taken'] = date("Y-m-d H:i:s");
		$data['log_type'] = 3;
		switch ($type)
		{
			case "error": $data['log_type'] = 1; 
			break;
			case "success": $data['log_type'] = 2; 
			break;
			case "message": $data['log_type'] = 3; 
			break;
			case "debug": $data['log_type'] = 4; 
			break;
			default: $data['log_type'] = 1; 
			break;
		}
		$data['user_id'] = $_logger->session->userdata('user_id');
		$data['uri_string'] = uri_string();
		$data['log_message'] = $message;
		$data['log_description'] = $description;
		$_logger->db->insert('logs', $data);
		return;
	}

	function recent_logs()
	{
		$_logger =& get_instance();
		$_logger->db->from('logs');
		$_logger->db->order_by('log_id', 'desc');
		$_logger->db->limit(10);
		$recent_logs = $_logger->db->get();
		
		if ($recent_logs->num_rows() > 0)
		{
			return $recent_logs;
		} 
		
		else {
			return false;
		}
	}
	
}

/* End of file Logger.php */
/* Location: ./cmv/libraries/Logger.php */