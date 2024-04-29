<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Academic_fees extends CI_Controller {
	
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
			
			$data ['academic_fees_data'] = array ();
		} else {
			
			$data ['academic_fees_data'] = $this->db->query ( "SELECT student_firstname, student_lastname, invoices.*, instalment_name FROM invoices, students, student_academic_years, standard_instalments 
																WHERE student_academic_years.division_id = '$division_id' 
																AND student_academic_years.student_id = invoices.student_id 
																AND invoices.academic_year_id = '".$this->academic_id."'
																AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
																AND invoices.student_id = students.student_id ORDER BY invoices.invoice_id")->result_array ();
		}
		
		$data ['divisions'] = $this->db->query ( "SELECT standards.standard_id, division_id, standard_name,
													division_name FROM standards, divisions
													WHERE divisions.standard_id = standards.standard_id
													AND divisions.academic_year_id ='" . $this->academic_id . "'
													ORDER BY standard_name, standards.standard_id, division_id" )->result_array ();
		$data ['division_id'] = $division_id;
		$this->load->view ( 'academic_fees/default', $data );
	}
	public function add() {
		$data['standards'] = $this->db->get_where ( 'standards', array ('academic_year_id' => $this->academic_id))->result_array ();
		
		$this->load->view ( 'academic_fees/add', $data );
	}
	public function save() {
		
		$this->form_validation->set_rules ( 'standard_id', 'Standard', 'required',
											array("required" => "Standard is required"));
		$this->form_validation->set_rules ( 'division_id', 'Division', 'required',
											array("required" => "Division is required"));
		$this->form_validation->set_rules ( 'applicable_student_id', 'Applicable Students', 'required',
											array("required" => "Select Applicable Students"));
		$this->form_validation->set_rules ( 'apply_staff_discount', 'Staff Discount', 'required' );
		$this->form_validation->set_rules ( 'fees_description', 'Fees Description', 'required',
											array("required" => "Fees Description is required"));
		$this->form_validation->set_rules ( 'invoice_date', 'Invoice Date', 'required',
											array("required" => "Invoice Date is required"));
		
		$standard_id = $this->input->post ( "standard_id" );
		$division_id = $this->input->post ( "division_id" );
		$applicable_student_id = $this->input->post ( "applicable_student_id" );
		$apply_staff_discount = $this->input->post ( "apply_staff_discount" );
		$fees_description = $this->input->post ( "fees_description" );
		$invoice_date = $this->input->post ( "invoice_date" );
		$total_fees = $this->input->post ( "total_fees" );
		
		if ($this->form_validation->run () == FALSE) {
			$this->add ();
		} else {
			
			if ($applicable_student_id == "all") {
				
				$students = $this->db->query ( "SELECT student_id,staff_discount FROM students, divisions
	    											WHERE students.academic_year_id  = '".$this->academic_id."'
													AND rte_provision = 'NO'
													AND students.division_id  = divisions.division_id
	    											AND divisions.division_id = '".$division_id."'" )->result_array ();
				
				$invoices = $this->db->query ( "SELECT count(*) as count FROM invoices
	    											WHERE academic_year_id  = " . $this->academic_id ."
													AND invoice_type ='TUITION-FEE' 
													AND student_id IN (SELECT student_id FROM students, divisions
	    											WHERE students.academic_year_id  = " . $this->academic_id ." 
													AND students.division_id  = divisions.division_id
	    											AND divisions.division_id =" . $division_id.") " )->row_array ();

				$instalment_data = $this->db->query("SELECT * FROM standard_instalments
															WHERE standard_id = '".$standard_id."'")->result_array();

				if(count($instalment_data)==0){
				$this->session->set_flashdata ( 'error_message', "Failed!, Fees can not be applied as Instalments are not defined for selected Standard" );
					redirect ( base_url ( 'academic_fees' ) );
				}
				if($invoices['count']>0){
					$this->session->set_flashdata ( 'error_message', "Failed!, Fees can not be applied as it is already applied to few(".$invoices[count].") student(s)" );
					redirect ( base_url ( 'academic_fees' ) );
				}
				else{
					
					if(count($students) > 0){
					        
						for($i=0; $i< count($instalment_data); $i++){
						
						
							foreach ( $students as $row ) {
									
								if ($apply_staff_discount== "yes"){
									$discount_amount = round($instalment_data[$i]['instalment_amount'] * $row ['staff_discount'] / 100);
								}
								else{
									$discount_amount=0;
								}
									
								$outstanding_amount = $instalment_data[$i]['instalment_amount'] - $discount_amount;
									
								$insert_data = array (
										"student_id" => $row['student_id'],
										"academic_year_id" => $this->academic_id,
										"standard_instalment_id" => $instalment_data[$i]['standard_instalment_id'],
										"description" => $fees_description,
										"invoice_type" => "TUITION-FEE",
										"invoice_date" => swap_date_format($invoice_date),
										"invoice_amount" => $instalment_data[$i]['instalment_amount'],
										"discount_amount" => $discount_amount,
										"paid_amount" => 0,
										"outstanding_amount" => $outstanding_amount,
										"status" => "UNPAID",
										"entry_by" => $this->user_id
								);
								$this->db->insert('invoices', $insert_data);
								
								
							}
						}
						
						
						$this->session->set_flashdata ( 'success_message', "Fees has been applied successfully to all selected students" );
						redirect ( base_url ( 'academic_fees' ) );
					}
					
					$this->session->set_flashdata ( 'error_message', "There are no eligible students in the selected division to apply fees" );
					redirect ( base_url ( 'academic_fees' ) );
				}
				
			} else {
				
				$record_count = $this->db->query ( "SELECT count(*) as count FROM invoices 
	    								WHERE `student_id` = " . $applicable_student_id." AND invoice_type ='TUITION-FEE' 
	    								AND `academic_year_id` = " . $this->academic_id )->row_array ();
				
				if ($record_count ['count'] > 0) {
					
					$this->session->set_flashdata ( 'error_message', "Failed!!, Fees has been already applied to this student" );
					redirect ( base_url ( 'academic_fees' ) );
					
				} else {
					
					if ($apply_staff_discount == "yes") {
						
						$this->db->select ( 'staff_discount' );
						$discount = $this->db->get_where ( 'students', array (
								'student_id' => $applicable_student_id) 
						 )->row_array ();
						
					} else {
						$discount = 0;
					}

					$instalment_data = $this->db->query("SELECT * FROM standard_instalments 
															WHERE standard_id = '".$standard_id."'")->result_array();

					for($i=0; $i<count($instalment_data); $i++){
						
						// discount per instalment
						$discount_amount = round($instalment_data[$i]['instalment_amount'] * $discount ['staff_discount'] / 100);
						
						$outstanding_amount = $instalment_data[$i]['instalment_amount'] - $discount_amount;
						
						$insert_data = array (
								"student_id" => $this->input->post ( "applicable_student_id" ),
								"academic_year_id" => $this->academic_id,
								"standard_instalment_id" => $instalment_data[$i]['standard_instalment_id'],
								
								"description" => $fees_description,
								"invoice_type" => "TUITION-FEE",
								"invoice_date" => swap_date_format($invoice_date),
								"invoice_amount" => $instalment_data[$i]['instalment_amount'],
								"discount_amount" => $discount_amount,
								"paid_amount" => 0,
								"outstanding_amount" => $outstanding_amount,
								"status" => "UNPAID",
								"entry_by" => $this->user_id
						);
						
						$this->db->insert ( 'invoices', $insert_data );
						
					}
					/* redirect */
					$this->session->set_flashdata ( 'success_message', "Fees applied successfully" );
					redirect ( base_url ( 'academic_fees' ) );
				}
			}
		}
	}
	
	public function view($invoice_id) {
		
		$data ['invoice_data'] = $this->db->query ( "SELECT invoices.*, student_firstname, student_lastname 
														FROM students, invoices WHERE invoice_id = '".$invoice_id."' 
														AND students.student_id IN (SELECT student_id FROM invoices 
														WHERE invoice_id = '".$invoice_id."')")->row_array ();
		
		$result ['title'] = "Student Invoice Information";
		$result ['body'] = $this->load->view ( 'academic_fees/view', $data, true );
		echo json_encode ( $result );
	}
	public function bulk_challan()
	{
		$data["standards_data"] = $this->db->get_where("standards", array("academic_year_id" => $this->academic_id))->result_array();
		$this->load->view("academic_fees/download_challans",$data);
	}
	public function download_bulk_challan()
	{
		$this->form_validation->set_rules ( 'standard_id', 'Standard', 'required',
											array("required" => "Select The Standard"));
		$this->form_validation->set_rules ( 'division_id', 'Division', 'required',
											array("required" => "Select The Division"));
		$this->form_validation->set_rules ( 'standard_instalment_id', 'Instalment', 'required',
											array("required" => "Select The Instalment"));
		
		if ($this->form_validation->run () == FALSE) {
			$this->bulk_challan();
		} else {
			
			$standard_instalment_id = $this->input->post('standard_instalment_id');
			$division_id = $this->input->post('division_id');
			$standard_id = $this->input->post("standard_id");
			
			 /*!='all' !='all' !='all' 
			 !='all' !='all' =='all' 
			 !='all' =='all' !='all' 
			 !='all' =='all' =='all' 
			 =='all' =='all' =='all' 
			 =='all' !='all' !='all' 
			 =='all' !='all' =='all' 
			 =='all' =='all' !='all'*/

			if($standard_id != 'all' && $division_id != 'all' && $standard_instalment_id != 'all'){
				//1 std 1 div 1 inst
				
				$query = $this->db->query("SELECT * FROM invoices, students, divisions, standards, 
										standard_instalments, academic_years
                                        WHERE divisions.division_id = '$division_id'
                                        AND divisions.standard_id = standards.standard_id
                                        AND standards.standard_id = standard_instalments.standard_id
                                        AND standard_instalments.standard_instalment_id = '$standard_instalment_id'
                                        AND standard_instalments.standard_instalment_id = invoices.standard_instalment_id
                                        AND invoices.status = 'UNPAID' 
                                        AND academic_years.academic_year_id = '$this->academic_id' 
										AND academic_years.academic_year_id = invoices.academic_year_id 
										AND invoices.student_id = students.student_id
										AND students.status = 'ACTIVE'");
			} 
			else if($standard_id != 'all' && $division_id != 'all' && $standard_instalment_id == 'all'){
				//1 std 1 div all inst
				
				$query = $this->db->query("SELECT * FROM invoices, students, divisions, standards, 
										standard_instalments, academic_years 
										WHERE divisions.division_id = '$division_id' 
										AND divisions.standard_id = standards.standard_id 
										AND standards.standard_id = standard_instalments.standard_id 
										AND standard_instalments.standard_instalment_id = invoices.standard_instalment_id 
										AND invoices.status = 'UNPAID' 
										AND academic_years.academic_year_id = '$this->academic_id' 
										AND academic_years.academic_year_id = invoices.academic_year_id 
										AND invoices.student_id = students.student_id
										AND students.status = 'ACTIVE'");
			} 
			else if($standard_id != 'all' && $division_id == 'all' && $standard_instalment_id != 'all'){
				//1 std all div 1 inst
				$instalment_query = "(SELECT standard_instalment_id FROM standard_instalments 
									WHERE instalment_name IN 
										(SELECT instalment_name FROM standard_instalments WHERE standard_instalment_id = '$standard_instalment_id'))";
				
				$query = $this->db->query("SELECT * FROM invoices, students, divisions, standards, 
										standard_instalments, academic_years 
										WHERE standard_instalments.standard_instalment_id IN $instalment_query 
										AND standard_instalments.standard_id = '$standard_id' 
										AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
										AND invoices.status = 'UNPAID' 
										AND invoices.student_id = students.student_id 
										AND students.division_id = divisions.division_id 
										AND divisions.standard_id = standards.standard_id 
										AND invoices.academic_year_id = academic_years.academic_year_id
										AND academic_years.academic_year_id = '$this->academic_id'
										AND students.status = 'ACTIVE'");
			} 
			else if($standard_id != 'all' && $division_id == 'all' && $standard_instalment_id == 'all'){
				//1 std all div all inst
				$query = $this->db->query("SELECT * FROM invoices, students, divisions, standards, 
										standard_instalments, academic_years 
										WHERE standards.standard_id = '$standard_id' 
										AND standards.standard_id = standard_instalments.standard_id 
										AND standard_instalments.standard_instalment_id = invoices.standard_instalment_id 
										AND invoices.status = 'UNPAID' 
										AND academic_years.academic_year_id = '$this->academic_id' 
										AND academic_years.academic_year_id = invoices.academic_year_id 
										AND invoices.student_id = students.student_id 
										AND students.division_id = divisions.division_id
										AND students.status = 'ACTIVE'");
			} 
			else if($standard_id == 'all' && $division_id == 'all' && $standard_instalment_id == 'all'){
				//all std all div all inst
				$query = $this->db->query("SELECT * FROM invoices, students, divisions, standards, 
										standard_instalments, academic_years 
										WHERE invoices.student_id = students.student_id 
										AND invoices.status = 'UNPAID' 
										AND students.division_id = divisions.division_id 
										AND divisions.standard_id = standards.standard_id 
										AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
										AND invoices.academic_year_id = academic_years.academic_year_id
										AND academic_years.academic_year_id = '$this->academic_id'
										AND students.status = 'ACTIVE'");
			} 
			else if($standard_id == 'all' && $division_id != 'all' && $standard_instalment_id != 'all'){
				//all std 1 div inst_name inst
				$instalment_query = "(SELECT standard_instalment_id FROM standard_instalments 
									WHERE instalment_name IN (SELECT instalment_name 
									FROM standard_instalments 
									WHERE standard_instalment_id = '$standard_instalment_id'))";

				$query = $this->db->query("SELECT * FROM invoices, students, divisions, standards, 
										standard_instalments, academic_years 
										WHERE divisions.division_id = '$division_id'
                                        AND divisions.standard_id = standards.standard_id
                                        AND standards.standard_id = standard_instalments.standard_id
                                        AND standard_instalments.standard_instalment_id IN $instalment_query
                                        AND standard_instalments.standard_instalment_id = invoices.standard_instalment_id
                                        AND invoices.status = 'UNPAID'
                                        AND academic_years.academic_year_id = '$this->academic_id'
                                        AND academic_years.academic_year_id = invoices.academic_year_id
                                        AND invoices.student_id = students.student_id
										AND students.status = 'ACTIVE'");
			} 
			else if($standard_id == 'all' && $division_id != 'all' && $standard_instalment_id == 'all'){
				//all std 1 div all inst
				$query = $this->db->query("SELECT * FROM invoices, students, divisions, standards, 
										standard_instalments, academic_years 
										WHERE divisions.division_id = '$division_id' 
										AND divisions.standard_id = standards.standard_id 
										AND standards.standard_id = standard_instalments.standard_id 
										AND standard_instalments.standard_instalment_id = invoices.standard_instalment_id 
										AND invoices.status = 'UNPAID' 
										AND academic_years.academic_year_id = '$this->academic_id' 
										AND academic_years.academic_year_id = invoices.academic_year_id 
										AND invoices.student_id = students.student_id
										AND students.status = 'ACTIVE'");
			} 
			else if($standard_id == 'all' && $division_id == 'all' && $standard_instalment_id != 'all'){
				//all std all div inst_name inst
				$instalment_query = "(SELECT standard_instalment_id FROM standard_instalments 
									WHERE instalment_name IN (SELECT instalment_name 
									FROM standard_instalments 
									WHERE standard_instalment_id = '$standard_instalment_id'))";

				$query = $this->db->query("SELECT * FROM invoices, students, divisions, standards, 
										standard_instalments, academic_years 
										WHERE invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
										AND standard_instalments.standard_instalment_id IN $instalment_query 
										AND invoices.status = 'UNPAID' 
										AND invoices.student_id = students.student_id 
										AND students.division_id = divisions.division_id 
										AND divisions.standard_id = standards.standard_id 
										AND invoices.academic_year_id = academic_years.academic_year_id
										AND academic_years.academic_year_id = '$this->academic_id'
										AND students.status = 'ACTIVE'");

			}

			$data['student_data'] = $query->result_array();
		
			$data['instalment_particulars'] = $this->db->query("SELECT description, amount, sequence_no 
						FROM instalment_particulars
						WHERE standard_instalment_id = '".$standard_instalment_id."'")->result_array();
			
			
			if(count($data['student_data'])>0){
				
				$this->load->view ( "_pdf_tamplates/bulk_challan", $data);
			}else{
				
				$this->session->set_flashdata('error_message', 'Failed to create challans, either fees is not applied to the students OR fees has been paid by the students');
				redirect(base_url('academic_fees/bulk_challan'));
			}
		}
	}
	
	
	/**
	 * ********** ajax functions ******
	 */
	/* response */
	
	public function get_divisions() {
		$standard_id = $this->input->post ( 'standard_id' );
	
		if($standard_id != 'all'){
			$divisions = $this->db->get_where ( 'divisions', array ('standard_id' => $standard_id,"academic_year_id"=>$this->academic_id))->result_array();
		}else{
			$divisions = $this->db->get_where ( 'divisions', 
							array ("academic_year_id"=>$this->academic_id))->result_array();
		}
	
		$division_html = "<option value=''>Select</option>";
		$division_html = "<option value='all'>All</option>";
		foreach ( $divisions as $row ) {
			$division_html .="<option value='" . $row ['division_id'] . "' ".set_select('division_id',$row['division_id']).">" . $row ['division_name'] . "</option>";
		}
		
 		echo $division_html;
	}
	public function  get_instalments() {
		$standard_id = $this->input->post ( 'standard_id' );

		if($standard_id != 'all'){
			$instalments = $this->db->get_where("standard_instalments",
						array("standard_id" => $this->input->post('standard_id') ))->result_array();
		}else{
			$instalments = $this->db->query("SELECT * FROM standard_instalments 
										GROUP BY instalment_name")->result_array();
		}
		
		$instalment_html = "<option value=''>Select</option>";
		$instalment_html = "<option value='all'>All</option>";
		foreach ( $instalments as $row ) {
			$instalment_html .="<option value='" . $row ['standard_instalment_id'] . "' ".set_select('standard_instalment_id',$row['standard_instalment_id']).">" . $row ['instalment_name'] . "</option>";
		}
		echo $instalment_html;
	}
	
	public function get_class_divisions() {
		$standard_id = $this->input->post ( 'standard_id' );
		
		$divisions = $this->db->get_where ( 'divisions', array ('standard_id' => $standard_id))->result_array ();

		$division_html= '<option value="">Select</option>';
		foreach ( $divisions as $row ) {
			$division_html =$division_html.'<option value="' . $row ['division_id'] . '">' . $row ['division_name'] . '</option>';
		}
		
		$total_fees_data = $this->db->query("SELECT total_fees FROM standards WHERE standard_id = '".$standard_id."'")->row_array();
		
		$data['standard_fees'] = $total_fees_data['total_fees'];
		$data['division_html']=$division_html;
		echo json_encode($data);
	}
	public function get_applicable_students() {
		$standard_id = $this->input->post ( 'standard_id' );
		$division_id = $this->input->post ( 'division_id' );
		
		if ($division_id == "all") {
			
			$students = $this->db->query ( "SELECT student_id, student_firstname, student_lastname, status FROM students, divisions, standards 
												WHERE students.division_id  = divisions.division_id  
												AND divisions.standard_id = standards.standard_id 
												AND standards.standard_id = '". $standard_id."' 
												AND rte_provision = 'NO'" )->result_array ();
		} else {
			$students = $this->db->get_where ( 'students', array (
					'division_id' => $division_id , 'rte_provision' => 'NO'
			) )->result_array ();
		}
		
		echo '<option value="">Select</option>';
		echo '<option value="all">All</option>';
		foreach ( $students as $row ) {
			if($row['status']!="RTE"){
				echo '<option value="' . $row ['student_id'] . '">' . $row ['student_firstname'] . ' ' . $row ['student_lastname'] . '</option>';
			}
		}
	}
}