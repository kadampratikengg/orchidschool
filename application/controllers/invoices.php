<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Invoices extends CI_Controller {
	
	var $user_id;
	var $academic_id;
	
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id=$this->session->userdata('user_id');
		$this->academic_id=$this->session->userdata('current_academic_year_id');
	}
	
	public function index()
	{
		$data ["invoices_data"] = $this->db->query ( "SELECT invoices.*,student_firstname,student_lastname, academic_years.*
														FROM students,invoices, academic_years
														WHERE invoices.student_id=students.student_id
														AND academic_years.academic_year_id = students.academic_year_id
														AND invoices.academic_year_id='".$this->academic_id."'")->result_array ();
		
		$this->load->view ( 'invoices/default', $data );
	}
	
	public function view($invoice_id)
	{
		$data ["invoice_data"] = $this->db->query ( "SELECT invoices.*,student_firstname,student_lastname, academic_years.*
														FROM students,invoices, academic_years
														WHERE invoices.student_id=students.student_id
														AND academic_years.academic_year_id = invoices.academic_year_id
														AND invoices.invoice_id='".$invoice_id."'")->row_array ();
		$result ['title'] = "Invoice Information";
	
		$result ['body'] = $this->load->view ( 'invoices/view', $data,TRUE);
		echo json_encode ( $result );
	}
}
