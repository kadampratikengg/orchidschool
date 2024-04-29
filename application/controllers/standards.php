<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Standards extends CI_Controller {
	var $user_id;
	var $academic_id;
	public function __construct() {
		parent::__construct ();
		// Your own constructor code
		$this->login_model->validate_user_login ( "STAFF" );
		
		$this->user_id = $this->session->userdata ( 'user_id' );
		$this->academic_id = $this->session->userdata ( 'current_academic_year_id' );
	}
	public function index() {
		$data ['standards_data'] = $this->db->query ( "SELECT standard_id, standard_name, total_fees,
												(select count(standard_instalment_id) 
												from standard_instalments where 
												standard_instalments.standard_id = std.standard_id) 
												as no_of_instalments 
												from standards std where academic_year_id = '" . $this->academic_id . "'" )->result_array ();
		
		$this->load->view ( 'standards/default', $data );
	}
	public function add_standard() {
		$this->load->view ( 'standards/add_standard' );
	}
	public function save_standard() {
		$this->form_validation->set_rules ( 'standard_name', 'Standard', 'required' );
		$this->form_validation->set_rules ( 'standard_prefix', 'Standard Prefix', 'required|callback_check_standard_prefix' );
		$this->form_validation->set_rules ( 'total_fees', 'Total fees', 'required|numeric' );
		
		if ($this->form_validation->run () == FALSE) {
			$this->add_standard ();
		} else {
			
			/* save standards */
			$insert_data = array (
					"standard_name" => $this->input->post ( "standard_name" ),
					"standard_prefix" => $this->input->post ( "standard_prefix" ),
					"total_fees" => $this->input->post ( "total_fees" ),
					"entry_by" => $this->user_id,
					"academic_year_id" => $this->academic_id 
			);
			
			$this->db->insert ( 'standards', $insert_data );
			
			/* redirect */
			$this->session->set_flashdata ( 'success_message', "Record saved successfully" );
			
			if (strcmp ( $this->input->post ( 'is_add' ), "TRUE" ) == 0)
				redirect ( base_url ( 'standards/add_instalment' ) );
			else
				redirect ( base_url ( 'standards' ) );
		}
	}
	function edit_standard($standard_id) {
		$query = $this->db->get_where ( 'standards', array (
				'standard_id' => $standard_id 
		) );
		$data ['standard_data'] = $query->row_array ();
		
		$this->load->view ( 'standards/edit_standard', $data );
	}
	function update_standard($standard_id) {
		$this->form_validation->set_rules ( 'standard_name', 'Division', 'required' );
		$this->form_validation->set_rules ( 'standard_prefix', 'Standard Prefix', 'required|callback_check_standard_prefix[' . $standard_id . ']' );
		$this->form_validation->set_rules ( 'total_fees', 'Total fees', 'required|numeric' );
		
		if ($this->form_validation->run () == FALSE) {
			$this->edit_standard ( $standard_id );
		} else {
			
			$update_data = array (
					"standard_name" => $this->input->post ( "standard_name" ),
					"standard_prefix" => $this->input->post ( "standard_prefix" ),
					"total_fees" => $this->input->post ( "total_fees" ) 
			);
			
			$this->db->update ( 'standards', $update_data, array (
					"standard_id" => $standard_id 
			) );
			
			if ($this->db->affected_rows () > 0)
				$this->session->set_flashdata ( 'success_message', "Record updated successfully" );
			else
				$this->session->set_flashdata ( 'error_message', "Failed to update record" );
			
			redirect ( base_url ( 'standards' ) );
		}
	}
	function delete_standard($standard_id) {
		$standard_applied_count = $this->db->query ( "SELECT count(*) AS count FROM students, standards, divisions 
														WHERE standards.standard_id = '" . $standard_id . "' 
														AND standards.standard_id = divisions.standard_id 
														AND divisions.division_id = students.division_id " )->row_array ();
		
		if ($standard_applied_count ['count'] > 0) {
			
			$this->session->set_flashdata ( 'error_message', "Failed to delete, Cannot delete this standard as it is 
												already been assigned to few(" . $standard_applied_count ['count'] . ") students" );
		} else {
			
			//$this->db->trans_start ();
			
			$this->db->query ( "DELETE instalment_particulars.* FROM standard_instalments, instalment_particulars 
									WHERE standard_instalments.standard_id = '{$standard_id}' 
									AND standard_instalments.standard_instalment_id = instalment_particulars.standard_instalment_id" );
			
			$this->db->delete ( 'standard_instalments', array (
					'standard_id' => $standard_id 
			) );
			$this->db->delete ( 'standards', array (
					'standard_id' => $standard_id 
			) );
			
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
		redirect ( base_url ( 'standards' ) );
	}
	
	/* Instalment operations */
	public function add_instalment() {
		$data ['standards_data'] = $this->db->query ( "select standard_id, standard_name from standards
    										where academic_year_id ='" . $this->academic_id . "'" )->result_array ();
		$this->load->view ( 'standards/add_instalment', $data );
	}
	public function save_instalment() {
		$this->form_validation->set_rules ( 'standard_id', 'Standard', 'required' );
		$this->form_validation->set_rules ( 'instalment_name', 'Instalment Name', 'required' );
		$this->form_validation->set_rules ( 'instalment_prefix', 'Instalment Prefix', 'required|callback_check_instalment_prefix' );
		$this->form_validation->set_rules ( 'instalment_amount', 'Instalment Amount', 'required|numeric|callback_check_standard_fees' );
		$this->form_validation->set_rules ( 'late_fee', 'Late fees', 'required|numeric' );
		$this->form_validation->set_rules ( 'start_date', 'Start Date', 'required|callback_check_dates' );
		$this->form_validation->set_rules ( 'due_date', 'Due Date', 'required' );
		
		if ($this->form_validation->run () == FALSE) {
			$this->add_instalment ();
		} else {
			
			$insert_data = array (
					"standard_id" => $this->input->post ( "standard_id" ),
					"instalment_name" => $this->input->post ( "instalment_name" ),
					"instalment_prefix" => $this->input->post ( "instalment_prefix" ),
					"instalment_amount" => $this->input->post ( "instalment_amount" ),
					"late_fee" => $this->input->post ( "late_fee" ),
					"start_date" => swap_date_format ( $this->input->post ( "start_date" ) ),
					"due_date" => swap_date_format ( $this->input->post ( "due_date" ) ),
					"end_date" => swap_date_format ( $this->input->post ( "end_date" ) ),
					"entry_by" => $this->user_id,
					"academic_year_id" => $this->academic_id 
			);
			
			$prefix = $this->input->post ( "instalment_prefix" );
			$standard_id = $this->input->post ( "standard_id" );
			$query = $this->db->query ( "SELECT * FROM standard_instalments where instalment_prefix='{$prefix}' AND standard_id='{$standard_id}' " );
			$arr = $query->result_array ();
			$p = $query->num_rows ();
			if ($p > 0) {
				
				$this->session->set_flashdata ( 'error_message', "Select another instalments prefix" );
				$this->add_instalment ();
			} else {
				/* save instalments */
				$this->db->insert ( 'standard_instalments', $insert_data );
				/* redirect */
				$this->session->set_flashdata ( 'success_message', "Record saved successfully" );
				if (strcmp ( $this->input->post ( 'is_add' ), "TRUE" ) == 0)
					redirect ( base_url ( 'standards/add_particular/' . $this->db->insert_id () ) );
				else
					redirect ( base_url ( 'standards/view_instalments/' . $this->input->post ( "standard_id" ) ) );
			}
		}
	}
	function edit_instalment($standard_instalment_id, $standard_id) {
		$data ['instalment_data'] = $this->db->get_where ( "standard_instalments", array (
				"standard_instalment_id" => $standard_instalment_id 
		) )->row_array ();
		$data ['standard_data'] = $this->db->get_where ( "standards", array (
				"standard_id" => $standard_id
		) )->row_array ();
		$this->load->view ( "standards/edit_instalment", $data );
	}
	function update_instalment() {
		$this->form_validation->set_rules ( 'instalment_name', 'Instalment Name', 'required' );
		$this->form_validation->set_rules ( 'instalment_prefix', 'Instalment Prefix', 'required' );
		$this->form_validation->set_rules ( 'instalment_amount', 'Instalment Amount', 'required|numeric|callback_check_standard_fees_while_update' );
		$this->form_validation->set_rules ( 'start_date', 'Start Date', 'required' );
		$this->form_validation->set_rules ( 'due_date', 'Due Date', 'required' );
		
		if ($this->form_validation->run () == FALSE) {
			$this->edit_instalment ( $this->input->post('instalment_id'), $this->input->post('standard_id') );
		} else {
				
			$update_data = array (
					"instalment_name" => $this->input->post ( "instalment_name" ),
					"instalment_prefix" => $this->input->post ( "instalment_prefix" ),
					"instalment_amount" => $this->input->post ( "instalment_amount" ),
					"start_date" => swap_date_format ( $this->input->post ( "start_date" )),
					"due_date" => swap_date_format ($this->input->post ( "due_date" ))
			);
				
			$this->db->update ( 'standard_instalments', $update_data, array (
					"standard_instalment_id" => $this->input->post('instalment_id')
			) );
				
			if ($this->db->affected_rows () > 0)
				$this->session->set_flashdata ( 'success_message', "Record updated successfully" );
			else
				$this->session->set_flashdata ( 'error_message', "Failed to update record" );
			$this->view_instalments( $this->input->post('standard_id') );	
		}
	}
	function view_instalments($standard_id) {
		$data ["instalment_data"] = $this->db->get_where ( "standard_instalments", array (
				"standard_id" => $standard_id 
		) )->result_array ();
		$this->load->view ( "standards/view_instalments", $data );
	}
	function delete_instalment($standard_instalment_id, $standard_id) {
		$instalment_applied_count = $this->db->query ( "SELECT count(*) AS count FROM invoices
														WHERE standard_instalment_id= '" . $standard_instalment_id . "'
														AND status = 'FULLY_PAID'" )->row_array ();
		
		if ($instalment_applied_count ['count'] > 0) {
			
			$this->session->set_flashdata ( 'error_message', "Failed to delete, Cannot delete this instalment as it is already been paid by the students" );
		} else {
			
			//$this->db->trans_start ();
			
			$this->db->query ( "DELETE FROM invoices WHERE standard_instalment_id = '" . $standard_instalment_id . "'" );
			$this->db->query ( "DELETE FROM standard_instalments WHERE standard_instalment_id = '" . $standard_instalment_id . "'" );
			
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
		
		redirect ( base_url ( 'standards/view_instalments/' . $standard_id ) );
	}
	
	/* instalment_particulars */
	function add_particular($standard_instalment_id) {
		$data ['standard_instalment_id'] = $standard_instalment_id;
		$response ['title'] = "Add Particular";
		$response ['body'] = $this->load->view ( 'standards/add_particular', $data, true );
		echo json_encode ( $response );
	}
	function save_particular() {
		$standard_instalment_id = $this->input->post ( 'standard_instalment_id' );
		
		$this->form_validation->set_rules ( 'description', 'Description', 'required' );
		$this->form_validation->set_rules ( 'amount', 'Amount', 'required|numeric|callback_check_particular_amount[' . $standard_instalment_id . ']' );
		$this->form_validation->set_rules ( 'sequence_no', 'Sequence No', 'required|numeric' );
		
		if ($this->form_validation->run () == FALSE) {
			$response ['status'] = "error_message";
			$response ['message'] = validation_errors ();
		} else {
			$insert_data = array (
					"standard_instalment_id" => $standard_instalment_id,
					"description" => $this->input->post ( "description" ),
					"amount" => $this->input->post ( "amount" ),
					"sequence_no" => $this->input->post ( "sequence_no" ),
					"entry_by" => $this->user_id,
					"academic_year_id" => $this->academic_id 
			);
			$this->db->insert ( 'instalment_particulars', $insert_data );
			$response ['status'] = "success_message";
			$response ['message'] = "Record has been saved Successfully";
		}
		echo json_encode ( $response );
	}
	function view_particulars($standard_instalment_id) {
		$data ['particulars_data'] = $this->db->query ( "SELECT * FROM instalment_particulars where standard_instalment_id = '" . $standard_instalment_id . "'" )->result_array ();
		$data ['instalment_data'] = $this->db->query ( "select instalment_name, instalment_amount from standard_instalments where standard_instalment_id= '" . $standard_instalment_id . "'" )->row_array ();
		
		$response ['title'] = "Installment Particulars Details";
		$response ['body'] = $this->load->view ( 'standards/view_particulars', $data, true );
		
		echo json_encode ( $response );
	}
	function delete_particular($instalment_particular_id) {
		$data = $this->db->query ( "SELECT standard_id FROM instalment_particulars, standard_instalments 
									WHERE instalment_particular_id = '" . $instalment_particular_id . "' 
									AND instalment_particulars.standard_instalment_id = standard_instalments.standard_instalment_id" )->row_array ();
		
		//$this->db->trans_start ();
		$this->db->delete ( 'instalment_particulars', array (
				'instalment_particular_id' => $instalment_particular_id 
		) );
		//$this->db->trans_complete (); // Completing transaction
		
		/*if ($this->db->trans_status () === FALSE) {
			$this->db->trans_rollback ();
			$this->session->set_flashdata ( 'error_message', "Failed to delete record" );
		} else {
			$this->db->trans_commit ();
			$this->session->set_flashdata ( 'success_message', "Record deleted successfully" );
		}*/
		
		$this->session->set_flashdata ( 'success_message', "Record deleted successfully" );
		redirect ( base_url ( 'standards/view_instalments/' . $data ['standard_id'] ) );
	}
	
	/**
	 * *** Call back functions ***
	 */
	function check_dates($start_date) {
		$start_date = swap_date_format ( $this->input->post ( 'start_date' ) );
		$due_date = swap_date_format ( $this->input->post ( 'due_date' ) );
		
		$current_date = new DateTime ( date ( "Y-m-d" ) );
		$start_date = new DateTime ( $start_date );
		$due_date = new DateTime ( $due_date );
		
		if ($start_date < $current_date) {
			
			$this->form_validation->set_message ( 'check_dates', 'The Start Date has to be greater than or equal to the Current Date' );
			return false;
		} elseif ($due_date < $start_date) {
			
			$this->form_validation->set_message ( 'check_dates', 'The Due Date has to be greater than or equal to the Start Date' );
			return false;
		}
	}
	function check_particular_amount($amount, $standard_instalment_id) {
		$particulars_data = $this->db->query ( "SELECT SUM(amount) as sum FROM instalment_particulars 
							WHERE standard_instalment_id = '" . $standard_instalment_id . "'" )->row_array ();
		
		$instalment_data = $this->db->query ( "SELECT instalment_amount FROM standard_instalments 
							WHERE standard_instalment_id = '" . $standard_instalment_id . "' " )->row_array ();
		
		if ($instalment_data ['instalment_amount'] < ($particulars_data ['sum'] + $amount)) {
			$this->form_validation->set_message ( 'check_particular_amount', 'Invalid Amount entered, All particular amounts should not exceed total instalment amount' );
			return FALSE;
		}
		return true;
	}
	function check_standard_fees() {
		$standard_id = $this->input->post ( 'standard_id' );
		
		$standard_fees_data = $this->db->query ( "SELECT (total_fees - SUM(instalment_amount)) AS fees_allowed, count(standard_instalments.standard_id) as total_instalments
													FROM standards, standard_instalments WHERE standards.standard_id = '" . $standard_id . "' 
													AND standards.standard_id = standard_instalments.standard_id" )->row_array ();
		
		if ($standard_fees_data ['total_instalments'] > 0) {
			
			$instalment_amount = $this->input->post ( "instalment_amount" );
			if ($instalment_amount > $standard_fees_data ['fees_allowed']) {
				$this->form_validation->set_message ( 'check_standard_fees', "Instalment amount exceeds standard's fees, please check total fees of the standard" );
				return false;
			}
		} else {
			return true;
		}
	}
	
	function check_standard_fees_while_update() {
		$standard_id = $this->input->post ( 'standard_id' );
		$instalment_id=$this->input->post('instalment_id');
		
		$standard_fees_data = $this->db->query ( "SELECT (total_fees - SUM(instalment_amount)) AS fees_allowed, count(standard_instalments.standard_id) as total_instalments
													FROM standards, standard_instalments WHERE standards.standard_id = '" . $standard_id . "' 
													AND standards.standard_id = standard_instalments.standard_id AND standard_instalments.standard_instalment_id!='".$instalment_id."'" )->row_array ();
		
		if ($standard_fees_data ['total_instalments'] > 0) {
			
			$instalment_amount = $this->input->post ( "instalment_amount" );
			if ($instalment_amount > $standard_fees_data ['fees_allowed']) {
				$this->form_validation->set_message ( 'check_standard_fees_while_update', "Instalment amount exceeds standard's fees, please check total fees of the standard" );
				return false;
			}
		} else {
			return true;
		}
	}
	
	/**
	 * * Ajax Functions ****
	 */
	function check_standard_prefix($prefix,$standard_id) {
		//$standard_id = $this->input->post ( 'standard_id' );
		$standard_prefix_count = $this->db->query ( "SELECT count(*) AS count FROM standards 
														WHERE standard_prefix = '" . $prefix . "' AND standard_id != '" . $standard_id . "'
														AND academic_year_id = '" . $this->academic_id . "'" )->row_array ();
		//echo $this->db->last_query();exit;
		if ($standard_prefix_count ['count'] > 0) {
			echo '';
			$this->form_validation->set_message ( 'check_standard_prefix', 'Selected prefix is already given to another standard, Choose another prefix' );
			return FALSE;
		}
		return TRUE;
	}
	function check_instalment_prefix($prefix) {
		$standard_id = $this->input->post ( 'standard_id' );
		$instalment_prefix_count = $this->db->query ( "SELECT count(*) AS count FROM standard_instalments 
														WHERE instalment_prefix = '" . $prefix . "' 
														AND standard_id = '" . $standard_id . "'
														AND academic_year_id = '" . $this->academic_id . "'" )->row_array ();
		if ($instalment_prefix_count ['count'] > 0) {
			$this->form_validation->set_message ( 'check_instalment_prefix', 'Selected prefix is already given to another instalment, Choose another prefix' );
			return FALSE;
		}
		return TRUE;
	}
}