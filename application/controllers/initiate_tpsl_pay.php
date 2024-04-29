<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Initiate_tpsl_pay extends CI_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->login_model->validate_user_login ( "STUDENT" );
		
		$this->user_id=$this->session->userdata('user_id');
		$this->academic_id=$this->session->userdata('current_academic_year_id');
		$this->student_id=$this->session->userdata('student_id');

		$this->load->helper("techprocess");
	}
	
	public function index() {
		$userdata = array(
			"student_id" => $this->session->userdata("student_id"),
			"student_name" => $this->session->userdata("student_name"),
			"amount" => $this->session->userdata("amount"),
			"unique_t_id" => $this->session->userdata("unique_t_id")
			);
		
		$this->load->view("techprocess/process", $userdata);
	}
	public function process() {
		process_payment($_POST);
	}
	
	public function payment_response(){
		
		$response = process_response($_POST);
		
		$response_array = explode("|", $response);

		$response_status = explode("=",$response_array[1]);
		$response_status = $response_status[1];
		$narration = explode("=", $response_array[2]);
		$narration = $narration[1];
		$transaction_no = explode("=", $response_array[5]);
		$transaction_no = $transaction_no[1];


		if($response_status=="success"){
			$payment_id = $this->session->userdata('payment_id');
				
			$query = $this->db->get_where('payments', array('payment_id'=>$payment_id));
			$payment_data = $query->row_array();
			$invoice_data = $this->db->get_where('invoices', 
							array('invoice_id' => $payment_data['invoice_id']))->row_array();

			
			
			if($query->num_rows()>0){
				
				$update_data = array(
								'narration' => $narration,
								'transaction_no' => $transaction_no,
								'status' => "PAYMENT-RECEIVED"
							);
				
				//$this->db->trans_start();
					$this->db->update ( 'payments', $update_data, array ('payment_id' => $payment_id) );
					$update_data = array(
									'paid_amount' => $payment_data['payment_amount'],
									'outstanding_amount' => $invoice_data['outstanding_amount'] - $payment_data['payment_amount'],
									'status' => "FULLY_PAID"
								);
					$this->db->update ( 'invoices', $update_data, 
									array ('invoice_id' => $payment_data['invoice_id']) );

					$data['status'] = 'success';
					$data['message'] = 'Trasaction has been completed successfully, Reference:'.$transaction_no;
					$data['response_data'] = $response_array;
						
					$this->load->view('initiate_tpsl_pay/success', $data);
					
					//writ log
					$this->log_model->write_log("TechProcess Payment Success", "Amount - ".$payment_data['payment_amount'].", Payment Id- $payment_id,".
							"Transaction No-".$transaction_no.", Invoice Id - ". $payment_data['invoice_id']);
			} else{
					
				$data['status'] = 'error';
				$data['message'] = 'Instalment payment invoice not found, Please contact school authority';
				$data['response_data'] = $response_array;
				
				$this->load->view('initiate_tpsl_pay/failure', $data);
				
				//writ log
				$this->log_model->write_log("TechProcess Payment Failed due to No Invoice data", "Amount - ".$payment_data['payment_amount'].", Payment Id- $payment_id,".
						"Transaction No-".$transaction_no.", Invoice Id - ". $payment_data['invoice_id']);
			}
		}else{
			
			$data['status'] = 'failed';
			$data['message'] = 'Trasaction has been failed, Error:'.
								$narration.'(Reference: '.$transaction_no.')';
			$data['response_array'] = $response_array;
				
			$this->load->view('initiate_tpsl_pay/failure', $data);
			
			//writ log
			$this->log_model->write_log("TechProcess Payment Failed due to Abort");
		}
	}
}