<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Instalments extends CI_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->login_model->validate_user_login ( "STUDENT" );
		
		$this->user_id=$this->session->userdata('user_id');
		$this->academic_id=$this->session->userdata('current_academic_year_id');
		$this->student_id=$this->session->userdata('student_id');
	}
	
	public function index() {
		
		$data ['instalment_data'] = $this->db->query ( "SELECT invoices.invoice_id, payment_id, instalment_name, invoice_amount, total_paid_amount,
														discount_amount, late_fee_amount, payment_date, start_date, due_date, invoices.student_id,
														standard_instalments.standard_instalment_id, invoices.status, payments.status
														FROM invoices LEFT JOIN payments ON (payments.invoice_id = invoices.invoice_id AND payments.status = 'PAYMENT-RECEIVED')
														LEFT JOIN standard_instalments ON invoices.standard_instalment_id =  standard_instalments.standard_instalment_id
														WHERE invoices.student_id = '{$this->student_id}'
														AND invoices.academic_year_id = '{$this->academic_id}'" )->result_array ();
	
		$this->load->view ( 'instalments/default',$data);
		
		//writ log
		$this->log_model->write_log("Installment Visited");
	}
	
	public function view_instalment_details($standard_instalment_id, $student_id)
	{
		
		$data['instalment_particulars'] = $this->db->query("SELECT instalment_particulars.*, staff_discount FROM instalment_particulars, students 
															WHERE standard_instalment_id = '".$standard_instalment_id."' 
															AND student_id = '".$student_id."'")->result_array();
		
		$response ['title'] = "Instalment Details";
		
		$response ['body'] = $this->load->view ( 'instalments/view_instalment_particulars', $data, true );
		echo json_encode ( $response );
		
	}
	
	public function initiate_pay($invoice_id, $payment_gateway=""){
		
		
		$invoice_data = $this->db->query("SELECT standard_prefix, students.*, invoices.*, (invoice_amount - discount_amount) AS total_fees, standard_instalments.* 
											FROM students, invoices, standard_instalments, standards WHERE students.student_id = '".$this->student_id."' 
											AND invoices.invoice_id = '".$invoice_id."' 
											AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id
											AND standard_instalments.standard_id = standards.standard_id
											AND invoices.academic_year_id = '".$this->academic_id."'")->row_array();
		
		$due_date = new DateTime($invoice_data['due_date']);
		$payment_date = new DateTime(date('Y-m-d'));
		$interval = $payment_date->diff($due_date);
		$late_days = $interval->format('%a');
		$total_late_fees= 0;
		if($payment_date>$due_date && $late_days>0){
			$total_late_fees = $late_days * $invoice_data["late_fee"];
		}
		$invoice_data['total_fees']  = $total_late_fees + $invoice_data['total_fees'];
		
		$insert_data = array(
				'invoice_id' => $invoice_data['invoice_id'],
				'student_id' => $invoice_data['student_id'],
				'academic_year_id' => $invoice_data['academic_year_id'],
				'payment_type' => "INSTALMENT",
				'payment_mode' => "ONLINE-GATEWAY",
				'payment_date' => date('Y-m-d'),
				'payment_amount' => $invoice_data['outstanding_amount'],
				'late_fee_amount' => $total_late_fees,
				'total_paid_amount' => $invoice_data['total_fees'],
				'status' => 'AWAITING-PAYMENT',
				'entry_by' => $this->user_id
		);
		
		
		//$this->db->trans_start();
			$this->db->insert ( 'payments', $insert_data );
			$payment_id = $this->db->insert_id();
			
			//writ log
			$this->log_model->write_log("Payment Record Inserted","Payment id- {$payment_id} ");
			
			$this->session->set_userdata('payment_id', $payment_id);
			
			
		//$this->db->trans_complete();
		
		/*if ($this->db->trans_status () === FALSE) {
			
			$this->db->trans_rollback ();
			$this->session->set_flashdata ( 'error_message', "Instalment payment invoice not found, Please contact school authority" );
			redirect(base_url('instalments'));
		}else{
			
			$this->db->trans_commit ();
			$this->session->set_flashdata ( 'success_message', "Record saved successfully" );
		} */
		
		$admission_no = $invoice_data['admission_no'];
		$student_name = $invoice_data['student_firstname'].' '.$invoice_data['student_lastname'];
		$challan_no = $invoice_data['standard_prefix'].$invoice_data['instalment_prefix'].'-'.$invoice_data['student_id'];
		
		//request string
		/* MerchantID|CustomerID|NA|TxnAmount|NA|NA|NA|CurrencyType|NA|TypeField1|SecurityID
			|NA|NA|TypeField2|AdditionalInfo1|NA|NA|NA|NA|NA|NA|RU */
		
		if($payment_gateway ==""){
			
			$str = "ORCHIDSCH|".$invoice_data['invoice_id']."-".uniqid()."|NA|".$invoice_data['total_fees']."|NA|NA|NA|INR|NA|R|orchidsch|NA|NA|F|27|".$admission_no."|".$student_name."|".$challan_no."|NA|NA|NA|".base_url('initiate_pay/payment_response');
			$checksum_key = '7R1O7B99aDjW';
			
			$checksum_value = strtoupper(hash_hmac("sha256",$str, $checksum_key, false));
			
			$checksum = $str."|".$checksum_value;
			
			$this->session->set_userdata('checksum', $checksum);
			
			redirect(base_url('initiate_pay'));
		}else if($payment_gateway == "tpsl"){
			
			$this->session->set_userdata("student_name", $student_name);
			$this->session->set_userdata("amount", $invoice_data['total_fees']);
			$this->session->set_userdata("student_id", $this->student_id);
			$this->session->set_userdata("unique_t_id", $invoice_data['invoice_id']."X".mt_rand());

			redirect(base_url('initiate_tpsl_pay'));
		}
		
		//writ log
		$this->log_model->write_log("Payment Initiated","Payment id- {$payment_id}, Admission No- {$admission_no}, ".
				"Student Name- {$student_name}  ");
	}
	
	public function download_challan($student_id, $standard_instalment_id)
	{
		 
		$data['student_data'] = $this->db->query("SELECT students.*, division_name, standard_prefix, standard_name, standard_instalments.*, from_year, to_year 
															FROM students, divisions, standards, standard_instalments, academic_years 
															WHERE student_id = '".$student_id."' AND students.division_id = divisions.division_id 
															AND divisions.standard_id = standards.standard_id AND standard_instalments.standard_instalment_id = '".$standard_instalment_id."' 
															AND students.academic_year_id = academic_years.academic_year_id")->row_array();
		 
		$data['instalment_particulars'] = $this->db->query("SELECT description, amount, sequence_no FROM instalment_particulars
    															WHERE standard_instalment_id = '".$standard_instalment_id."'")->result_array();
		
		$data['config_data'] = $this->db->query("SELECT * FROM config WHERE 1")->result_array();
		
		
		$bank_challan = $this->load->view ( "_pdf_tamplates/challan", $data, TRUE);
		
		generate_pdf($bank_challan,"challan.pdf","landscape");
	}
	
	public function download_receipt($payment_id){
	
		$data ['payment_data'] = $this->db->query ( "SELECT student_firstname, student_lastname, admission_no,staff_discount, division_name, payments.*, discount_amount, instalment_name, standard_name
														FROM students, divisions, payments, standards, standard_instalments, invoices  
														WHERE payment_id = '".$payment_id."'AND payments.student_id = students.student_id 
														AND payments.invoice_id = invoices.invoice_id 
														AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id
														AND standard_instalments.standard_id = standards.standard_id
														AND students.division_id = divisions.division_id ")->row_array ();
	
		$data['instalment_particulars'] = $this->db->query("SELECT * FROM instalment_particulars WHERE standard_instalment_id
																IN (SELECT standard_instalment_id FROM invoices
																WHERE invoice_id = '".$data['payment_data']['invoice_id']."')")->result_array();
		
		$bank_challan = $this->load->view ( '_pdf_tamplates/payment_receipt', $data, TRUE);

		generate_pdf($bank_challan, "payment_receipt.pdf");
	}
}
