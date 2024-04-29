<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Payments extends CI_Controller {
	
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id = $this->session->userdata ( 'user_id' );
		$this->academic_id = $this->session->userdata ( 'current_academic_year_id' );
	}
	public function index() {
		
		$division_id = $this->input->get('division_id');
		
		if($division_id == ""){
			
			$data ['payments_data'] = array(); 
		}else{
			
			$data ['payments_data'] = $this->db->query ( "SELECT payments.*, student_firstname,student_lastname, admission_no, instalment_name 
															FROM students, student_academic_years, invoices, payments, standard_instalments 
															WHERE student_academic_years.division_id = '".$division_id."' 
															AND student_academic_years.student_id = payments.student_id 
															AND payments.student_id = students.student_id 
															AND payments.academic_year_id = '".$this->academic_id."' 
															AND payments.invoice_id = invoices.invoice_id
															AND payments.status = 'PAYMENT-RECEIVED'
															AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id")->result_array ();
		} 
		
		$data ['divisions'] = $this->db->query ("SELECT standards.standard_id, division_id, standard_name,
										division_name FROM standards, divisions
										WHERE divisions.standard_id = standards.standard_id
										AND divisions.academic_year_id ='".$this->academic_id."'
										ORDER BY standard_name, standards.standard_id, division_id")->result_array();
		
		$data['division_id']=$division_id; 
		
		$this->load->view ( 'payments/default', $data );
	}
	
	public function add() {
		
		$data['standards'] = $this->db->query("SELECT standards.*, divisions.* 
									FROM standards, divisions
									WHERE divisions.standard_id = standards.standard_id 
									AND divisions.academic_year_id = '".$this->academic_id."'
									ORDER BY standards.standard_id, division_id")->result_array ();
	
		$this->load->view ( 'payments/add', $data );
	}
	
	public function save() {
		
		$invoice_id = $this->input->post ( "invoice_id" );
		
		
		
		$this->form_validation->set_rules ( 'student_id', 'Student', 'required' );
		$this->form_validation->set_rules ( 'invoice_id', 'Invoice', 'required' );
		$this->form_validation->set_rules ( 'payment_mode', 'Payment Mode', 'required' );
		$this->form_validation->set_rules ( 'narration', 'Narration', 'required' );
		//$this->form_validation->set_rules ( 'transaction_no', 'Transaction', 'required' );
		$this->form_validation->set_rules ( 'payment_date', 'Payment Date', 'required' );
		$this->form_validation->set_rules ( 'payment_amount', 'Payment Amount', 'required|numeric|callback_check_amount['.$invoice_id.']' );
		$this->form_validation->set_rules ( 'late_fee_amount', 'Late Fees', 'required|numeric' );
		
		
		$student_id = $this->input->post ( "student_id" );
		$payment_mode = $this->input->post ( "payment_mode" );
		$narration = $this->input->post ( "narration" );
		$transaction_no = $this->input->post ( "transaction_no" );
		$payment_date = $this->input->post ( "payment_date" );
		$payment_amount = $this->input->post ( "payment_amount" );
		$late_fee_amount = $this->input->post ( "late_fee_amount" );
		
		if ($this->form_validation->run () == FALSE) {
			$this->add ();
		} else {
			
			//$this->db->trans_start();
			
			$invoice_data = $this->db->query("SELECT paid_amount, outstanding_amount FROM invoices WHERE invoice_id = '".$invoice_id."'")->row_array();
			
			$update_data = array(
					"paid_amount" => $invoice_data['paid_amount'] + $payment_amount + $late_fee_amount,
					"outstanding_amount" => $invoice_data['outstanding_amount'] - $payment_amount,
					"status" => "FULLY_PAID"
			);
			$this->db->update ( 'invoices', $update_data, array('invoice_id' => $invoice_id));
			
			$insert_data = array(
				 	"student_id" => $student_id,
				 	"invoice_id" => $invoice_id,
					"academic_year_id" => $this->academic_id,
			 		"payment_type" => "INSTALMENT",
				 	"payment_mode" => $payment_mode,
			 		"narration" => $narration,
			 		"transaction_no" => $transaction_no,
			 		"payment_date" => swap_date_format($payment_date),
			 		"payment_amount" => $payment_amount,
			 		"late_fee_amount" => $late_fee_amount,
					"status" => "PAYMENT-RECEIVED",
					"total_paid_amount" => (int) $payment_amount + (int) $late_fee_amount,
					"entry_by"=>$this->user_id
			);
			
			$this->db->insert ( 'payments', $insert_data );
			
			//$this->db->trans_complete();
			
			/*if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$this->session->set_flashdata('error_message', "Failed to add record");
			}
			else
			{
				$this->db->trans_commit();
				$this->session->set_flashdata('success_message', "Record saved successfully");
			}*/
			$this->session->set_flashdata('success_message', "Record saved successfully");
			redirect ( base_url ( 'payments' ) );
		}
	}
	
	public function view($payment_id) {
		
		
		$data ['payment_data'] = $this->db->query ( "SELECT student_firstname, student_lastname, discount_amount, payments.* , admission_no, instalment_name 
														FROM students, invoices, payments, standard_instalments 
														WHERE payment_id = '".$payment_id."' 
														AND payments.invoice_id = invoices.invoice_id 
														AND students.student_id = payments.student_id GROUP BY payment_id")->row_array ();
		
		$data['instalment_particulars'] = $this->db->query("SELECT * FROM instalment_particulars WHERE standard_instalment_id 
																IN (SELECT standard_instalment_id FROM invoices 
																WHERE invoice_id = '".$data['payment_data']['invoice_id']."')")->result_array();
		
		$result ['title'] = "Student Payment Details";
		$result ['body'] = $this->load->view ( 'payments/view', $data, true );
		echo json_encode ( $result );
	}
	
	public function download_receipt($payment_id){
	
		$data ['payment_data'] = $this->db->query ( "SELECT students.*, payments.*, discount_amount, instalment_name,division_name, standard_name FROM students, standards, divisions, payments, standard_instalments, invoices  
														WHERE payment_id = '".$payment_id."'AND payments.student_id = students.student_id 
														AND payments.invoice_id = invoices.invoice_id AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id
														AND standard_instalments.standard_id = standards.standard_id
														AND divisions.division_id = students.division_id")->row_array ();
		
		$data['instalment_particulars'] = $this->db->query("SELECT * FROM instalment_particulars WHERE standard_instalment_id
																IN (SELECT standard_instalment_id FROM invoices
																WHERE invoice_id = '".$data['payment_data']['invoice_id']."')")->result_array();
		
		$bank_challan = $this->load->view ( '_pdf_tamplates/payment_receipt', $data, TRUE);
		
		generate_pdf($bank_challan, "payment_receipt.pdf");
	}
	
	public function delete($payment_id) {
	
		//$this->db->trans_start();
			
		$payment_data = $this->db->query("SELECT invoice_id, payment_amount FROM payments 
											WHERE payment_id = '".$payment_id."'")->row_array();
		
		$invoice_data = $this->db->query("SELECT student_id, academic_year_id, paid_amount, outstanding_amount FROM invoices 
											WHERE invoice_id = '".$payment_data['invoice_id']."'")->row_array();
		
		$update_data = array(
				"paid_amount" => $invoice_data['paid_amount'] - (int) $payment_data['payment_amount'],
				"outstanding_amount" => $invoice_data['outstanding_amount'] + (int) $payment_data['payment_amount'],
				"status" => 'UNPAID'
		);
		
		$this->db->update ( 'invoices', $update_data, array('invoice_id' => $payment_data['invoice_id']));
		
		// updating all instalment outstanding fees
		$update_data = array(
				"outstanding_amount" => $invoice_data['outstanding_amount'] + (int) $payment_data['payment_amount']
		);
		$update_conditions = array(
				"student_id" => $invoice_data['student_id'],
				"academic_year_id" => $invoice_data['academic_year_id'],
				"invoice_type" => 'TUITION-FEE',
				"status"=>'UNPAID'
		);
		
		$this->db->update ( 'invoices', $update_data, $update_conditions);
		
		
		
		$this->db->delete ( 'payments', array ('payment_id' => $payment_id));
	
		//$this->db->trans_complete(); # Completing transaction
			
		/*if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error_message', "Failed to delete record");
		}
		else
		{
			$this->db->trans_commit();
			$this->session->set_flashdata('success_message', "Record deleted successfully");
		}*/
		
		$this->session->set_flashdata('success_message', "Record deleted successfully");
		redirect ( base_url ( 'payments' ) );
	}
	
	public function download_sample_excel(){
		
		$path    =   file_get_contents(base_url()."downloads/sample_bank_excel_format.xlsx");
		$name    =   "sample_bank_excel_format.xlsx";
		force_download($name, $path);
		
		redirect(base_url('payments/bulkupload'));
	} 
	
	public function bulkupload() {
		$data['instalments'] = $this->db->query("SELECT * FROM standard_instalments 
													WHERE academic_year_id = '".$this->academic_id."' GROUP BY instalment_name")->result_array();
		
		$this->load->view ( 'payments/bulkupload', $data );
	}
	
	public function save_bulkupload() {
		
		$this->form_validation->set_rules ( 'instalment_prefix', 'Instalment Prefix', 'required' );
	
		
		if ($_FILES ["payments_excel"] ["name"] == "") {
			$this->form_validation->set_rules ( "payments_excel", "Bulk upload file", "required" );
		}
	
		/* upload config */
		$config ['upload_path'] = './uploads/temp_files/';
		$config ['allowed_types'] = 'xlsx|xls';
		$config ['max_size'] = 2048;
		$config ['file_name'] = uniqid ( "payments_bulk_" );
		$this->upload->initialize ( $config );
	
		if ($this->form_validation->run () == FALSE || $this->upload->do_upload('payments_excel') == FALSE) {
				
			$this->bulkupload ();
				
		} else {
			
			$instalment_prefix = $this->input->post('instalment_prefix');
			
			$upload_data = $this->upload->data ();
			$uploaded_file_name=$upload_data['file_name'];
			
			$this->load->library ( 'Simpleexcel' );
			
			$excel_data = $this->simpleexcel->read_excel ( "uploads/temp_files/".$uploaded_file_name );
			
			$num_cols = count ( $excel_data [0] );
			$f = 0;
			$paid_invoice_count = 0;
			$save_record_cnt = 1;
			$invoice_count = 0;
			
			foreach ( $excel_data as $row ) {
			
				// Ignore the inital name row of excel file
				if ($f == 0) {
					$f ++;
					continue;
				}

				$paid_invoices = $this->db->query("SELECT payment_id
													FROM students, invoices, payments, standard_instalments 
													WHERE admission_no = '{$row[3]}' 
													AND instalment_prefix = '{$instalment_prefix}' 
													AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
													AND invoices.student_id = students.student_id 
													AND invoices.academic_year_id = '{$this->academic_id}' 
													AND invoices.invoice_id=payments.invoice_id
													AND payments.status != 'AWAITING-PAYMENT'");

 				$paid_invoice_count += $paid_invoices->num_rows();
 				
 				
 				$invoices = $this->db->query("SELECT invoice_id 
 														FROM students, invoices, standard_instalments 
														WHERE admission_no = '{$row[3]}' 
														AND instalment_prefix = '{$instalment_prefix}' 
														AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
														AND invoices.student_id = students.student_id 
														AND invoices.academic_year_id = '{$this->academic_id}'");
 				
 				$invoice_count += $invoices->num_rows();
			}

			if($invoice_count < 1){
			
				$this->session->set_flashdata('error_message', "Invoice is not generated for these students");
				redirect ( base_url ( 'payments' ) );
			
			} else if($paid_invoice_count > 0){
				
				$this->session->set_flashdata('error_message', "Payment already added for selected instalment");
				redirect ( base_url ( 'payments' ) );
		
			}else{

				$f = 0;
				
				$save_record_cnt = 1; 
				foreach ( $excel_data as $row ) {
					// Ignore the inital name row of excel file
					if ($f == 0) {
						$f ++;
						continue;
					}
					
					$invoice_data =	$this->db->query("SELECT students.student_id, invoice_id, invoice_amount, 
														discount_amount, paid_amount, outstanding_amount
														FROM students, invoices, standard_instalments 
														WHERE admission_no = '{$row[3]}' 
														AND instalment_prefix = '{$instalment_prefix}' 
														AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
														AND invoices.student_id = students.student_id 
														AND invoices.academic_year_id = '{$this->academic_id}'")->row_array();
					
					$payable_amount = $invoice_data['invoice_amount'] - $invoice_data['discount_amount'];
					$late_fees = $row[5] - $payable_amount;
					
					$data['invoice_id'] 		= $invoice_data['invoice_id'];
					$data['student_id'] 		= $invoice_data['student_id'];
					$data['academic_year_id'] 	= $this->academic_id;
					$data['payment_type'] 		= 'INSTALMENT';
					$data['payment_mode'] 	= 'BANK-DEPOSIT';	
					$data['narration'] 			= $row[7];
					$data['transaction_no'] 	= $row[6];	
					$data['payment_date'] 		= swap_date_format($row[1]);	//date("Y/m/d", strtotime($row[1]));
					$data['payment_amount'] 	= $payable_amount;
					$data['late_fee_amount'] 	= $late_fees;
					$data['total_paid_amount'] 	= $row[5];
					$data['status'] 			= 'PAYMENT-RECEIVED'; 
					$data['entry_by'] 			= $this->user_id;
					
					
					//$this->db->trans_start();

					$this->db->insert('payments' , $data);
				
					$save_record_cnt ++;
				 
					// updating invoice
 					$update_data = array(
							"paid_amount" => $invoice_data['paid_amount'] + $data['total_paid_amount'],
							"outstanding_amount" => $invoice_data['outstanding_amount'] - $data['payment_amount'],
							"status" => "FULLY_PAID"
					);


					$this->db->update ( 'invoices', $update_data, array('invoice_id' => $data['invoice_id']));
				
					//$this->db->trans_complete();  # Completing transaction
				}
				
				
				/*if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$this->session->set_flashdata('error_message', "Failed to save all records");
				
					redirect ( base_url ( 'payments' ) );
				}
				else
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('success_message', "All records saved successfully");
					redirect ( base_url ( 'payments' ) );
				}*/
				
				$this->session->set_flashdata('success_message', "All records saved successfully");
				redirect ( base_url ( 'payments' ) );
			}
			
		}
	}
	
	
	public function check_amount($payment_amount, $invoice_id){
		
		$invoice_data = $this->db->query("SELECT paid_amount, outstanding_amount FROM invoices WHERE invoice_id = '".$invoice_id."'")->row_array();
		
		if($invoice_data['outstanding_amount'] >= $payment_amount && $payment_amount > 0){
			
			return true;
		
		}else{
			
			$this->form_validation->set_message('check_amount',"Payment amount should not exceed outstanding amount({$invoice_data['outstanding_amount']})");
			return false;
		}
	}
	
	/**
	 * ********** ajax functions ******
	 */
	
	/* public function get_students() {
		$division_id = $this->input->post ( 'division_id' );
	
		$students = $this->db->query("SELECT students.* FROM students, invoices WHERE students.division_id = '".$division_id."' 
										AND students.student_id = invoices.student_id 
										GROUP BY invoices.student_id")->result_array ();
	
		echo '<option value="">Select</option>';
		foreach ( $students as $row ) {
			echo '<option value="' . $row ['student_id'] . '">' . $row ['student_firstname'] .' '.$row['student_lastname']. '</option>';
		}
	} */
	
	public function get_invoices() {
		$student_id = $this->input->post ( 'student_id' );
		$invoices = $this->db->query("SELECT invoices.*, instalment_name FROM invoices, standard_instalments WHERE invoices.student_id = '".$student_id."'
										AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id
										AND invoices.status = 'UNPAID'
										AND invoices.academic_year_id = '".$this->academic_id."'")->result_array();
		
		echo '<option value="">Select</option>';
		foreach ( $invoices as $row ) {
			echo "<option value= '".$row['invoice_id']."'>".$row['invoice_type']."-".$row['instalment_name']." Instalment</option>";
		}
	}
	
	public function get_payment_amount(){
		$invoice_id = $this->input->post('invoice_id');
		$data = $this->db->query("SELECT outstanding_amount FROM invoices WHERE invoice_id ='".$invoice_id."'")->row_array();
		
		echo json_encode($data);
	}
	
	public function get_late_fees(){
		$invoice_id = $this->input->post('invoice_id');
		$payment_date = swap_date_format($this->input->post('payment_date'));
		
		$data = $this->db->query("SELECT due_date, late_fee FROM invoices, standard_instalments WHERE invoices.invoice_id ='".$invoice_id."'
										AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id")->row_array();
		
		
		$due_date = new DateTime($data['due_date']);
		$payment_date = new DateTime($payment_date);
		$interval = $payment_date->diff($due_date);
		$late_days = $interval->format('%a');
		$total_late_fees= 0;
		if($payment_date>$due_date && $late_days>0){
			$total_late_fees = $late_days * $data["late_fee"];
		}
		echo json_encode($total_late_fees);
	}
	
	public function get_instalmetns() {
		$standard_id = $this->input->post ( 'standard_id' );
	
		$instalments = $this->db->get_where ( 'standard_instalments', array (
				'standard_id' => $standard_id
		) )->result_array ();
	
		echo '<option value="">Select</option>';
		foreach ( $instalments as $row ) {
			echo '<option value="' . $row ['standard_instalment_id'] . '">' . $row ['instalment_name'] . '</option>';
		}
	}
	
	public function get_students() {
		
		$admission_no = $this->input->post('admission_no');
		
		$query = $this->db->query("SELECT students.student_id, concat(student_firstname,' ',student_lastname) as name, 
													invoice_id, standard_instalments.standard_instalment_id, instalment_name 
													FROM students, invoices, standard_instalments 
													WHERE admission_no = '{$admission_no}' AND students.student_id = invoices.student_id 
													AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id
													AND invoices.academic_year_id = '{$this->academic_id}'");
		$data['student_count'] = $query->num_rows();
		$data['student_data'] = $query->row_array();
		
		echo json_encode($data);
	}
}
