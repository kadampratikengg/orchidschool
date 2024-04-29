<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_dashboard extends CI_Controller 
{

	var $user_id;
	var $academic_id;
    var $student_id;
    
	public function __construct()
	{
		parent::__construct();
        // Your own constructor code
        $this->login_model->validate_user_login("STUDENT");
        
        $this->user_id=$this->session->userdata('user_id');
        $this->student_id=$this->session->userdata('student_id');
        $this->academic_id=$this->session->userdata('current_academic_year_id');
	}
	
	public function index()
	{
		
		$data['fees_data'] = $this->db->query("SELECT SUM(invoice_amount) AS total_fees, SUM(paid_amount) AS total_fees_paid, SUM(outstanding_amount) AS total_outstanding_fees, 
														SUM(discount_amount) AS total_discount FROM invoices 
														WHERE invoices.academic_year_id = '".$this->academic_id."' 
														AND invoices.student_id ='".$this->student_id."'")->row_array();
		
		$this->load->view('student_dashboard/default',$data);
		//writ log
		$this->log_model->write_log("Student Dashboard Visited");
	}
	
	public function download_tax_certificate(){
	
		$data['student_data'] = $this->db->query("SELECT students.*, division_name, standard_name, academic_years.* FROM students, divisions, standards, academic_years
													WHERE students.student_id = '".$this->student_id."'
													AND students.division_id = divisions.division_id
													AND divisions.standard_id = standards.standard_id
													AND students.academic_year_id = academic_years.academic_year_id")->row_array();
	
		$data['instalment_data'] = $this->db->query("SELECT payments.*, instalment_name FROM standard_instalments, invoices, payments
														WHERE invoices.student_id = '".$this->student_id."'
														AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id
														AND invoices.invoice_id = payments.invoice_id
														AND payments.status = 'PAYMENT-RECEIVED'
														AND invoices.academic_year_id = '".$this->academic_id."'")->result_array();
		
		$tax_certificate = $this->load->view ( "_pdf_tamplates/tax_certificate", $data, TRUE);
		
		generate_pdf($tax_certificate,"tax-certificate.pdf","portrait");
	}
}