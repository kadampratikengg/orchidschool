<?php
class Log_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function write_log($title,$description="")
	{
		$array_data=$this->session->all_userdata();
		$array_string="";

		foreach($array_data as $key=>$value)
		{
		   if($key!='authenticated_student_ids')
			$array_string.="$key=$value | ";
		}
		$insert_data=array(
				"title"=>$title,
				"description"=>$description,
				"student_id"=>$this->session->userdata("student_id"),
				"user_id"=>$this->session->userdata("user_id"),
				"staff_id"=>$this->session->userdata("staff_id"),
				"mobile_no"=>$this->session->userdata("mobile"),
				"user_agent"=>$this->agent->agent_string(),
				//"server_load"=>function_exists("sys_getloadavg")?serialize(sys_getloadavg ( )):"",
				"current_url"=>current_url(),
				"session_data"=>$array_string,
				"session_id"=>$this->session->userdata('session_id'),
				"last_query"=>$this->db->last_query(),
				"entry_on"=>date("Y-m-d H:i:s"),
				"date_time"=>date("h:i A d M,Y")
		);
		
		$this->db->insert("logs",$insert_data);
	}    
   	
}
?>