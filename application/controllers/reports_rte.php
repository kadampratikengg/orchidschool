<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class reports_rte extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id = $this->session->userdata ( 'user_id' );
		$this->academic_id = $this->session->userdata ( 'current_academic_year_id' );
	}
	public function index() {
		$data ["student_data"] = $this->db->query ( "SELECT students.*, division_name, standard_name  FROM students, divisions, standards 
													WHERE students.rte_provision = 'YES' AND students.division_id = divisions.division_id
													AND divisions.standard_id = standards.standard_id
													AND students.academic_year_id = '" . $this->academic_id . "'" )->result_array ();
		
		$this->load->view ( "reports_rte/default", $data );
	}
	public function view($student_id) {
		$data ['student_data'] = $this->db->query ( "SELECT students.*, from_year, to_year FROM students, academic_years 
													WHERE student_id = '" . $student_id . "' AND academic_years.academic_year_id IN (SELECT academic_year_id FROM students 
													WHERE student_id = '" . $student_id . "')" )->row_array ();
		
		$data ['division'] = $this->db->query ( "SELECT standard_name, division_name from standards, divisions
													WHERE (standards.standard_id, division_id) IN (SELECT standard_id, division_id FROM divisions
														WHERE division_id ='" . $data ['student_data'] ['division_id'] . "')
													AND standards.academic_year_id = '" . $this->academic_id . "'" )->row_array ();
		
		$data ['payments'] = $this->db->query ( "SELECT * FROM payments WHERE student_id = '" . $student_id . "' 
													AND academic_year_id = '" . $this->academic_id . "'" )->result_array ();
		
		$data ['instalments'] = $this->db->query ( "SELECT standard_instalments.*, invoices.status FROM standard_instalments, invoices 
													WHERE invoices.standard_instalment_id = standard_instalments.standard_instalment_id
													AND invoices.academic_year_id = '" . $this->academic_id . "' 
													AND invoices.student_id = '" . $student_id . "'" )->result_array ();
		$this->load->view ( 'reports_rte/view', $data );
	}
	
	public function download_report(){

		$reports_data = $this->db->query ( "SELECT admission_no, CONCAT(student_firstname,' ',student_lastname) AS student_name, admission_year, division_name, 
				standard_name, parent_email_id, parent_mobile_no, secondary_email_id, secondary_mobile_no  
				FROM students, divisions, standards WHERE students.rte_provision = 'YES' 
				AND students.division_id = divisions.division_id 
				AND divisions.standard_id = standards.standard_id 
				AND students.academic_year_id = '" . $this->academic_id . "'" )->result_array ();
		
		
		$columns=array('Admission No.', 'Student Name', 'Admission Year', 'Standard', 'Division', 'Parent Email Id', 'Parent Mobile No.', 'Secondary Email Id', 'Secondary Mobile No.');
		export_to_csv("rte_report.csv",$columns,$reports_data);
	}
}