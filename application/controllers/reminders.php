<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Reminders extends CI_Controller {
	
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id = $this->session->userdata ( 'user_id' );
		$this->academic_id = $this->session->userdata ( 'current_academic_year_id' );
		 $this->load->library('curl');
	}
	public function index() {
		
		$data ['standards'] = $this->db->query ( "SELECT * FROM standards WHERE academic_year_id = '" . $this->academic_id . "'
													ORDER BY standard_name" )->result_array ();
		$this->load->view ( 'reminders/default', $data );
	}
	
	public function send_reminder() {
		$this->form_validation->set_rules ( 'standard_id', 'Standard', 'required');
		$this->form_validation->set_rules ( 'message', 'Message', 'required');
		$this->form_validation->set_rules ( 'notify_by', 'Notify By', 'required');
		
		if ($this->form_validation->run () == FALSE) {
			$this->session->set_flashdata ( validation_errors () );
			$this->index ();
		} else {
			$this->form_validation->set_rules ( 'division_id', 'Division', 'required');
			if ($this->form_validation->run () == FALSE) {
				$this->session->set_flashdata ( validation_errors () );
				$this->index ();
			} else {
				$this->form_validation->set_rules ( 'applicable_student_id', 'Student', 'required');
				if ($this->form_validation->run () == FALSE) {
					$this->session->set_flashdata ( validation_errors () );
					$this->index ();
				}
			}
		}
		$student_id = $this->input->post ( 'applicable_student_id' );
		$standard_id = $this->input->post ( 'standard_id' );
		$division_id = $this->input->post ( 'division_id' );

		if($standard_id == 'all' && $division_id == 'all' && $student_id == "all"){
			//all std all div
			$data = $this->db->query("SELECT parent_name, parent_email_id, parent_mobile_no 
									FROM students, standards, divisions 
									WHERE standards.standard_id = divisions.standard_id 
									AND divisions.division_id = students.division_id 
									AND rte_provision = 'NO' 
									AND students.academic_year_id = '$this->academic_id'")->result_array();

		}else if($standard_id == 'all' && $division_id != 'all' && $student_id == 'all'){
			//1 div all stud
			$data = $this->db->query("SELECT parent_name, parent_email_id, parent_mobile_no 
										FROM students WHERE students.division_id = '$division_id' 
										AND students.academic_year_id = '$this->academic_id' 
										AND rte_provision = 'NO'")->result_array();

		}else if($standard_id == 'all' && $division_id != 'all' && $student_id != 'all'){
			//1 div 1 stud
			$data = $this->db->query("SELECT parent_name, parent_email_id, parent_mobile_no 
									FROM students WHERE students.student_id = '$student_id' 
									AND students.academic_year_id = '$this->academic_id' 
									AND rte_provision = 'NO'")->result_array();

		}else if($standard_id != 'all' && $division_id == 'all' && $student_id == 'all'){
			//1 std all div all student
			$data = $this->db->query("SELECT parent_name, parent_email_id, parent_mobile_no 
									FROM students, divisions 
									WHERE divisions.standard_id = '$standard_id' 
									AND divisions.division_id = students.division_id 
									AND students.academic_year_id = '$this->academic_id' 
									AND rte_provision = 'NO'")->result_array();

		}else if($standard_id != 'all' && $division_id != 'all' && $student_id == 'all'){
			//1 std 1 div all stud
			$data = $this->db->query("SELECT parent_name, parent_email_id, parent_mobile_no FROM students 
										WHERE students.division_id = '$division_id' 
										AND students.academic_year_id = '$this->academic_id' 
										AND rte_provision = 'NO'")->result_array();

		}else if($standard_id != 'all' && $division_id != 'all' && $student_id != 'all'){
			//1 std 1 div 1 stud
			$data = $this->db->query("SELECT parent_name, parent_email_id, parent_mobile_no 
										FROM students WHERE students.student_id = '$student_id' 
										AND students.academic_year_id = '$this->academic_id' 
										AND rte_provision = 'NO'")->result_array();

		}
		if (! empty ( $data )) {
			if ($this->input->post ( 'notify_by' ) == 'EMAIL' || $this->input->post ( 'notify_by' ) == 'BOTH') {
					
				foreach ( $data as $row ) {
					/* send email to parent */
					 $mail_data = array (
					 "parent_name" => $row ["parent_name"],
					 "email_id" => $row ["parent_email_id"],
					 "message" => $this->input->post ( 'message' )
					 );
		
					 $to = $row ["parent_email_id"];
					 $message = $this->load->view ( "_mail_templates/reminders", $mail_data, TRUE );
					 $subject = "Reminder By " . get_config_value ( "website_name" );
		
					my_send_email ( $to, $subject, $message );
				 }
				 	
				$this->session->set_flashdata ( 'success_message', "Reminder has been successfully sent to all the selected students" );
			}
			if ($this->input->post ( 'notify_by' ) == 'SMS' || $this->input->post ( 'notify_by' ) == 'BOTH') {
				
				foreach ( $data as $row ) {
					$mobile_no = $row ['parent_mobile_no'];
					//$mobile_no = "9923195945";
					

					$msg ="Dear Parent, ".$this->input->post ( 'message' )."-
The Orchid School
";
					
					send_sms ( $mobile_no, $msg );
				}
					$this->session->set_flashdata ( 'success_message', "Reminder has been successfully sent to all the selected students" );
			}
		} else {
			$this->session->set_flashdata ( 'error_message', "No students to notify." );
		}
		redirect ( base_url ( 'reminders' ) );
	}
	
	public function outstanding_reports() {
		$data ['standards'] = $this->db->query ( "SELECT * FROM standards WHERE academic_year_id = '" . $this->academic_id . "'
													ORDER BY standard_name" )->result_array ();
		$this->load->view ( 'reminders/outstanding_reports', $data );
	}
	
	public function send_outstanding_reminder() {
		
		$this->form_validation->set_rules ( 'standard_id', 'Student First Name', 'required', 
										array ( "required" => "Please select the standards" ) );
		$this->form_validation->set_rules ( 'standard_instalment_id', 'Instalment', 'required' );
		$this->form_validation->set_rules ( 'message', 'Message', 'required', 
										array ( "required" => "Please enter message for reminders" ) );
		$this->form_validation->set_rules ( 'notify_by', 'Notify By', 'required', 
										array ( "required" => "Please select how do you want to notify" ) );
		
		if ($this->form_validation->run () == FALSE) {
			
			$this->session->set_flashdata ( validation_errors () );
			$this->outstanding_reports ();
		} else {
			$notify_by = $this->input->post ( 'notify_by' );
			$instalment_id = $this->input->post ( 'standard_instalment_id' );
			$standard_id = $this->input->post("standard_id");
			
			if($standard_id == 'all' && $instalment_id == 'all'){
				// all std all inst
				$data = $this->db->query("SELECT parent_name, parent_email_id, parent_mobile_no, 
										outstanding_amount AS fees, due_date, late_fee, instalment_name 
										FROM students, invoices, standard_instalments 
										WHERE invoices.academic_year_id = '$this->academic_id' 
										AND invoices.status != 'FULLY_PAID' 
										AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
										AND invoices.student_id = students.student_id
										AND students.status = 'ACTIVE'")->result_array();

			}else if($standard_id == 'all' && $instalment_id != 'all'){
				// all std 1 inst
				$data = $this->db->query("SELECT parent_name, parent_email_id, parent_mobile_no, 
										outstanding_amount AS fees, due_date, late_fee, instalment_name 
										FROM students, invoices, standard_instalments 
										WHERE invoices.academic_year_id = '$this->academic_id' 
										AND invoices.standard_instalment_id 
											IN (SELECT standard_instalment_id FROM standard_instalments WHERE instalment_name 
												IN (SELECT instalment_name FROM standard_instalments 
												WHERE standard_instalment_id = '$instalment_id')) 
										AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
										AND invoices.status != 'FULLY_PAID' 
										AND invoices.student_id = students.student_id
										AND students.status = 'ACTIVE'")->result_array();

			}else if($standard_id != 'all' && $instalment_id == 'all'){
				// 1 std all inst
				$data = $this->db->query("SELECT parent_name, parent_email_id, parent_mobile_no, 
										outstanding_amount AS fees, due_date, late_fee, instalment_name 
										FROM students, invoices, standard_instalments 
										WHERE invoices.academic_year_id = '$this->academic_id' 
										AND invoices.status != 'FULLY_PAID' 
										AND standard_instalments.standard_id = '$standard_id' 
										AND standard_instalments.standard_instalment_id = invoices.standard_instalment_id 
										AND invoices.student_id = students.student_id
										AND students.status = 'ACTIVE'")->result_array();

			}else if($standard_id != 'all' && $instalment_id != 'all'){
				// 1 std 1 inst
				$data = $this->db->query("SELECT parent_name, parent_email_id, parent_mobile_no, 
										outstanding_amount AS fees, due_date, late_fee, instalment_name 
										FROM students, invoices, standard_instalments 
										WHERE standard_instalments.standard_instalment_id = '$instalment_id'
										AND standard_instalments.standard_instalment_id = invoices.standard_instalment_id 
										AND invoices.academic_year_id = '$this->academic_id' 
										AND invoices.status != 'FULLY_PAID' 
										AND invoices.student_id = students.student_id
										AND students.status = 'ACTIVE'")->result_array();
			}

			if (! empty ( $data )) {
				if ($notify_by == 'EMAIL' || $notify_by == 'BOTH') {
					
					foreach ( $data as $row ) {
						/* send email to parent */
						$due_date = date('d-M-Y',strtotime(swap_date_format( $row['due_date'] )));
//						$msg = "Dear parent, due date for installment: ".$row['instalment_name']." (Rs.".$row['fees'].") is ".$due_date.". For online payment goto http://goo.gl/fsxtMP , Regards - THE ORCHID SCHOOL";
						$msg = $this->input->post('message');
						$mail_data = array (
								"parent_name" => $row ["parent_name"],
								"email_id" => $row ["parent_email_id"],
								"message" => $msg 
						);
						
						$to = $row ["parent_email_id"];
						$message = $this->load->view ( "_mail_templates/reminders", $mail_data, TRUE );
						$subject = "Reminder By " . get_config_value ( "website_name" );
						
//						my_send_email ( $to, $subject, $message );
					}
					
					$this->session->set_flashdata ( 'success_message', "Reminder for outstanding payments has been successfully sent to all the selected students" );
				}
				if ($notify_by == 'SMS' || $notify_by == 'BOTH') {
					
					foreach ( $data as $row ) {
						$due_date = date('d-M-Y',strtotime(swap_date_format( $row['due_date'] ))); 
						$mobile_no = $row ['parent_mobile_no'];
//						$msg = "Dear parent, due date for installment: ".$row['instalment_name']." (Rs.".$row['fees'].") is ".$due_date.". For online payment goto http://goo.gl/fsxtMP , Regards - THE ORCHID SCHOOL";
						//$msg = $this->input->post('message');
						$msg = "Dear Parent, ".$this->input->post ( 'message' )."-
The Orchid School
";
						send_sms ( $mobile_no, $msg );
					}
					$this->session->set_flashdata ( 'success_message', "Reminder for outstanding payments has been successfully sent to all the selected students" );
				}
			} else {
				$this->session->set_flashdata ( 'error_message', "No students to notify." );
			}
			$this->outstanding_reports ();
		}
	}
	
	public function send_sms($student_id, $standard_instalment_id){
		
		$student_data = $this->db->query ("SELECT parent_mobile_no, outstanding_amount AS fees, instalment_name, due_date, late_fee 
											FROM invoices, students, standard_instalments 
											WHERE invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
											AND invoices.student_id = students.student_id
											AND invoices.standard_instalment_id = '{$standard_instalment_id}' 
											AND invoices.student_id = '{$student_id}'")->row_array();
		
		if(strlen($student_data['parent_mobile_no'])<10){
			
			$this->session->set_flashdata('error_message',"Parent Mobile number not found to send reminder sms");
			redirect(base_url('students/view/'.$student_id));
		}else{
		
			$mobile_no = $student_data['parent_mobile_no'];
			$fees = $student_data['fees'];
			$late_fee = $student_data['late_fee'];
			$due_date = date('d-M-Y',strtotime(swap_date_format( $student_data['due_date'] )));
			
			
			/*$msg = "Dear Parent, due date for installment: ".$student_data['instalment_name']." (Rs.".$fees.") is ".$due_date.". For online payment goto http://goo.gl/fsxtMP -The Orchid School";*/
			$msg = "Dear Parent, due date for installment: ".$student_data['instalment_name']." (Rs.".$fees.") is ".$due_date.". For online payment goto http://goo.gl/fsxtMP-
The Orchid School";
			
			send_sms ( $mobile_no, $msg );
			
			$this->session->set_flashdata('success_message', "Reminder SMS has been successfully sent on parent mobile no.");
			redirect(base_url('students/view/'.$student_id));
		}
	}
	
	public function outstanding_reports_download() {
		$data ['standards'] = $this->db->query ( "SELECT * FROM standards WHERE academic_year_id = '" . $this->academic_id . "'
													ORDER BY standard_name" )->result_array ();
		$this->load->view ( 'reminders/outstanding_reports_download', $data );
	}
	
	public function download_orustanding_reports(){
		
		$instalment_id = $this->input->post('standard_instalment_id');
		$standard_id = $this->input->post('standard_id');

		if($standard_id == 'all' && $instalment_id == 'all'){
			$reports_data = $this->db->query("SELECT admission_no, 
									CONCAT (student_firstname,' ',student_lastname) AS name, 
									standard_name, division_name, instalment_name, parent_name, parent_email_id, parent_mobile_no, secondary_mobile_no, invoice_amount, outstanding_amount 
									FROM students, invoices, divisions, standards, standard_instalments 
									WHERE invoices.student_id = students.student_id 
									AND invoices.status != 'FULLY_PAID' 
									AND students.division_id = divisions.division_id 
									AND divisions.standard_id = standards.standard_id 
									AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id
									AND students.status = 'ACTIVE'")->result_array();
		
		}else if($standard_id == 'all' && $instalment_id != 'all'){
			$reports_data = $this->db->query("SELECT admission_no, 
									CONCAT (student_firstname,' ',student_lastname) AS name, standard_name, division_name, instalment_name, parent_name, parent_email_id, parent_mobile_no, secondary_mobile_no, invoice_amount, outstanding_amount 
									FROM students, invoices, standards, divisions, standard_instalments 
									WHERE invoices.standard_instalment_id IN 
										(SELECT standard_instalment_id FROM standard_instalments WHERE instalment_name IN 
											(SELECT instalment_name FROM standard_instalments 
												WHERE standard_instalment_id = '$instalment_id')) 
									AND invoices.student_id = students.student_id  
									AND invoices.status != 'FULLY_PAID' 
									AND students.division_id = divisions.division_id 
									AND divisions.standard_id = standards.standard_id 
									AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id
									AND students.status = 'ACTIVE'")->result_array();

		}else if($standard_id != 'all' && $instalment_id == 'all'){
			$reports_data = $this->db->query("SELECT admission_no, 
									CONCAT (student_firstname,' ',student_lastname) AS name, 
									standard_name, division_name, instalment_name, parent_name, 
									parent_email_id, parent_mobile_no, secondary_mobile_no, 
									invoice_amount, outstanding_amount 
									FROM students, invoices, standards, divisions, standard_instalments 
									WHERE invoices.standard_instalment_id 
										IN (SELECT standard_instalment_id FROM standard_instalments 
										WHERE standard_id = '$standard_id') 
									AND invoices.student_id = students.student_id 
									AND invoices.status != 'FULLY_PAID' 
									AND students.division_id = divisions.division_id 
									AND divisions.standard_id = standards.standard_id 
									AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id
									AND students.status = 'ACTIVE'")->result_array();
		}else{
			$reports_data = $this->db->query ( "SELECT admission_no, 
									CONCAT (student_firstname,' ',student_lastname) AS name, 
									standard_name, division_name, instalment_name, parent_name, 
									parent_email_id, parent_mobile_no, secondary_mobile_no, 
									invoice_amount, outstanding_amount 
									FROM students, invoices, standards, divisions, standard_instalments 
									WHERE invoices.standard_instalment_id = '$instalment_id' 
									AND  invoices.student_id = students.student_id 
									AND invoices.status != 'FULLY_PAID' 
									AND students.division_id = divisions.division_id 
									AND divisions.standard_id = standards.standard_id 
									AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id
									AND students.status = 'ACTIVE'" )->result_array ();
		}
		$columns=array('Admission No.', 'Student Name', 'Standard', 'Division','Instalment', 'Parent Name', 'Parent Email Id', 'Parent Mobile No.', 'Secondary Mobile No.', 'Invoice Amount', 'Outstanding Amount');
		export_to_csv("outstanding_fees_report.csv",$columns,$reports_data);
	}
	
	/**
	 * *** Call back functions ***
	 */
	
	
	/**
	 * ** ajax function *****
	 */
	public function get_divisions() {
		$standard_id = $this->input->post ( 'standard_id' );
		
		if($standard_id == 'all'){
			
			$divisions = $this->db->get_where ( 'divisions', array('academic_year_id' => $this->academic_id))->result_array ();
		}else{
			$divisions = $this->db->get_where ( 'divisions', array ( 'standard_id' => $standard_id))->result_array ();
		}
		
		echo '<option value="">Select</option>';
		echo "<option value='all'>All</option>";
		foreach ( $divisions as $row ) {
			echo '<option value="' . $row ['division_id'] . '">' . $row ['division_name'] . '</option>';
		}
	}
	public function get_instalmetns() {
		$standard_id = $this->input->post ( 'standard_id' );
		
		if($standard_id != 'all'){
			$instalments = $this->db->get_where ( 'standard_instalments', array (
					'standard_id' => $standard_id 
			) )->result_array ();
		}else{
			$instalments = $this->db->query("SELECT * FROM standard_instalments 
										GROUP BY instalment_name")->result_array ();
		}
		
		echo '<option value="">Select</option>';
		echo '<option value="all">All</option>';
		foreach ( $instalments as $row ) {
			echo '<option value="' . $row ['standard_instalment_id'] . '">' . $row ['instalment_name'] . '</option>';
		}
	}
	public function get_applicable_students() {
		$division_id = $this->input->post ( 'division_id' );
		$students = $this->db->query("SELECT * FROM students WHERE division_id = '{$division_id}'
										AND status != 'INACTIVE'")->result_array();
		
		echo '<option value="">Select</option>';
		echo '<option value="all">All</option>';
		foreach ( $students as $row ) {
			echo '<option value="' . $row ['student_id'] . '">' . $row ['student_firstname'] . ' ' . $row ['student_lastname'] . '</option>';
		}
	}
	public function get_outstanding_reports() {
		$instalment_id = $this->input->post("standard_instalment_id");
		$standard_id = $this->input->post("standard_id");
		
		if($standard_id == 'all' && $instalment_id == 'all'){
			$data = $this->db->query("SELECT student_firstname, student_lastname, admission_no, 
										parent_email_id, parent_mobile_no, invoice_amount, 
										outstanding_amount FROM students, invoices
										WHERE invoices.academic_year_id = '$this->academic_id' 
										AND invoices.status != 'FULLY_PAID' 
										AND invoices.student_id = students.student_id
										AND students.status = 'ACTIVE'")->result_array();
		
		}else if($standard_id == 'all' && $instalment_id != 'all'){
			$data = $this->db->query("SELECT student_firstname, student_lastname, admission_no, 
									parent_email_id, parent_mobile_no, invoice_amount,outstanding_amount 
									FROM students, invoices 
									WHERE invoices.academic_year_id = '$this->academic_id'
									AND invoices.standard_instalment_id IN
									(SELECT standard_instalment_id FROM standard_instalments 
									WHERE instalment_name IN 
										(SELECT instalment_name FROM standard_instalments WHERE standard_instalment_id = '$instalment_id')) 
									AND invoices.student_id = students.student_id 
									AND invoices.status != 'FULLY_PAID'
									AND students.status = 'ACTIVE'")->result_array();

		}else if($standard_id != 'all' && $instalment_id == 'all'){
			$data = $this->db->query("SELECT student_firstname, student_lastname, admission_no, 
								parent_email_id, parent_mobile_no, invoice_amount,outstanding_amount 
								FROM students, invoices 
								WHERE invoices.academic_year_id = '$this->academic_id'
								AND invoices.standard_instalment_id IN
									(SELECT standard_instalment_id FROM standard_instalments WHERE standard_id = '$standard_id') 
								AND invoices.student_id = students.student_id 
								AND invoices.status != 'FULLY_PAID'
								AND students.status = 'ACTIVE'")->result_array();
		}else{
			$data = $this->db->query ( "SELECT student_firstname, student_lastname, admission_no, 
								parent_email_id, parent_mobile_no, invoice_amount, outstanding_amount 
								FROM students, invoices 
								WHERE invoices.academic_year_id = '$this->academic_id'
								AND invoices.standard_instalment_id = '$instalment_id' 
								AND  invoices.student_id = students.student_id 
								AND invoices.status != 'FULLY_PAID'
								AND students.status = 'ACTIVE'" )->result_array ();
		}

		$i = 1;
		$total_amount = 0;
		$total_outstanding = 0;
		
		if (! empty ( $data )) {
			foreach ( $data as $row ) {
			$total_amount += $row ['invoice_amount'];
			$total_outstanding += $row ['outstanding_amount'];
				//echo "total:^^^^^^^^^^^^".$row['outstanding_amount'];
				if($row['outstanding_amount']!=0)
				{			
				echo "<tr><td>" . $i ++ . "</td>";
				echo "<td>" .$row ['admission_no'] . "</td>";
				echo "<td>" . $row ['student_firstname'] ." ". $row ['student_lastname'] . "</td>";
				echo "<td>" . $row ['parent_email_id'] . "</td>";
				echo "<td>" . $row ['parent_mobile_no'] . "</td>";
				echo "<td>Rs." . $row ['invoice_amount'] . "</td>";
				echo "<td>Rs." . $row ['outstanding_amount'] . "</td></tr>";
				}

				
			}
			if($total_outstanding!=0)
				{

				
				echo "<tr> <td colspan='5' align='right'><strong><span>Total </span></strong></td>";
				echo "<td><strong>Rs." . $total_amount . "</strong></td>";
				echo "<td><strong>Rs." . $total_outstanding . "</strong></td> </tr>";
		      }
			
		} else {
			echo "<tr><td colspan='7' align='center'><span>No data to display</span></td></tr>";
		}
	}
}