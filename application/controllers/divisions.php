<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Divisions extends CI_Controller {
	
	var $academic_id;
	var $user_id;
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id=$this->session->userdata('user_id');
		$this->academic_id=$this->session->userdata('current_academic_year_id');
	}
	
	public function index() {
        
		$data['divisions_data'] = $this->db->query("select * from standards, divisions 
								where divisions.standard_id = standards.standard_id
								AND standards.academic_year_id = '".$this->academic_id."'")->result_array();
		
		$this->load->view ( 'divisions/default', $data);
	}
    public function add()
    {
    	$standards['standards'] = $this->db->get_where ( "standards", array("academic_year_id" => $this->academic_id ) )->result_array ();
        $this->load->view('divisions/add', $standards);
    }
    public function save()
    {
    	$this->form_validation->set_rules ( 'standard_id', 'Standard', 'required|callback_check_unique_division' );
    	$this->form_validation->set_rules ( 'division_name', 'Division', 'required',
    											array('is_unique' => "Division name is already used with other division of this standard"));
    	$this->form_validation->set_rules ( 'intake', 'Intake', 'required|numeric' );
    	
    	if ($this->form_validation->run () == FALSE) {
    		$this->add();
    	} else {
    		
    		/* save divisions */
    		$insert_data = array (
    				"standard_id" => $this->input->post ( "standard_id" ),
    				"academic_year_id" => $this->academic_id,
    				"division_name" => $this->input->post ( "division_name" ),
    				"intake" => $this->input->post ( "intake" ),
    				"entry_by" => $this->user_id
    				);
    		
    		$this->db->insert ( 'divisions', $insert_data );
    		
    		/* redirect*/
    		$this->session->set_flashdata ( 'success_message', "Record saved successfully");
    		redirect ( base_url ( 'divisions' ) );
    	}
    }
    function edit($division_id)
    {
    	$data['standards'] = $this->db->get_where ( 'standards' , array('academic_year_id' => $this->academic_id))->result_array ();
    	$query = $this->db->get_where('divisions',array('division_id' => $division_id));
    	$data['divisions_data'] = $query->row_array();
    	
    	$this->load->view('divisions/edit',$data);
    }
    function update($division_id)
    {
    	$this->form_validation->set_rules ( 'standard_id', 'Standard', 'required' );
    	$this->form_validation->set_rules ( 'division_name', 'Division', 'required' );
    	$this->form_validation->set_rules ( 'intake', 'Division Intake', 'required' );
    	
    	if ($this->form_validation->run () == FALSE) {
    		$this->edit($division_id);
    	} else {
    		
    		$update_data = array (
    				"standard_id" => $this->input->post ( "standard_id" ),
    				"division_name" => $this->input->post ( "division_name" ),
    				"intake" => $this->input->post ( "intake" ),
    				"entry_by" => $this->user_id
    				);
    		
    		$this->db->update('divisions', $update_data, array("division_id"=>$division_id));
    		
    		if($this->db->affected_rows()>0)
    			$this->session->set_flashdata('success_message', "Record updated successfully");
    		else
    			$this->session->set_flashdata('error_message', "Failed to update record");
    		
    		redirect ( base_url ( 'divisions' ) );
    	}
    }
    
    function delete($division_id)
    {
    	$division_applied_count = $this->db->query("SELECT count(*) AS count FROM students 
    													WHERE division_id = '".$division_id."'")->row_array();
    	
    	if($division_applied_count['count'] > 0){
    	
    		$this->session->set_flashdata ( 'error_message', "Failed to delete, Cannot delete this division as it is
												already been assigned to few(".$division_applied_count['count'].") students" );
    	}else{
    		
    		//$this->db->trans_start();
    			$this->db->delete('divisions', array('division_id' => $division_id));
    		//$this->db->trans_complete(); # Completing transaction
    		 
    		/*if ($this->db->trans_status() === FALSE) {
    			$this->db->trans_rollback();
    			$this->session->set_flashdata('error_message', "Failed to delete record");
    		}
    		else
    		{
    			$this->db->trans_commit();
    			$this->session->set_flashdata('success_message', "Record deleted successfully");
    		}*/
    			$this->session->set_flashdata('success_message', "Record deleted successfully");
    	}

    	redirect ( base_url ( 'divisions' ) );
    }
    
   /* callback functions */
    
    public function check_unique_division($standard_id)
    {
    	$division_data = $this->db->query("SELECT count(division_name) AS rows FROM divisions WHERE standard_id = '".$standard_id."'
    							AND division_name = '".$this->input->post('division_name')."'")->row_array();
    	
    	if ( $division_data['rows'] > 0 )
    	{
    		$this->form_validation->set_message('check_unique_division', 'The Division name is already been used in same standard');
    		return FALSE;
    	}
    	else
    	{
    		return TRUE;
    	}
    }
}