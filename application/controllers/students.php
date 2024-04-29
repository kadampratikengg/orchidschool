<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Students extends CI_Controller {
	var $user_id;
	var $academic_id;
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id = $this->session->userdata ( 'user_id' );
		$this->academic_id = $this->session->userdata ( 'current_academic_year_id' );
	}
	public function index($division_id = null) {
		
		if ($division_id == null) {
			$division_id = $this->input->get ( 'division_id' );
		}
		
		if ($division_id == "") {
			$data ['student_data'] = array ();
		} else {
			$data ['student_data'] = $this->db->query ( "SELECT students.*, standard_name, division_name FROM students,standards,divisions
															WHERE divisions.division_id = students.division_id AND divisions.standard_id = standards.standard_id 
															AND students.division_id = '" . $division_id . "' 
															AND students.academic_year_id ='" . $this->academic_id . "'" )->result_array ();
		}
		
		$data ['divisions'] = $this->db->query ( "SELECT standards.standard_id, division_id, standard_name,
													division_name FROM standards, divisions
													WHERE divisions.standard_id = standards.standard_id
													AND divisions.academic_year_id ='" . $this->academic_id . "'
													ORDER BY standard_name, standards.standard_id, division_id" )->result_array ();
		$data ['division_id'] = $division_id;
		$this->load->view ( 'students/default', $data );
	}
	public function add() {

		$data ["academic_years"] = $this->db->query ( "SELECT academic_year_id, from_year, to_year FROM academic_years WHERE academic_year_id >= '".$this->academic_id."'" )->result_array ();
		$data["standards"] = $this->db->query("SELECT * FROM standards WHERE academic_year_id = '".$this->academic_id."' ORDER BY standard_name")->result_array();
		
		
		$this->load->view ( 'students/add', $data );
	}
	
	// save records
	public function save() {
		$this->form_validation->set_rules ( 'student_firstname', 'Student First Name', 'required');
		$this->form_validation->set_rules ( 'student_lastname', 'Student Last Name', 'required' );
		$this->form_validation->set_rules ( 'date_of_birth', 'Date of Birth', 'required|callback_check_birth_date' );
		$this->form_validation->set_rules ( 'gender', 'Gender', 'required' );
		$this->form_validation->set_rules ( 'blood_group', 'Blood Group', 'required' );
		
		$this->form_validation->set_rules ( 'parent_name', 'Parent Name', 'required|alpha_numeric_spaces' );
		$this->form_validation->set_rules ( 'notification_preference', 'Notification Preference', 'required' );
		$this->form_validation->set_rules ( 'parent_email_id', 'Parent Email ID', 'required|valid_email' );
		$this->form_validation->set_rules ( 'parent_contact_no', 'Parent Contact Number', 'required|numeric|exact_length[10]' );
		
		$this->form_validation->set_rules ( 'rte_provision', 'Provision For RTE', 'required' );
		$this->form_validation->set_rules ( 'admission_number', 'Admission Number', 'required|is_unique[students.admission_no]' );
		$this->form_validation->set_rules ( 'staff_discount', 'Staff Discount', 'required|numeric' );
		$this->form_validation->set_rules ( 'academic_year_id', 'Current Academic Year', 'required' );
		$this->form_validation->set_rules ( 'admission_year', 'Admission Year', 'required|numeric' );
		$this->form_validation->set_rules ( 'current_standard', 'Current Standard', 'required' );
		$this->form_validation->set_rules ( 'division_id', 'Current Division', 'required' );
		
		$this->form_validation->set_rules ( 'address', 'Address Line', 'required' );
		$this->form_validation->set_rules ( 'pincode', 'Pincode', 'required|numeric|exact_length[6]' );
		$this->form_validation->set_rules ( 'city', 'City', 'required|alpha' );
		$this->form_validation->set_rules ( 'state', 'State', 'required|alpha' );
		
		if ($this->form_validation->run () == FALSE) {
			$this->add ();
		} else {
			
			$division_data = $this->db->query ( "SELECT count(students.division_id) AS record_cnt, intake FROM students, divisions
													WHERE students.division_id = divisions.division_id
													AND students.division_id = '" . $this->input->post ( 'division_id' ) . "'" )->row_array ();
			
			$intake_limit = $division_data ['intake'] - $division_data ['record_cnt'];
			
			if ($intake_limit > 0) {
				
				if ($this->input->post ( 'rte_provision' ) == 'YES') {
					$status = "RTE";
				} else {
					$status = "ACTIVE";
				}
				$insert_data = array (
						"division_id" => $this->input->post ( "division_id" ),
						"academic_year_id" => $this->input->post ( "academic_year_id" ),
						"admission_no" => $this->input->post ( "admission_number" ),
						"student_firstname" => $this->input->post ( "student_firstname" ),
						"student_lastname" => $this->input->post ( "student_lastname" ),
						"gender" => $this->input->post ( "gender" ),
						"date_of_birth" => swap_date_format ( $this->input->post ( "date_of_birth" ) ),
						"blood_group" => $this->input->post ( "blood_group" ),
						"address" => $this->input->post ( "address" ),
						"city" => $this->input->post ( "city" ),
						"state" => $this->input->post ( "state" ),
						"pincode" => $this->input->post ( "pincode" ),
						"admission_year" => $this->input->post ( "admission_year" ),
						"parent_name" => $this->input->post ( "parent_name" ),
						"parent_email_id" => $this->input->post ( "parent_email_id" ),
						"secondary_email_id" => $this->input->post ( "secondary_email_id" ),
						"parent_mobile_no" => $this->input->post ( "parent_contact_no" ),
						"secondary_mobile_no" => $this->input->post ( "secondary_contact_no" ),
						"staff_discount" => $this->input->post ( "staff_discount" ),
						"notification" => $this->input->post ( "notification_preference" ),
						"rte_provision" => $this->input->post ( "rte_provision" ),
						"status" => "ACTIVE",
						"entry_by" => $this->user_id 
				);
				
				//$this->db->trans_start ();
				
				$this->db->insert ( 'students', $insert_data );
				$student_id = $this->db->insert_id ();
				
				$insert_data = array (
						"student_id" => $student_id,
						"academic_year_id" => $this->input->post ( "academic_year_id" ),
						"division_id" => $this->input->post ( "division_id" ),
						"entry_by" => $this->user_id 
				);
				
				$this->db->insert ( 'student_academic_years', $insert_data );
				
				if ($status != "RTE") {
					
					$password = random_string ( 'numeric', 4 );
					
					$insert_data = array (
							"student_id" => $student_id,
							"email_id" => $this->input->post ( "parent_email_id" ),
							"password" => md5 ( $password ),
							"account_type" => "STUDENT",
							"entry_by" => $this->user_id 
					);
					
					$this->db->insert ( 'users', $insert_data );
					
					//$this->db->trans_complete (); // Completing transaction
					
					/* send email to parents */
					$mail_data = array (
							"parent_name" => $this->input->post ( "parent_name" ),
							"email_id" => $this->input->post ( "parent_email_id" ),
							"password" => $password 
					);
					
					$to = $this->input->post ( 'parent_email_id' );
					$message = $this->load->view ( "_mail_templates/parent_credentials", $mail_data, TRUE );
					$subject = get_config_value ( "website_name" ) . " Login Credentials";
					
					my_send_email ( $to, $subject, $message );
				} else {
					//$this->db->trans_complete (); // Completing transaction
				}
				
				/*if ($this->db->trans_status () === FALSE) {
					$this->db->trans_rollback ();
					$this->session->set_flashdata ( 'error_message', "Failed to add record" );
				} else {
					$this->db->trans_commit ();
					$this->session->set_flashdata ( 'success_message', "Record saved successfully" );
				}*/
				
				$this->session->set_flashdata ( 'success_message', "Record saved successfully" );
			} else {
				
				$this->session->set_flashdata ( 'error_message', "Division intake capacity is full, Increase division intake capacity or add new division" );
			}
			
			/* redirect */
			redirect ( base_url ( 'students' ) );
		}
	}
	public function view($student_id) {
		$data ['student_data'] = $this->db->query ( "SELECT standard_name, division_name, students.*, academic_years.*, SUM(invoice_amount) AS total_fees, SUM(discount_amount) AS total_discount, 
													SUM(paid_amount) AS total_paid, SUM(outstanding_amount) AS total_outstanding 
													FROM students, academic_years, standards, divisions, invoices 
													WHERE students.student_id = '" . $student_id . "' AND students.academic_year_id = academic_years.academic_year_id 
													AND students.division_id = divisions.division_id AND divisions.standard_id = standards.standard_id
													AND students.student_id = invoices.student_id 
													AND invoices.academic_year_id = '".$this->academic_id."'")->row_array();
		
		$data ['instalments'] = $this->db->query ( "SELECT invoices.invoice_id, payment_id, instalment_name, invoice_amount, total_paid_amount, 
													discount_amount, late_fee_amount, payment_date, start_date, due_date, invoices.student_id, 
													standard_instalments.standard_instalment_id, invoices.status, payments.status
													FROM invoices LEFT JOIN payments ON (payments.invoice_id = invoices.invoice_id AND payments.status = 'PAYMENT-RECEIVED') 
													LEFT JOIN standard_instalments ON invoices.standard_instalment_id =  standard_instalments.standard_instalment_id
													WHERE invoices.student_id = '{$student_id}'
													AND invoices.academic_year_id = '{$this->academic_id}'" )->result_array ();

		$this->load->view ( 'students/view', $data );
	}
	public function edit($student_id) {

		$data ['student_data'] = $this->db->get_where ( 'students', array ( 'student_id' => $student_id ) )->row_array ();
		
		$data ['student_data'] = $this->db->query ( "SELECT standard_id, students.* FROM students, divisions
														WHERE student_id = '{$student_id}' 
														AND students.division_id = divisions.division_id" )->row_array ();
		
		$data ['current_standard'] = $this->db->query ( "SELECT standard_id FROM divisions WHERE division_id = '" . $data ['student_data'] ['division_id'] . "'" )->row_array ();
		
		$data ['academic_years'] = $this->db->query ( "SELECT academic_year_id, from_year, to_year FROM academic_years WHERE academic_year_id >= '".$this->academic_id."'" )->result_array ();
		
		$data ['standards'] = $this->db->get_where ( 'standards' , array("academic_year_id" => $this->academic_id))->result_array ();
		
		$this->load->view ( 'students/edit', $data );
	}
	public function update($student_id) {
		$this->form_validation->set_rules ( 'student_firstname', 'Student First Name', 'required' );
		$this->form_validation->set_rules ( 'student_lastname', 'Student Last Name', 'required' );
		$this->form_validation->set_rules ( 'date_of_birth', 'Date of Birth', 'required' );
		$this->form_validation->set_rules ( 'gender', 'Gender', 'required' );
		$this->form_validation->set_rules ( 'blood_group', 'Blood Group', 'required' );
		
		$this->form_validation->set_rules ( 'parent_name', 'Parent Name', 'required|alpha_numeric_spaces' );
		$this->form_validation->set_rules ( 'notification_preference', 'Notification Preference', 'required' );
		$this->form_validation->set_rules ( 'parent_email_id', 'Parent Email ID', 'required|valid_email' );
		$this->form_validation->set_rules ( 'parent_contact_no', 'Parent Contact Number', 'required|numeric|exact_length[10]' );
		
		$this->form_validation->set_rules ( 'rte_provision', 'Provision For RTE', 'required' );
		$this->form_validation->set_rules ( 'staff_discount', 'Staff Discount', 'required|numeric' );
		$this->form_validation->set_rules ( 'academic_year_id', 'Current Academic Year', 'required' );
		$this->form_validation->set_rules ( 'admission_year', 'Admission Year', 'required' );
		$this->form_validation->set_rules ( 'standard_id', 'Current Standard', 'required' );
		$this->form_validation->set_rules ( 'division_id', 'Current Division', 'required' );
		
		$this->form_validation->set_rules ( 'address', 'Address Line', 'required' );
		$this->form_validation->set_rules ( 'pincode', 'Pincode', 'required|numeric|exact_length[6]' );
		$this->form_validation->set_rules ( 'city', 'City', 'required|alpha' );
		$this->form_validation->set_rules ( 'state', 'State', 'required|alpha' );
		
		if ($this->form_validation->run () == FALSE) {
			
			$this->edit ( $student_id );
		} else {
			
			$update_data = array (
					"email_id" => $this->input->post ( "parent_email_id" ) 
			);
			
			$this->db->update ( 'users', $update_data, array (
					'student_id' => $student_id 
			) );
			
			if ($this->input->post ( 'rte_provision' ) == 'yes') {
				
				$rte = 'YES';
				
			} else {
				$rte = 'NO';
			}
			
			$update_data = array (
					"division_id" => $this->input->post ( "division_id" ),
					"academic_year_id" => $this->input->post ( "academic_year_id" ),
					"student_firstname" => $this->input->post ( "student_firstname" ),
					"student_lastname" => $this->input->post ( "student_lastname" ),
					"gender" => $this->input->post ( "gender" ),
					"date_of_birth" => swap_date_format ( $this->input->post ( "date_of_birth" ) ),
					"blood_group" => $this->input->post ( "blood_group" ),
					"address" => $this->input->post ( "address" ),
					"city" => $this->input->post ( "city" ),
					"state" => $this->input->post ( "state" ),
					"pincode" => $this->input->post ( "pincode" ),
					"admission_year" => $this->input->post ( "admission_year" ),
					"parent_name" => $this->input->post ( "parent_name" ),
					"parent_email_id" => $this->input->post ( "parent_email_id" ),
					"secondary_email_id" => $this->input->post ( "secondary_email_id" ),
					"parent_mobile_no" => $this->input->post ( "parent_contact_no" ),
					"secondary_mobile_no" => $this->input->post ( "secondary_contact_no" ),
					"staff_discount" => $this->input->post ( "staff_discount" ),
					"notification" => $this->input->post ( "notification_preference" ),
					"rte_provision" => $rte,
					
					"entry_by" => $this->user_id 
			);
			
			$this->db->update ( 'students', $update_data, array (
					'student_id' => $student_id 
			) );
			
			if ($this->db->affected_rows () > 0) {
				$this->session->set_flashdata ( 'success_message', "Record updated successfully" );
				redirect ( base_url ( 'students' ) );
			} else {
				$this->session->set_flashdata ( 'error_message', "Failed to update record" );
				redirect ( base_url ( 'students' ) );
			}
		}
	}
	public function delete($student_id, $division_id) {
		$payment_count = $this->db->query ( "SELECT count(*) AS count FROM payments 
											WHERE student_id = '" . $student_id . "'" )->row_array ();
		
		if ($payment_count ['count'] > 0) {
			
			$this->session->set_flashdata('error_message', "Cannot delete student, Payment already made for this student, you can withdraw student's admission");
		}else{
			
			//$this->db->trans_start ();
			
				$this->db->delete ( 'users', array ( 'student_id' => $student_id ) );
				$this->db->delete ( 'invoices', array ( 'student_id' => $student_id ) );
				$this->db->delete ( 'students', array ( 'student_id' => $student_id ) );
			
			//$this->db->trans_complete (); // Completing transaction
			
			/*if ($this->db->trans_status () === FALSE) {
				$this->db->trans_rollback ();
				$this->session->set_flashdata ( 'error_message', "Failed to delete record" );
			} else {
				$this->db->trans_commit ();
				$this->session->set_flashdata ( 'success_message', "Record deleted successfully" );
			}*/
				
				$this->session->set_flashdata ( 'success_message', "Record deleted successfully" );
		}
		redirect ( base_url ( 'students/index' ) . '/' . $division_id );
	}

	public function delete_invoice($student_id, $invoice_id){
		
		$this->db->query("DELETE FROM payments WHERE invoice_id = '$invoice_id' 
							AND status != 'PAYMENT-RECEIVED'");
		
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('invoices');	
		
		$this->view($student_id);
	}
	public function download_sample_excel() {
		$path = file_get_contents ( base_url () . "downloads/sample_student_excel_format.xlsx" );
		$name = "sample_student_excel_format.xlsx";
		force_download ( $name, $path );
		
		redirect ( base_url ( 'students/bulkupload' ) );
	}
	public function bulkupload() {
		$data ["academic_years"] = $this->db->query ( "SELECT academic_year_id, from_year, to_year FROM academic_years
														WHERE academic_year_id >= '".$this->academic_id."'" )->result_array ();
		
		$data["standards"] = $this->db->query("SELECT * FROM standards WHERE academic_year_id = '".$this->academic_id."' ORDER BY standard_name")->result_array();
		
		$this->load->view ( 'students/bulkupload', $data );
	}
	public function save_bulkupload() {
		$this->form_validation->set_rules ( 'academic_year', 'Academic Year', 'required',
											array("required" => "Academic Year is required"));
		$this->form_validation->set_rules ( 'standard', 'Standard', 'required',
											array("required" => "Standard is required"));
		$this->form_validation->set_rules ( 'division_id', 'Division', 'required',
											array("required" => "Division is required"));
		
		if ($_FILES ["student_excel"] ["name"] == "") {
			$this->form_validation->set_rules ( "student_excel", "Bulk upload file", "required",
												array("required" => "EXCEL file is reuiqred to upload"));
		}
		
		/* upload config */
		$config ['upload_path'] = './uploads/temp_files/';
		$config ['allowed_types'] = 'xlsx|xls';
		$config ['max_size'] = 2048;
		$config ['file_name'] = uniqid ( "student_bulk_" );
		$this->upload->initialize ( $config );
		
		if ($this->form_validation->run () == FALSE || $this->upload->do_upload ( 'student_excel' ) == FALSE) {
			
			$this->bulkupload ();
		} else {
			
			$upload_data = $this->upload->data ();
			$uploaded_file_name = $upload_data ['file_name'];
			
			$academic_year_id = $this->input->post ( 'academic_year' );
			$division_id = $this->input->post ( 'division_id' );
			
			$this->db->select ( 'standard_id, standard_name' );
			$query = $this->db->get ( 'standards' );
			$standard_details = $query->result_array ();
			
			$this->load->library ( 'Simpleexcel' );
			
			$excel_data = $this->simpleexcel->read_excel ( "uploads/temp_files/" . $uploaded_file_name );
			
			$division_data = $this->db->query ( "SELECT count(students.division_id) AS record_cnt, intake FROM students, divisions 
													WHERE students.division_id = divisions.division_id
													AND students.division_id = '" . $division_id . "'" )->row_array ();
			
			$intake_limit = $division_data ['intake'] - $division_data ['record_cnt'];
			
			if ($intake_limit >= count ( $excel_data ) - 1) {
				
				$num_cols = count ( $excel_data [0] );
				
				$f = 0;
				if ($num_cols == 15) {
					
					$save_record_cnt = 1;
					foreach ( $excel_data as $r ) {
						
						// Ignore the inital name row of excel file
						if ($f == 0) {
							$f ++;
							continue;
						}
						$student_name = explode ( " ", $r [1] );
						
						$data = array(
								"division_id"=>$division_id,
								"academic_year_id"=>$academic_year_id,
								"admission_no"=> $r[0],
								"student_firstname" => $student_name [0],
								"student_lastname" => $student_name [1],
								"gender" => $r[2],
								"date_of_birth" => date ( "Y/m/d", strtotime ( $r [3] )),
								"blood_group" => $r [4],
								"address" => $r [5],
								"city" => $r [6],
								"state" => $r [7],
								"pincode" => $r [8],
								"admission_year" => $r [9],
								"parent_name" => $r [10],
								"parent_email_id" => $r [11],
								"secondary_email_id" => $r [13],
								"notification" => "BOTH",
								"status" => "ACTIVE",
								"entry_by" => $this->user_id
						);
						
						if (strlen ( $r [12] ) > 10) {
							$data ['parent_mobile_no'] = substr ( $r [12], 2, 11 );
						} else {
							$data ['parent_mobile_no'] = $r [12];
						}
						if (strlen ( $r [14] ) > 10) {
							$data ['secondary_mobile_no'] = substr ( $r [14], 2, 11 );
						} else {
							$data ['secondary_mobile_no'] = $r [14];
						}

						//$this->db->trans_start ();
						
						$this->db->insert ( 'students', $data );
						
						$save_record_cnt ++;
						$student_id = $this->db->insert_id ();
						$password = random_string ( 'numeric', 4 );
						
						$insert_data = array (
								'student_id' => $student_id,
								'academic_year_id' => $academic_year_id,
								'division_id' => $division_id,
								"entry_by" => $this->user_id 
						);
						$this->db->insert ( 'student_academic_years', $insert_data );
						
						$insert_data = array (
								"student_id" => $student_id,
								"email_id" => $data ["parent_email_id"],
								"password" => md5 ( $password ),
								"account_type" => "STUDENT",
								"entry_by" => $this->user_id 
						);
						
						$this->db->insert ( 'users', $insert_data );
						
						//$this->db->trans_complete (); // Completing transaction
						
						/*if ($this->db->trans_status () === FALSE) {
							$this->db->trans_rollback ();
							$this->session->set_flashdata ( 'error_message', "Failed to save all records" );
							
							redirect ( base_url ( 'students' ) );
						} else {
							$this->db->trans_commit ();
							$this->session->set_flashdata ( 'success_message', "All records saved successfully" );
						}*/
						
						$this->session->set_flashdata ( 'success_message', "All records saved successfully" );
						/* send email to parent */
						/* $mail_data = array (
								"parent_name" => $data ["parent_name"],
								"email_id" => $data ["parent_email_id"],
								"password" => $password 
						);
						
						$to = $data ["parent_email_id"];
						$message = $this->load->view ( "_mail_templates/parent_credentials", $mail_data, TRUE );
						$subject = get_config_value ( "website_name" ) . " Login Credentials";
						
						my_send_email ( $to, $subject, $message ); */
					}
					
					if ($save_record_cnt == count ( $excel_data )) {
						
						$this->session->set_flashdata ( 'success_message', "All records saved successfully" );
						redirect ( base_url ( 'students' ) );
					} else {
						
						$this->session->set_flashdata ( 'error_message', "Failed to save all records" );
						redirect ( base_url ( 'students' ) );
					}
				} else {
					
					$this->session->set_flashdata ( 'error_message', "Invalid uplaoded excel file, Please check Sample Excel Format" );
					redirect ( base_url ( 'students/bulkupload' ) );
				}
			} else {
				
				$this->session->set_flashdata ( 'error_message', "Division intake capacity is full, Increase division intake capacity or add new division " );
				redirect ( base_url ( 'students' ) );
			}
		}
	}
	public function academic_transfer() {
		
		$data ["academic_years"] = $this->db->query ( 'SELECT academic_year_id, from_year, to_year 
											FROM academic_years ORDER BY from_year' )->result_array ();
		$this->load->view ( 'students/academic_transfer', $data );
	}

	public function change_academic_year() {
		
		
		$this->form_validation->set_rules ( 'current_academic_year_id', 'Current Academic Year', 'required' );
		$this->form_validation->set_rules ( 'current_division_id', 'Current Division', 'required' );
		$this->form_validation->set_rules ( 'new_academic_year_id', 'New Academic Year', 'required' );
		$this->form_validation->set_rules ( 'new_division_id', 'New Division', 'required' );
		
		if ($this->form_validation->run () == FALSE) {
			
			$this->academic_transfer ();
		} else {
			
			$current_division_id = $this->input->post ( "current_division_id" );
			$new_division_id = $this->input->post ( "new_division_id" );
			
			$update_data = array (
					"division_id" => $this->input->post ( "new_division_id" ),
					"academic_year_id" => $this->input->post ( "new_academic_year_id" ) 
			);
			$this->db->update ( 'students', $update_data, array (
					'division_id' => $current_division_id 
			) );
			
			$students_data = $this->db->query ( "SELECT student_id, academic_year_id, division_id FROM students
					WHERE division_id = '" . $new_division_id . "'" )->result_array ();
			
			$insert_data = [ ];
			foreach ( $students_data as $row ) {
				
				$row ["entry_by"] = $this->user_id;
				$insert_data [] = $row;
			}
			
			$this->db->insert_batch ( 'student_academic_years', $insert_data );
			$this->session->set_flashdata ( 'success_message', "Successfully transfered the students." );
			
			redirect ( base_url ( "students" ) );
		}
	}
	public function download_challan($student_id, $standard_instalment_id) {
		$data ['student_data'] = $this->db->query ( "SELECT students.*, division_name, standard_prefix, standard_name, standard_instalments.*, from_year, to_year 
															FROM students, divisions, standards, standard_instalments, academic_years 
															WHERE student_id = '" . $student_id . "' AND students.division_id = divisions.division_id 
															AND divisions.standard_id = standards.standard_id AND standard_instalments.standard_instalment_id = '" . $standard_instalment_id . "' 
															AND students.academic_year_id = academic_years.academic_year_id" )->row_array ();
		
		$data ['instalment_particulars'] = $this->db->query ( "SELECT description, amount, sequence_no FROM instalment_particulars
    															WHERE standard_instalment_id = '" . $standard_instalment_id . "'" )->result_array ();
		
		$data ['config_data'] = $this->db->query ( "SELECT * FROM config WHERE 1" )->result_array ();
		
		$bank_challan = $this->load->view ( "_pdf_tamplates/challan", $data, TRUE );
		
		generate_pdf ( $bank_challan, "challan.pdf", "landscape" );
		
	}
	public function withdraw_admission($student_id, $status, $division_id) {
		$data ['student_id'] = $student_id;
		$data ['status'] = $status;
		$data ['division_id'] = $division_id;
		
		$this->load->view ( 'students/withdraw_admission', $data );
	}
	public function change_status_inactive() {
		$this->form_validation->set_rules ( 'withdraw_reason', 'Withdraw Reason', 'required' );
		$this->form_validation->set_rules ( 'withdraw_date', 'Withdraw Date', 'required' );
		
		$student_id = $this->input->post ( 'student_id' );
		$status = $this->input->post ( 'status' );
		$division_id = $this->input->post ( 'division_id' );
		
		if ($this->form_validation->run () == FALSE) {
			
			$this->withdraw_admission ( $student_id, $status, $division_id );
		} else {
			
			$withdraw_reason = $this->input->post ( 'withdraw_reason' );
			$withdraw_date = $this->input->post ( 'withdraw_date' );
			
			$this->db->update ( 'users', array ('status' => 'inactive'), array ('student_id' => $student_id) );
			$this->db->update ( 'students', array ('status' => 'inactive' ), array ( 'student_id' => $student_id ) );
			
			$update_data = array (
					"withdraw_reason" => $withdraw_reason,
					"withdraw_date" => swap_date_format ( $withdraw_date ) 
			);
			
			$this->db->update ( 'students', $update_data, array ('student_id' => $student_id ) );
			
			$this->db->query("DELETE FROM invoices WHERE student_id = '{$student_id}' 
								AND status != 'FULLY_PAID'");
			
			$message = "Record updated successfully";
			$this->session->set_flashdata ( 'success_message', $message );
			redirect ( base_url ( 'students/index' ) . '/' . $division_id );
		}
	}
	public function change_status_active($student_id, $status, $division_id) {
		$this->db->update ( 'users', array (
				'status' => 'active' 
		), array (
				'student_id' => $student_id 
		) );
		$this->db->update ( 'students', array (
				'status' => 'active' 
		), array (
				'student_id' => $student_id 
		) );
		
		$update_data = array (
				"withdraw_reason" => null,
				"withdraw_date" => null 
		);
		
		$this->db->update ( 'students', $update_data, array (
				'student_id' => $student_id 
		) );
		
		$message = "Record updated successfully";
		$this->session->set_flashdata ( 'success_message', $message );
		redirect ( base_url ( 'students/index' ) . '/' . $division_id );
	}
	public function download_receipt($payment_id) {
		$data ['payment_data'] = $this->db->query ( "SELECT students.*, standard_name, payments.*, discount_amount,division_name, instalment_name 
														FROM students, standards, payments, standard_instalments, divisions, invoices  
														WHERE payment_id = '" . $payment_id . "'AND payments.student_id = students.student_id 
														AND payments.invoice_id = invoices.invoice_id AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id
														AND standard_instalments.standard_id = standards.standard_id
														AND divisions.division_id = students.division_id" )->row_array ();
		
		$data ['instalment_particulars'] = $this->db->query ( "SELECT * FROM instalment_particulars WHERE standard_instalment_id
																IN (SELECT standard_instalment_id FROM invoices
																WHERE invoice_id = '" . $data ['payment_data'] ['invoice_id'] . "')" )->result_array ();
		
		$bank_challan = $this->load->view ( '_pdf_tamplates/payment_receipt', $data, TRUE );
		
		generate_pdf ( $bank_challan, "payment_receipt.pdf" );
	}
	
	function reset_password($student_id) {
		$data ['student_id'] = $student_id;
		$response ['title'] = "Reset Password";
		$response ['body'] = $this->load->view ( 'students/reset_password', $data, true );
		echo json_encode ( $response );
	}
	function save_password() {
		$this->form_validation->set_rules ( 'new_password', 'New Password', 'required|min_length[6]' );
		$this->form_validation->set_rules ( 'confirm_password', 'Confirm New Password', 'required|matches[new_password]' );
		
		$student_id = $this->input->post ( "student_id" );
		
		if ($this->form_validation->run () == FALSE) {
			
			$response ['status'] = "error";
			
			if (validation_errors () != "") {
				
				$response ['message'] = validation_errors ();
			} elseif ($this->session->flashdata ( "error_message" ) != "") {
				
				$response ['message'] = $this->session->flashdata ( "error_message" );
			}
		} else {
			
			$update_data = array (
					"password" => md5 ( $this->input->post ( "new_password" ) ) 
			);
			
			$this->db->update ( 'users', $update_data, array (
					'student_id' => $student_id 
			) );
			
			$response ['status'] = "success";
			$response ['message'] = "Password Changed Successfully";
		}
		
		echo json_encode ( $response );
	}
	function academic_transfer_insividual($student_id) {
		$data ["student_id"] = $student_id;
		$data ["academic_years_data"] = $this->db->query ( "SELECT * FROM academic_years
				WHERE from_year > (SELECT from_year FROM academic_years WHERE academic_year_id = '" . $this->academic_id . "')" )->result_array ();
		$response ['title'] = "Students Academic Year Transfer";
		$response ['body'] = $this->load->view ( 'students/academic_transfer_individual', $data, true );
		echo json_encode ( $response );
	}
	
	function change_academic_individual() {
		
		$this->form_validation->set_rules ( 'new_academic_year_id', 'New Academic Year', 'required' );
		$this->form_validation->set_rules ( 'new_division_id', 'New Division', 'required' );
		
		if ($this->form_validation->run () == FALSE) {
			
			$response ['status'] = "error";
			
			if (validation_errors () != "") {
				
				$response ['message'] = validation_errors ();
			} elseif ($this->session->flashdata ( "error_message" ) != "") {
				
				$response ['message'] = $this->session->flashdata ( "error_message" );
			}
		} else {
			
			$new_academic_year_id = $this->input->post ( "new_academic_year_id" );
			$new_division_id = $this->input->post ( "new_division_id" );
			$student_id = $this->input->post('student_id');
			
			$update_data = array (
					"division_id" => $new_division_id,
					"academic_year_id" => $new_academic_year_id );
			
 			$this->db->update ( 'students', $update_data, array ( 'student_id' => $student_id ) );
				
			$insert_data = array(
					"student_id"=> $student_id, 
					"academic_year_id"=> $new_academic_year_id,
					"division_id"=> $new_division_id,
					"entry_by"=> $this->user_id);

			$this->db->insert ( 'student_academic_years', $insert_data );
			
			$response ['status'] = "success";
			$response ['message'] = "Successfully transfered the students.";
		}
		echo json_encode ( $response );
	}
	
	/**
	 * *** Call back functions ***
	 */
	function check_birth_date($birth_date) {
		$current_date = new DateTime ( date ( "Y-m-d" ) );
		$birth_date = new DateTime ( swap_date_format ( $birth_date ) );
		
		if ($birth_date > $current_date) {
			
			$this->form_validation->set_message ( 'check_birth_date', 'Invalid Birth Date' );
			return false;
		}
	}
	
	/**
	 * ** ajax function *****
	 */
	public function get_class_divisions() {
		$standard_id = $this->input->get ( 'standard_id' );
		$division_id = $this->input->get ( 'division_id' );
		
		$divisions = $this->db->get_where ( 'divisions', array (
				'standard_id' => $standard_id 
		) )->result_array ();
		
		echo '<option value="">Select</option>';
		foreach ( $divisions as $row ) {
			echo '<option value="' . $row ['division_id'] . '"'.set_select("division_id",$row['division_id'],
					$row['division_id']==$division_id?true:'').'>' . $row ['division_name'] . '</option>';
		}
	}
	function get_years_standards_divisions() {
		$current_year_id = $this->input->post ( 'current_year_id' );
		$divisions = $this->db->query ( "select standards.standard_id, division_id, standard_name,
								division_name from standards, divisions
								where divisions.standard_id = standards.standard_id
								AND divisions.academic_year_id ='" . $current_year_id . "'
								order by standards.standard_id, division_id" )->result_array ();
		
		$years = $this->db->query ( "SELECT * FROM academic_years
				WHERE from_year > (SELECT from_year FROM academic_years WHERE academic_year_id = '" . $current_year_id . "')" )->result_array ();
		
		$division_data = "<option value=''>Select</option>";
		foreach ( $divisions as $row ) {
			$division_data .= "<option value='" . $row ['division_id'] . "' > " . $row ['standard_name'] . " - " . $row ['division_name'] . " </option>";
		}
		
		$year_data = "<option value=''>Please Create new academic year first</option>";
		if (! empty ( $years )) {
			
			$year_data = "<option value=''>Select</option>";
			foreach ( $years as $row ) {
				$year_data .= "<option value='" . $row ['academic_year_id'] . "'> " . $row ['from_year'] . " - " . $row ['to_year'] . " </option>";
			}
		}
		
		$response ["divisions"] = $division_data;
		$response ["years"] = $year_data;
		
		echo json_encode ( $response );
	}
	function get_standards_divisions() {
		$new_year_id = $this->input->post ( 'new_year_id' );
		$divisions = $this->db->query ( "select standards.standard_id, division_id, standard_name,
								division_name from standards, divisions
								where divisions.standard_id = standards.standard_id
								AND divisions.academic_year_id ='" . $new_year_id . "'
								order by standards.standard_id, division_id" )->result_array ();
		$response = "<option value=''>Please Create new divisions first</option>";
		if (! empty ( $divisions )) {
			
			$response = "<option value=''>Select</option>";
			foreach ( $divisions as $row ) {
				$response .= "<option value='" . $row ['division_id'] . "' " . set_select ( 'division_id', $row ['division_id'] ) . "> " . $row ['standard_name'] . " - " . $row ['division_name'] . " </option>";
			}
		}
		
		echo json_encode ( $response );
	}


	function update_admission_no() {
		
		$old_admission_no = $this->input->post('old_admission_no');
		$new_admission_no = $this->input->post('new_admission_no');
				//echo $new_admission_no;
		//$query=$this->db->query ("select * from students where admission_no='" . $new_admission_no . "'");


		$query = $this->db->get_where('students', array('admission_no'=>$new_admission_no));

           
          if($query->num_rows())
          {

          	$response ['status'] = "error";
			$response ['message'] = "Admission Number Already Exists";
          }
          else
          {

		        if($this->db->update ( 'students', array('admission_no'=>$new_admission_no), array ( 'admission_no' => $old_admission_no))){
					$response ['admission_no'] = $new_admission_no;
					$response ['status'] = "success";
					$response ['message'] = "Admission no updated successfully.";
				}else{
					$response ['status'] = "error";
					$response ['message'] = "Unable to update admission no.";
				}

          }

		
		
		echo json_encode ( $response );
		
		
	}
}