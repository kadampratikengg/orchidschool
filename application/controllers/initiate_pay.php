<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Initiate_pay extends CI_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->login_model->validate_user_login ( "STUDENT" );
		
		$this->user_id=$this->session->userdata('user_id');
		$this->academic_id=$this->session->userdata('current_academic_year_id');
		$this->student_id=$this->session->userdata('student_id');
	}
	
	public function index() {
		
		$checksum =  $this->session->userdata('checksum');
		
		$loading_gif  = images_path.'loading.gif';
		
		echo "<html><body onLoad='document.subFrm.submit();'>";

		echo "<form id='subFrm' name='subFrm' method='post' action='https://pgi.billdesk.com/pgidsk/PGIMerchantPayment'>";
				echo "<input type='hidden' name='msg' value='$checksum'>";
			echo "</form>";
			echo "<center>";
				echo "<h3>";
					echo "<br> Redirecting to BillDesk Payment Gateway, <br> <br> <br> Please
						wait and Do not Press Back or Refresh
					</h3>
						If you are not redirected to BillDesk within 3 sec <a
						href='javascript:void(0);' onClick='document.subFrm.submit();'>Click
							here to redirect</a> <br> <br>"; 
					echo "<img src='$loading_gif'>";
			echo "</center>";
		echo "</body></html>";
		
		//writ log
		$this->log_model->write_log("Going For Payment Gateway");
	}
	
	public function payment_response(){
		
		$response = $this->input->post('msg');
		
		$response_data = explode('|', $response);
		
		$checksum_string = explode('|', $this->session->userdata('checksum'));
		
		//if($response_data[25] == $checksum_string[22]){
			
			if($response_data[14] =='0300' ){
				
				$payment_id = $this->session->userdata('payment_id');
				
				$query = $this->db->get_where('payments', array('payment_id'=>$payment_id));
				$payment_data = $query->row_array();
				$invoice_data = $this->db->get_where('invoices', array('invoice_id' => $payment_data['invoice_id']))->row_array();
				
				if($query->num_rows()>0){
					
					$update_data = array(
							'narration' => $response_data[24],
							'transaction_no' => $response_data[2],
							'status' => "PAYMENT-RECEIVED"
					);
					
					//$this->db->trans_start();
						$this->db->update ( 'payments', $update_data, array ('payment_id' => $payment_id) );
						$update_data = array(
								'paid_amount' => $payment_data['payment_amount'],
								'outstanding_amount' => $invoice_data['outstanding_amount'] - $payment_data['payment_amount'],
								'status' => "FULLY_PAID"
						);
						$this->db->update ( 'invoices', $update_data, array ('invoice_id' => $payment_data['invoice_id']) );
						
					/*$this->db->trans_complete();
					
					if ($this->db->trans_status () === FALSE) {
						$this->db->trans_rollback ();
					} else {
						$this->db->trans_commit ();
					}*/
					
					$data['status'] = 'success';
					$data['message'] = 'Trasaction has been completed successfully, Reference:'.$response_data[3];
					$data['response_data'] = $response_data;
						
					$this->load->view('initiate_pay/success', $data);
					
					//writ log
					$this->log_model->write_log("Payment Success", "Amount - ".$payment_data['payment_amount'].", Payment Id- $payment_id,".
							"Transaction No-".$response_data[2].", Invoice Id - ". $payment_data['invoice_id']);
					
				}else{
					
					$data['status'] = 'error';
					$data['message'] = 'Instalment payment invoice not found, Please contact school authority';
					$data['response_data'] = $response_data;
					
					$this->load->view('initiate_pay/failure', $data);
					
					//writ log
					$this->log_model->write_log("Payment Failed due to No Invoice data", "Amount - ".$payment_data['payment_amount'].", Payment Id- $payment_id,".
							"Transaction No-".$response_data[2].", Invoice Id - ". $payment_data['invoice_id']);
				}
			}else{
				
				$data['status'] = 'failed';
				$data['message'] = 'Trasaction has been failed, Error:'.$response_data[23].'('.$response_data[24].')';
				$data['response_data'] = $response_data;
					
				$this->load->view('initiate_pay/failure', $data);
				
				//writ log
				$this->log_model->write_log("Payment Failed due to Abort");
			}
		/* }else{
			
			$data['status'] = 'failed';
			$data['message'] = 'Trasaction has been failed, Error:'.$response_data[23].'('.$response_data[24].')';
			$data['response_data'] = $response_data;
				
			$this->load->view('initiate_pay/failure', $data);
		} */
	}
}