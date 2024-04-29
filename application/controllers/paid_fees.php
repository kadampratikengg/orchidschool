<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Paid_fees extends CI_Controller {
	
		var $user_id;
		var $academic_id;
		public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id=$this->session->userdata('user_id');
		$this->student_id=$this->session->userdata('student_id');
		$this->academic_id=$this->session->userdata('current_academic_year_id');
	}
	
	public function index() 
	{
		
		 $data['paid_fees_data']=$this->db->query("select payments.*,students.*,invoices.*,standard_instalments.standard_instalment_id,standard_instalments.instalment_name,
												academic_years.academic_year_id,academic_years.from_year, academic_years.to_year 
									           from payments,students,standard_instalments,invoices,academic_years
													where students.student_id='".$this->student_id."'
													AND invoices.standard_instalment_id=standard_instalments.standard_instalment_id
													AND invoices.invoice_id=payments.invoice_id
													AND students.student_id=payments.student_id
													AND academic_years.academic_year_id=payments.academic_year_id
													ANd payments.status='PAYMENT-RECEIVED'")->result_array ();
		
		 $this->load->view('paid_fees/default',$data);
	}

	public function view($student_id,$invoice_id)
	{
		
		$data['payment_data']=$this->db->query("select * from payments where invoice_id='".$invoice_id."'")->row_array ();
		$data['student_data']=$this->db->query("select * from students where student_id='".$student_id."'")->row_array ();
		$data['academic_data']=$this->db->query("select * from academic_years where academic_year_id='".$data['student_data']['academic_year_id']."' ")->row_array(); 
		$data ['standard_data'] = $this->db->query ("SELECT standard_name from standards 
							WHERE standard_id IN (SELECT standard_id from divisions,students 
							WHERE divisions.division_id ='".$data ['student_data'] ['division_id']."' 
							AND students.student_id = '".$student_id."')" )->row_array ();
		$data['division_data']=$this->db->query("select * from divisions where division_id='".$data['student_data']['division_id']."' ")->row_array(); 
		$data['discount_amount']=$this->db->query("select * from invoices where invoice_id='".$invoice_id."' ")->row_array();
		
		$result ['title'] = "Paid Fees Information";
		$result ['body'] = $this->load->view ( 'paid_fees/view', $data, true );
		echo json_encode ( $result );
	}
	
	function download_receipt($student_id,$invoice_id)
	{	
		$data['payment_data']=$this->db->query("select * from payments where invoice_id='".$invoice_id."'")->row_array ();
		$data['student_data']=$this->db->query("select * from students where student_id='".$student_id."'")->row_array ();
		$data['academic_data']=$this->db->query("select * from academic_years where academic_year_id='".$data['student_data']['academic_year_id']."' ")->row_array(); 
		$data['standard_data'] = $this->db->query ("SELECT standard_name from standards 
							WHERE standard_id IN (SELECT standard_id from divisions,students 
							WHERE divisions.division_id ='".$data ['student_data'] ['division_id']."' 
							AND students.student_id = '".$student_id."')" )->row_array ();
		$data['division_data']=$this->db->query("select * from divisions where division_id='".$data['student_data']['division_id']."' ")->row_array(); 
		$data['discount_amount']=$this->db->query("select * from invoices where invoice_id='".$invoice_id."' ")->row_array();
		
		$html = $this->load->view('_pdf_tamplates/student_receipt', $data, TRUE);
		generate_pdf($html, 'student_receipt.pdf');
		
		redirect(base_url("paid_fees"));		
				
	} 
	
	

}