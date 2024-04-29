<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Staff extends CI_Controller {
	
	
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id = $this->session->userdata('user_id');
		$this->academic_id=$this->session->userdata('current_academic_year_id');
	}
	
	public function index() {
        
		$query = $this->db->get('staff');
		$data['staff_data'] = $query->result_array();
		$this->load->view ( 'staff/default', $data);
	}
    public function add()
    {
        $this->load->view('staff/add');
    }
    public function save()
    {
    	$this->form_validation->set_rules ( 'first_name', 'First Name', 'required|alpha' );
    	$this->form_validation->set_rules ( 'last_name', 'Last Name', 'required|alpha' );
    	$this->form_validation->set_rules ( 'mobile_no', 'Mobile Number', 'numeric' );
    	$this->form_validation->set_rules ( 'email_id', 'Email ID', 'required|valid_email|is_unique[users.email_id]' );
    	$this->form_validation->set_rules ( 'gender', 'Gender', 'required' );
    	$this->form_validation->set_rules ( 'password', 'Password', 'required|min_length[6]' );
    	
    	if ($this->form_validation->run () == FALSE) {
    		$this->add();
    	} else {
    		
    		/* save staff */
    		$insert_data = array (
    				"first_name" => $this->input->post ( "first_name" ),
    				"last_name" => $this->input->post ( "last_name" ),
    				"email_id" => $this->input->post ( "email_id" ),
    				"mobile_no" => $this->input->post ( "mobile_no" ),
    				"gender" => $this->input->post ( "gender" ),
    				"entry_by" => $this->user_id
    				);
    		
    		$this->db->insert ( 'staff', $insert_data );
			$last_inserted_staff_id = $this->db->insert_id();
			
			
			/* save staff to users table */
    		 $insert_data = array(
    				"staff_id" => $last_inserted_staff_id,
    				"email_id" => $this->input->post ( "email_id" ),
    				"password" => MD5($this->input->post ( "password" )),
    				"account_type" => "STAFF",
    				"entry_by" => $this->user_id
    		); 
    		$this->db->insert ( 'users', $insert_data );
    		
    		/* send email to staff */
    		$mail_data ["first_name"] = $this->input->post('first_name');
    		$mail_data ["email_id"] = $this->input->post('email_id');
    		$mail_data ["password"] = $this->input->post('password');
    		
    		$to = $this->input->post('email_id');
    		$message = $this->load->view ( "_mail_templates/staff_credentials", $mail_data, TRUE);
    		
    		$subject = get_config_value("website_name")." Login Credentials";
    		my_send_email ( $to, $subject, $message );
    		
    		/* redirect*/
    		$this->session->set_flashdata ( 'success_message', "Record saved successfully");
    		redirect ( base_url ( 'staff' ) );
    	}
    }
    
    public function edit($staff_id)
    {
    	$query = $this->db->get_where('staff',array('staff_id' => $staff_id));
    	$data['staff_data'] = $query->row_array();
    	$this->load->view('staff/edit',$data);
    }
    
    public function update($staff_id)
    {
    	$this->form_validation->set_rules ( 'first_name', 'First Name', 'required|alpha' );
    	$this->form_validation->set_rules ( 'last_name', 'Last Name', 'required|alpha' );
    	$this->form_validation->set_rules ( 'mobile_no', 'Mobile Number', 'numeric' );
    	$this->form_validation->set_rules ( 'email_id', 'Email ID', 'required|valid_email|is_unique[users.email_id.staff_id.'.$staff_id.']' );
    	$this->form_validation->set_rules ( 'gender', 'Gender', 'required' );
    	
    	if ($this->form_validation->run () == FALSE) {
    		$this->edit($staff_id);
    	} else {
    		
    		$update_data["first_name"] = $this->input->post("first_name");
    		$update_data["last_name"] = $this->input->post("last_name");
    		$update_data["email_id"] = $this->input->post("email_id");
    		$update_data["mobile_no"] = $this->input->post("mobile_no");
    		$update_data["gender"] = $this->input->post("gender");
    		
    		//$this->db->trans_start();
	    		$this->db->update('staff', $update_data, array("staff_id"=>$staff_id));
	    		$this->db->update('users', array("email_id"=>$this->input->post("email_id")) , array("staff_id"=>$staff_id));
	    		
    		//$this->db->trans_complete();
    		
    		/*if ($this->db->trans_status () === FALSE) {
    			
    			$this->db->trans_rollback ();
    			$this->session->set_flashdata ( 'error_message', "Failed to updated record" );
    		} else {
    			
    			$this->db->trans_commit ();
    			$this->session->set_flashdata ( 'success_message', "Record updated successfully" );
    		}*/
	    		$this->session->set_flashdata ( 'success_message', "Record updated successfully" );
    		redirect ( base_url ( 'staff' ) );
    	}
    }
    
    function delete($staff_id)
    {
    	$data = $this->db->query("SELECT user_id FROM users WHERE staff_id = '".$staff_id."'")->row_array();
    	
    	if($data['user_id'] == $this->user_id){
    		
    		$this->session->set_flashdata('error_message', "Logged in user cannot be deleted");
    	}else{

    		//$this->db->trans_start();
    		 
    		$this->db->delete('users', array('staff_id' => $staff_id));
    		$this->db->delete('staff', array('staff_id' => $staff_id));
    		 
    		/*$this->db->trans_complete(); # Completing transaction
    		 
    		if ($this->db->trans_status() === FALSE) {
    			$this->db->trans_rollback();
    			$this->session->set_flashdata('error_message', "Failed to delete record");
    		}
    		else
    		{
    			$this->db->trans_commit();
    			$this->session->set_flashdata('success_message', "Record deleted successfully");
    		}*/
    	}
    	
    	$this->session->set_flashdata('success_message', "Record deleted successfully");
    	redirect ( base_url ( 'staff' ) );
		
    }
    function view($staff_id)
    {
    	$this->db->select ('*');
    	$data ['staff_data'] = $this->db->get_where ( 'staff', 
    			array ('staff_id' => $staff_id))->row_array ();
    	
    	$result ['title'] = "Staff Information";
    	
    	$result ['body'] = $this->load->view ( 'staff/view', $data, true );
    	echo json_encode ( $result );
    }
    
    function change_status($staff_id,$status)
    {
    	if ($status == "Active") {
			$this->db->update ( 'staff', array ('status' => 'ACTIVE'), array ('staff_id' => $staff_id));
			$this->db->update ( 'users', array ('status' => 'ACTIVE'), array ('staff_id' => $staff_id));
			
		} else {
			$this->db->update ( 'staff', array ('status' => 'INACTIVE'), array ('staff_id' => $staff_id));
			$this->db->update ( 'users', array ('status' => 'INACTIVE'), array ('staff_id' => $staff_id));
		}
		
		$message = "Record updated successfully";
		$this->session->set_flashdata ( 'success_message', $message );
		redirect ( base_url ( 'staff' ) );
    }
   
}