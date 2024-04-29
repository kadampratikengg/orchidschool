<?php
class Config extends CI_Controller {
	
	var $user_id;
	var $academic_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id=$this->session->userdata('user_id');
		$this->academic_id=$this->session->userdata('current_academic_year_id');		
	}
	
	public function index()
	{
	   $data["config_data"]=$this->db->get_where("config")->result_array();
	   $this->load->view('config/default', $data);
	}
	public function save()
	{
		$this->form_validation->set_rules("config[]","Configuration","required");
		if($this->form_validation->run()==false)
		{
			$this->index();
		}
		else
		{
		   extract($_POST);
		   $i=0;
		   for($i=0; $i<count($config);$i++)
		   {
			   $update_data=array("config_value"=> $config[$i],
			   					"modified_on"=>date("Y-m-d H:i:s"),
								"modified_by"=>$this->user_id);
			   
			   $this->db->update("config", $update_data, array("config_id"=>$config_id[$i]));
		   }
		  
		   $this->session->set_flashdata("admin_success","Data successfully updated.");
			redirect(base_url("config"));
		}
	}
}
?>