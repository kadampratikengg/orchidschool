<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class other_fees extends CI_Controller {
	
	var $user_id;
	var $academic_id;
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id = $this->session->userdata ( 'user_id' );
		$this->academic_id = $this->session->userdata ( 'current_academic_year_id' );
	}
	public function index() {
		$data ['other_fees_data'] = $this->db->query("SELECT other_fees.*,student_firstname, student_lastname, division_name 
													FROM other_fees left join students on other_fees.student_id = students.student_id 
													left join divisions on other_fees.division_id = divisions.division_id 
													where other_fees.academic_year_id = '".$this->academic_id ."'")->result_array ();
		
		$this->load->view ( 'other_fees/default', $data );
	}
	public function apply_division_fees() {
		
		$data ['standards'] = $this->db->get_where ( 'standards', array ( 'academic_year_id' => $this->academic_id ))->result_array ();
		
		$this->load->view ( 'other_fees/apply_division_fees', $data );
	}
	public function save_division_fees() {
		
		$this->form_validation->set_rules ( 'standard_id', 'Standard', 'required' );
		$this->form_validation->set_rules ( 'division_id', 'Division', 'required' );
		$this->form_validation->set_rules ( 'description', 'Fees Description', 'required' );
		$this->form_validation->set_rules ( 'total_fees', 'Total Fees', 'required' );
		$this->form_validation->set_rules ( 'compulsory', 'Compulsory', '' );
		$this->form_validation->set_rules ( 'apply_staff_discount', 'Staff Discount', '' );
		$this->form_validation->set_rules ( 'start_date', 'Start Date', 'required' );
		$this->form_validation->set_rules ( 'end_date', 'End Date', 'required' );

		if($this->input->post('compulsory')=='yes'){
			$this->form_validation->set_rules ( 'due_date', 'Due Date', 'required' );
			$this->form_validation->set_rules ( 'late_fees', 'Late Fees', 'required' );
		}
		
		if ($this->form_validation->run () == FALSE) {
			$this->apply_division_fees();
		} else {
			
			$insert_data = array(
					"division_id"=>$this->input->post('division_id'),
					"description"=>$this->input->post('description'),
					"compulsory"=>$this->input->post('compulsory'),
					"applicable_to"=>"DIVISION",
					"amount"=>$this->input->post('total_fees'),
					"start_date"=>swap_date_format($this->input->post('start_date')),
					"end_date"=>swap_date_format($this->input->post('end_date')),
					"academic_year_id"=>$this->academic_id,
					"entry_by"=>$this->user_id
			);
			
			if($this->input->post('compulsory')=='yes'){
				$insert_data["due_date"]=swap_date_format($this->input->post('due_date'));
				$insert_data["late_fees"]=$this->input->post('late_fees');
			}
			
			$this->db->insert("other_fees",$insert_data);
			$other_fee_id = $this->db->insert_id();
			
			$students = $this->db->query("select student_id, staff_discount from students where division_id = '".$this->input->post('division_id')."'")->result_array();
			
			$apply_staff_discount=$this->input->post('apply_staff_discount');
			$total_fees=$this->input->post('total_fees');
			
			$insert_data = array();
			foreach ( $students as $row ) {
				
				if ($apply_staff_discount== "yes") 
					$discount_amount = ($total_fees) * ($row ['staff_discount']) / 100;
				else
					$discount_amount=0;
				
				$outstanding_amount = $total_fees - $discount_amount;
			
				$insert_data[] = array (
						"student_id" => $row ["student_id"],
						"academic_year_id" => $this->academic_id,
						"other_fee_id" => $other_fee_id, 
						"description" => $this->input->post('description'),
						"invoice_type" => "OTHER-FEE",
						"invoice_date" => date('Y-m-d'),
						"invoice_amount" => $total_fees,
						"discount_amount" => $discount_amount,
						"paid_amount" => 0,
						"outstanding_amount" => $outstanding_amount,
						"status" => "UNPAID",
						"entry_by" => $this->user_id
				);
			}
			$this->db->insert_batch('invoices', $insert_data);
			/* redirect*/
			$this->session->set_flashdata ( 'success_message', "Record saved successfully");
			redirect ( base_url ( 'other_fees' ) );
		}
	}
	
	public function apply_student_fees() {
	
		$data ['divisions'] = $this->db->query ("select standards.standard_id, division_id, standard_name,
										division_name from standards, divisions 
										where divisions.standard_id = standards.standard_id 
										AND divisions.academic_year_id ='".$this->academic_id."'
										order by standards.standard_id, division_id")->result_array();
		
		$this->load->view ( 'other_fees/apply_student_fees', $data );
	}
	
	public function save_student_fees(){
		
		$this->form_validation->set_rules ( 'division_id', 'Division', 'required' );
		$this->form_validation->set_rules ( 'student_id', 'Student', 'callback_check_students_count' ); 
		$this->form_validation->set_rules ( 'description', 'Fees Description', 'required' );
		$this->form_validation->set_rules ( 'total_fees', 'Total Fees', 'required' );
		$this->form_validation->set_rules ( 'start_date', 'Start Date', 'required' );
		$this->form_validation->set_rules ( 'end_date', 'End Date', 'required' );
		$this->form_validation->set_rules ( 'due_date', 'Due Date', 'required' );
		$this->form_validation->set_rules ( 'late_fees', 'Late Fees', 'required' );
		
		if ($this->form_validation->run () == FALSE) {
			$this->apply_student_fees ();
		} else {
			
			$total_fees=$this->input->post('total_fees');
			$student_id = $this->input->post('student_id');
			
			$other_fees_insert_data = array();
			$invoice_insert_data=array();
			
			for( $i=0; $i<count($student_id);$i++){
				
				$other_fees_insert_data= array(
						"division_id"=>$this->input->post('division_id'),
						"student_id"=>$student_id[$i],
						"description"=>$this->input->post('description'),
						"compulsory"=>"YES",
						"applicable_to"=>"STUDENT",
						"amount"=>$this->input->post('total_fees'),
						"start_date"=>swap_date_format($this->input->post('start_date')),
						"due_date"=>swap_date_format($this->input->post('due_date')),
						"end_date"=>swap_date_format($this->input->post('end_date')),
						"late_fees"=>$this->input->post('late_fees'),
						"academic_year_id"=>$this->academic_id,
						"entry_by"=>$this->user_id
				);
				$this->db->insert('other_fees', $other_fees_insert_data);
				$other_fee_id = $this->db->insert_id();
				
				$invoice_insert_data[] = array (
						"student_id"=>$student_id[$i],
						"academic_year_id" => $this->academic_id,
						"other_fee_id" => $other_fee_id,
						"description" => $this->input->post('description'),
						"invoice_type" => "OTHER-FEE",
						"invoice_date" => date('Y-m-d'),
						"invoice_amount" => $total_fees,
						"discount_amount" => 0,
						"paid_amount" => 0,
						"outstanding_amount" => $total_fees,
						"status" => "UNPAID",
						"entry_by" => $this->user_id
				);
				
			}
				
			$this->db->insert_batch('invoices', $invoice_insert_data);
			
			
			$this->session->set_flashdata ( 'success_message', "Record saved successfully");
			redirect ( base_url ( 'other_fees' ) ); 
		}
	}
	
	/* Call Back functions */
	function check_students_count($student_id){
		
		if(count($this->input->post('student_id'))==0){
			$this->form_validation->set_message('check_students_count', 'You must select atleast one applicable student');
			return false;
		}
		return true;
	}
	
	/**
	 * ********** ajax functions ******
	 */
	
	public function get_divisions() {
		$standard_id = $this->input->post ( 'standard_id' );
	
		$divisions = $this->db->get_where ( 'divisions', array ('standard_id' => $standard_id,"academic_year_id"=>$this->academic_id))->result_array ();
	
		$division_html= '<option value="">Select</option>';
		foreach ( $divisions as $row ) {
			$division_html =$division_html.'<option value="' . $row ['division_id'] . '">' . $row ['division_name'] . '</option>';
		}
	
		echo $division_html;
	}
	public function get_students() {
		$division_id = $this->input->post ( 'division_id' );
	
		$students = $this->db->query ( "SELECT student_id, student_firstname, student_lastname  FROM students
    											WHERE students.academic_year_id = " . $this->academic_id ."
    											AND students.division_id =" . $division_id )->result_array ();
		echo '<option value="">Select</option>';
		foreach ( $students as $row ) {
			echo '<option value="' . $row ['student_id'] . '">' . $row ['student_firstname'] . ' ' . $row ['student_lastname'] . '</option>';
		}
	}
}