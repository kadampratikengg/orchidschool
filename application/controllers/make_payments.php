<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Make_payments extends CI_Controller {
	
	var $user_id;
	var $academic_id;
	
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STUDENT" );
		
		$this->user_id=$this->session->userdata('user_id');
		$this->student_id=$this->session->userdata('student_id');
		$this->academic_id=$this->session->userdata('current_academic_year_id');
	}
	
	public function index() {
        
		$data['instalment_data'] = $this->db->query("SELECT student_id, student_firstname, student_lastname, standard_instalments.* FROM students, standard_instalments 
														WHERE standard_instalments.standard_id IN (SELECT standard_id FROM divisions WHERE division_id IN (SELECT division_id FROM students WHERE student_id = '186')) 
														AND start_date <= '".date('Y-m-d')."' AND due_date >= '".date('Y-m-d')."' 
														AND student_id = '".$this->student_id."' AND standard_instalments.academic_year_id = '".$this->academic_id."' ")->row_array();
		
		$this->load->view ( 'make_payments/default', $data);
	}
    public function download_challan($student_id, $standard_instalment_id)
    {
    	
    	$data['student_instalment'] = $this->db->query("SELECT student_id, student_firstname, student_lastname, admission_no, parent_mobile_no, division_name, standard_prefix, standard_name, instalment_prefix, end_date, instalment_amount, late_fee, from_year, to_year 
    												FROM students, divisions, standards,standard_instalments, academic_years WHERE `student_id` = '".$student_id."' 
    												AND divisions.division_id IN (SELECT division_id FROM students WHERE student_id = '".$student_id."') 
    												AND standards.standard_id IN (SELECT standard_id FROM standard_instalments WHERE standard_instalment_id = '".$standard_instalment_id."')
    												AND standard_instalment_id = '".$standard_instalment_id."'
    												AND academic_years.academic_year_id IN (SELECT academic_year_id FROM student_academic_years WHERE student_id = '".$student_id."')")->row_array();
    	
    	$data['instalment_particulars'] = $this->db->query("SELECT description, amount, sequence_no FROM instalment_particulars 
    															WHERE standard_instalment_id = '".$standard_instalment_id."'")->result_array();
    	
    	$bank_challan = $this->load->view ( "_pdf_tamplates/challan", "", TRUE);
    	
    	echo "<pre>";
    	print_r($bank_challan); 
     	exit;
    	
    	//generate_pdf($bank_challan,"bank_challan.pdf");
    	
    	redirect(base_url('make_payments'));
    }
}