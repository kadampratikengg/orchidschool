<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Student_profile extends CI_Controller {
	
	var $user_id;
	var $academic_id;
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STUDENT" );
		
		$this->user_id = $this->session->userdata('user_id');
		$this->student_id = $this->session->userdata('student_id');
		$this->academic_id = $this->session->userdata('current_academic_year_id');
	}
	
	public function index() {
		
		$data['student_data'] = $this->db->query("SELECT students.*, from_year, to_year FROM students, academic_years 
													WHERE student_id = '".$this->student_id."' AND academic_years.academic_year_id IN (SELECT academic_year_id FROM students 
													WHERE student_id = '".$this->student_id."')")->row_array();
		
		$data ['division'] = $this->db->query ("SELECT standard_name, division_name from standards, divisions
													WHERE (standards.standard_id, division_id) IN (SELECT standard_id, division_id FROM divisions
														WHERE division_id ='".$data['student_data']['division_id']."')
													AND standards.academic_year_id = '".$this->academic_id."'")->row_array();
		
		$this->load->view ( 'student_profile/default', $data );
		//writ log
		$this->log_model->write_log("My Profile Visited");
	}
	
	public function edit() {
		
		$this->db->select ( '*' );
		$data ['student_data'] = $this->db->get_where ( 'students', array ('student_id' => $this->student_id))->row_array ();
		$data ['current_standard'] = $this->db->query ( 'SELECT standard_id FROM divisions WHERE division_id = ' . $data ['student_data'] ['division_id'] )->row_array ();
		$data ["academic_years"] = $this->db->query ( 'SELECT academic_year_id, from_year, to_year FROM academic_years' )->result_array ();
		
		$this->load->view ( 'student_profile/edit', $data );
	}
	
	public function update() {
		$this->form_validation->set_rules ( 'student_firstname', 'Student First Name', 'required|alpha' );
		$this->form_validation->set_rules ( 'student_lastname', 'Student Last Name', 'required|alpha' );
		$this->form_validation->set_rules ( 'date_of_birth', 'Date of Birth', 'required' );
		$this->form_validation->set_rules ( 'gender', 'Gender', 'required' );
		$this->form_validation->set_rules ( 'blood_group', 'Blood Group', 'required' );
		$this->form_validation->set_rules ( 'parent_name', 'Parent Name', 'required|alpha_numeric_spaces' );
		$this->form_validation->set_rules ( 'parent_email_id', 'Parent Email ID', 'required|valid_email' );
		$this->form_validation->set_rules ( 'parent_contact_no', 'Parent Contact Number', 'required|numeric|exact_length[10]' );
		$this->form_validation->set_rules ( 'address', 'Address Line', 'required' );
		$this->form_validation->set_rules ( 'city', 'City', 'required|alpha' );
		$this->form_validation->set_rules ( 'state', 'State', 'required|alpha' );
		$this->form_validation->set_rules ( 'pincode', 'Pincode', 'required|numeric|exact_length[6]' );
		
		if ($this->form_validation->run () == FALSE) {
			
			$this->edit ();
		} else {
			
			$update_data = array ( "email_id" => $this->input->post ( "parent_email_id" ));
			
			$this->db->update ( 'users', $update_data, array('student_id' => $this->student_id));
			
			$update_data = array (
					"student_firstname" => $this->input->post ( "student_firstname" ),
					"student_lastname" => $this->input->post ( "student_lastname" ),
					"gender" => $this->input->post ( "gender" ),
					"date_of_birth" => swap_date_format($this->input->post( "date_of_birth" ) ),
					"blood_group" => $this->input->post ( "blood_group" ),
					"address" => $this->input->post ( "address" ),
					"city" => $this->input->post ( "city" ),
					"state" => $this->input->post ( "state" ),
					"pincode" => $this->input->post ( "pincode" ),
					"parent_name" => $this->input->post ( "parent_name" ),
					"parent_email_id" => $this->input->post ( "parent_email_id" ),
					"parent_mobile_no" => $this->input->post ( "parent_contact_no" ) 
			);
			
			$this->db->update ( 'students', $update_data, array('student_id' => $this->student_id));
			
			if ($this->db->affected_rows () > 0) {
				$message = "Porfile updated successfully";
				$this->session->set_flashdata ( 'success_message', $message );
				redirect ( base_url ( 'student_profile' ) );
			} else {
				$message = "Failed to update your profile";
				$this->session->set_flashdata ( 'error_message', $message );
				redirect ( base_url ( 'student_profile' ) );
			}
		}
	}
	
	/**** ajax function ******/
	
}