<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Academic_years extends CI_Controller 
{
	
	var $user_id;
	var $academic_id;
	
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id = $this->session->userdata ( 'user_id' );
		$this->academic_id = $this->session->userdata ( 'current_academic_year_id' );
	}
	
	public function index() 
    {
		$query= $this->db->query ( 'SELECT * FROM academic_years');
        $data ['academic_data']=$query->result_array ();
		$this->load->view ( 'academic_years/default', $data );
	}
	
	public function add() 
    {
		$academic_years = $this->db->query ( "SELECT academic_year_id, from_year, to_year 
														FROM academic_years WHERE current_academic_year = 'YES'" )->row_array ();
		for($i=1;$i<=5; $i++){
			$data['from_year'][] = $academic_years['from_year'] + $i;
		}
		
		$data["month"]=array('1'=>'Jan','2'=>'Feb','3'=>'Mar','4'=>'Apr','5'=>'May','6'=>'Jun','7'=>'Jul','8'=>'Aug','9'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');

		$this->load->view ('academic_years/add',$data);
	}
	
	// save records
	public function save() 
    {
		$this->form_validation->set_rules ( 'from_month', 'From Month', 'required|callback_from_month[$data]' );
		$this->form_validation->set_rules ( 'from_year', 'From Year', 'required|callback_from_year[$data]' );
		$this->form_validation->set_rules ( 'to_month', 'To Month', 'required|callback_to_month[$data]' );
		$this->form_validation->set_rules ( 'to_year', 'To Year', 'required|callback_to_year[$data]' );
		$this->form_validation->set_rules ( 'current_academic_year', 'Current Year', 'required' );
				
		if ($this->form_validation->run () == FALSE) 
        {
			$this->add ();
		} 
        else 
        {
			$insert_data["from_month"] =$this->input->post ( "from_month" );
			$insert_data["from_year"] = $this->input->post ( "from_year" );
			$insert_data["to_month"] = $this->input->post ( "to_month" );
			$insert_data["to_year"] = $this->input->post ( "to_year" );
			$insert_data["current_academic_year"] = $this->input->post ( "current_academic_year" );
			$insert_data["entry_by"] = $this->user_id;
					
			if($insert_data["current_academic_year"]=='Yes')
			{
				$this->db->set('current_academic_year', 'No');
				$this->db->update('academic_years');
			}
			
			$this->db->insert ( 'academic_years', $insert_data );
			$message = "Record saved successfully";
			$this->session->set_flashdata ( 'success_message', $message );
			
			redirect ( base_url ( 'academic_years' ) );
		}
	}
	
	public function edit($academic_year_id) {
		
		$data["academic_year_data"] = $this->db->query("SELECT academic_years.* FROM academic_years
														WHERE academic_year_id = '".$academic_year_id."'")->row_array();
		
		
		$academic_years = $this->db->query ( "SELECT from_year FROM academic_years 
														WHERE academic_year_id = '".$academic_year_id."'" )->row_array ();
		
		for($i=0;$i<5; $i++){
			$data['from_year'][] = $academic_years['from_year'] + $i;
		}
		
        $data["month"]=array('1'=>'Jan','2'=>'Feb','3'=>'Mar','4'=>'Apr','5'=>'May','6'=>'Jun','7'=>'Jul','8'=>'Aug','9'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
		
		$this->load->view ( 'academic_years/edit', $data );
	}
	
public function update($academic_year_id) 
    {
		$this->form_validation->set_rules ( 'from_month', 'From Month', 'required' );
		$this->form_validation->set_rules ( 'from_year', 'From Year', 'required' );
        $this->form_validation->set_rules ( 'to_month', 'To Month', 'required' );
        $this->form_validation->set_rules ( 'to_year', 'To Year', 'required' );
		$this->form_validation->set_rules ( 'current_year', 'Current Year', 'required' );
		
		
		if ($this->form_validation->run () == FALSE) 
		{
			
			$this->edit ( $academic_year_id );
		} 
		else  {
			$update_data["from_month"] =$this->input->post ( "from_month" );
			$update_data["from_year"] = $this->input->post ( "from_year" );
			$update_data["to_month"] = $this->input->post ( "to_month" );
			$update_data["to_year"] = $this->input->post ( "to_year" );
			$update_data["current_academic_year"] = $this->input->post( "current_year" );
			$update_data["entry_by"] = $this->user_id; 
		
			$this->db->update ( 'academic_years', array('current_academic_year' => 'NO'), array (
					'current_academic_year' => 'YES' ) );
			
			$this->db->update ( 'academic_years', $update_data, array (
					'academic_year_id' => $academic_year_id ) );
			
			if ($this->db->affected_rows () > 0) {
				$message = "Record updated successfully";
				$this->session->set_flashdata ( 'success_message', $message );
			} else {
				
				$message = "Failed to update your record";
				$this->session->set_flashdata ( 'error_message', $message );
			}
			redirect ( base_url ( 'academic_years' ) );
		}
	}
	
	public function delete($academic_year_id) 
	{
		$academic_year_applied_count = $this->db->query("SELECT count(*) AS count FROM student_academic_years 
													WHERE academic_year_id = '".$academic_year_id."'")->row_array();

		if($academic_year_applied_count['count'] > 0){
		
			$this->session->set_flashdata ( 'error_message', "Failed to delete, Cannot delete this academic year as it is
												already been assigned to few(".$academic_year_applied_count['count'].") students" );
		}else{
			
			$this->db->delete('academic_years',array('academic_year_id' =>$academic_year_id));
			
			$message = "Record deleted successfully";
			$this->session->set_flashdata ( 'success_message', $message );
		}
		redirect ( base_url ( 'academic_years' ) );
	}
	
	
	function from_month($data)
	{
		if ($data == "0" or $data=0)
		{
			$this->form_validation->set_message('from_month', 'Select from month');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		 
	}
	function from_year($data)
	{
		if ($data == 0){
			$this->form_validation->set_message('from_year', 'Select from year ');
			return FALSE;
		
		}else{
			return TRUE;
		}
			
	}
	function to_month($data)
	{
		if ($data == "0" or $data =0)
		{
			$this->form_validation->set_message('to_month', 'Select to month');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function to_year($data)
	{
		if ($data == 0)
		{
			$this->form_validation->set_message('to_year', 'Select to year');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/**
	 * * Ajax Functions ****
	 */
	
	
	public function get_toyear()
	{
		$year = $this->input->get ('year');
		echo '<option value="">Select</option>';
	
		for($i=$year+1;$i<$year+5;$i++)
		{
			echo '<option value="' . $i . '">' . $i. '</option>';
		}
	
		$query=$this->db->query( "SELECT * FROM academic_years where from_year='{$year}'");
		$arr=$query->result_array ();
	}
}