<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Reports extends CI_Controller {
	
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
		
		// installment wise summary
		$instalments = $this->db->query("SELECT instalment_prefix FROM `standard_instalments` 
											where academic_year_id = '".$this->academic_id."' 
											group by instalment_prefix order by instalment_prefix")->result_array();
		
		foreach ($instalments as $instalment){
			
			$prefix = $instalment['instalment_prefix'];
			$data["instalment_data"][] = $this->db->query("select sum(invoice_amount) as receivable,
					 sum(discount_amount) as discount,sum(paid_amount) as paid,sum(outstanding_amount) as outstanding, '{$prefix}' as prefix 
					 from invoices where standard_instalment_id IN 
					 (select standard_instalment_id from standard_instalments where instalment_prefix = '".$prefix."') 
					 		AND academic_year_id = '".$this->academic_id."' ")->row_array();
			
		}
		
		$this->load->view("reports/default",$data);
	}
	
	public function get_standard_details(){
		
	
		$standards = $this->db->query("SELECT standards.standard_id, standards.standard_name FROM standard_instalments, standards 
					where standard_instalments.standard_id = standards.standard_id AND standard_instalments.academic_year_id = '".$this->academic_id."'  AND
					instalment_prefix = '".$this->input->post('prefix')."' ORDER BY standards.standard_name")->result_array();
		
		
		echo '<strong>Standard Wise summary for Instalment : '.$this->input->post('prefix').'</strong>
				<a href="javascript:;" class="font-red-soft close_container pull-right"><i class="fa fa-times"></i> close</a>
				<table class="table table-bordered table-hovered table-condensed">
					<tr class="bg-green-haze report_heading1">
						<td class="bg-font-green-haze">Standard</td>
						<td class="bg-font-green-haze">Total Receivable</td>
						<td class="bg-font-green-haze">Paid</td>
						<td class="bg-font-green-haze">Discount</td>
						<td class="bg-font-green-haze">Outstanding</td>
						<td class="bg-font-green-haze">Details</td>
					</tr>';
		foreach ($standards as $standard){
			
			$standard_id = $standard['standard_id'];
			$standard_name = $standard['standard_name'];
			
			$standard_data = $this->db->query("SELECT sum(invoice_amount) as receivable, sum(discount_amount) as discount,
					sum(paid_amount) as paid,sum(outstanding_amount) as outstanding, '{$standard_id}' as standard_id, 
					'{$standard_name}' as standard_name FROM invoices 
					WHERE standard_instalment_id IN (SELECT standard_instalment_id 
					FROM standard_instalments WHERE standard_id = '".$standard_id."' 
					AND instalment_prefix = '".$this->input->post('prefix')."' ) 
					AND academic_year_id = '".$this->academic_id."'")->row_array();
			
			echo "<tr>";
			echo "<td>{$standard_data['standard_name']}</td>";
			echo "<td>Rs.{$standard_data['receivable']}</td>";
			echo "<td>Rs.{$standard_data['paid']}</td>";
			echo "<td>Rs.{$standard_data['discount']}</td>";
			echo "<td>Rs.{$standard_data['outstanding']}</td>";
			echo "<td><a href=\"javascript:;\" class=\"font-green-haze\" onclick=\"get_division_details('".$standard_data['standard_id']."','".$standard_data['standard_name']."','".$this->input->post('prefix')."')\"><i class=\"fa fa-search\"></i> View Details</a></td>";
			echo "</tr>";
			echo "<tr id=\"division_".$standard_data['standard_id']."_container\" style=\"display: none;\">
				<td colspan=\"6\"><i class=\"fa fa-spin fa-refresh\"></i> Loading data...</td>";
			echo "</tr>";
						
		}
		echo '</table>';
	
	}
	
	public function get_division_details(){
	
		$divisions = $this->db->query("SELECT divisions.division_id, divisions.division_name FROM standards,divisions
					where standards.standard_id = divisions.standard_id 
					AND divisions.academic_year_id = '".$this->academic_id."'  
					AND standards.standard_id = '".$this->input->post('standard_id')."'  ")->result_array();
		
		echo '<strong>Division Wise summary for Standard : '.$this->input->post('standard_name').'</strong>
				<a href="javascript:;" class="font-red-soft close_container pull-right"><i class="fa fa-times"></i> close</a>
				<table class="table table-bordered table-hovered table-condensed">
					<tr class="bg-blue-steel report_heading1">
						<td class="bg-font-blue-steel">Division</td>
						<td class="bg-font-blue-steel">Total Receivable</td>
						<td class="bg-font-blue-steel">Paid</td>
						<td class="bg-font-blue-steel">Discount</td>
						<td class="bg-font-blue-steel">Outstanding</td>
						
					</tr>';
		
		foreach ($divisions as $division){
	
			$division_id = $division['division_id'];
			$division_name = $division['division_name'];
			$prefix = $this->input->post('prefix');
			
			$division_data = $this->db->query("SELECT SUM(invoice_amount) AS receivable, SUM(discount_amount) AS discount,
												SUM(paid_amount) AS paid, SUM(outstanding_amount) AS outstanding, 
												divisions.division_id AS division_id, division_name AS division_name 
												FROM invoices, divisions, student_academic_years, standard_instalments 
												WHERE divisions.division_id = '{$division_id}' 
												AND divisions.division_id = student_academic_years.division_id 
												AND student_academic_years.student_id = invoices.student_id 
												AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
												AND standard_instalments.instalment_prefix = '{$prefix}' 
												AND invoices.academic_year_id = '{$this->academic_id}'")->row_array(); 
				
			echo "<tr>";
			echo "<td>{$division_data['division_name']}</td>";
			echo "<td>Rs.{$division_data['receivable']}</td>";
			echo "<td>Rs.{$division_data['paid']}</td>";
			echo "<td>Rs.{$division_data['discount']}</td>";
			echo "<td>Rs.{$division_data['outstanding']}</td>";
			//echo "<td><a href=\"javascript:;\" class=\"font-blue-steel\" onclick=\"get_student_details('".$division_data['division_id']."','".$division_data['division_name']."','".$prefix."')\"><i class=\"fa fa-search\"></i> View Details</a></td>";
			echo "</tr>";
			echo "<tr id=\"students_".$division_data['division_id']."_container\" style=\"display: none;\">
				<td colspan=\"6\"><i class=\"fa fa-spin fa-refresh\"></i> Loading data...</td>";
			echo "</tr>";
	
		}
		
		echo '</table>';
	
	}
	
	public function get_student_details(){
	
		$division_name = $this->input->post('division_name');
		$division_id = $this->input->post('division_id');
		$prefix = $this->input->post('prefix');
		
		$students = $this->db->query("SELECT invoice_amount, discount_amount, paid_amount, outstanding_amount, student_firstname, student_lastname 
				FROM invoices, student_academic_years, standard_instalments, students 
				WHERE student_academic_years.division_id = '{$division_id}' 
				AND student_academic_years.student_id = students.student_id 
				AND student_academic_years.student_id = invoices.student_id 
				AND invoices.academic_year_id = '{$this->academic_id}' 
				AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
				AND standard_instalments.instalment_prefix = '{$prefix}'")->result_array();
		
		echo '<strong>Student Wise summary for Division : '.$division_name.'</strong>
				<a href="javascript:;" class="font-red-soft close_container pull-right"><i class="fa fa-times"></i> close</a>
				<table class="table table-bordered table-hovered table-condensed">
					<tr class="bg-blue-madison report_heading1">
						<td class="bg-font-blue-madison">Student</td>
						<td class="bg-font-blue-madison">Total Receivable</td>
						<td class="bg-font-blue-madison">Paid</td>
						<td class="bg-font-blue-madison">Discount</td>
						<td class="bg-font-blue-madison">Outstanding</td>
					</tr>';
		
		foreach ($students as $student){
			
			echo "<tr>";
			echo "<td>".$student['student_firstname']." ".$student['student_lastname']."</td>";
			echo "<td>Rs.{$student['invoice_amount']}</td>";
			echo "<td>Rs.{$student['paid_amount']}</td>";
			echo "<td>Rs.{$student['discount_amount']}</td>";
			echo "<td>Rs.{$student['outstanding_amount']}</td>";
			echo "</tr>";
			
	
		}
		echo '</table>';
	
	}
	public function discount_reports() {

		$data['students'] = $this->db->query ( "SELECT student_firstname, student_lastname, admission_no, parent_email_id, parent_mobile_no,
													SUM(invoice_amount) AS invoice_amount, SUM(discount_amount) AS discount_amount
													FROM students, divisions, invoices 
													WHERE divisions.division_id = students.division_id
													AND students.student_id = invoices.student_id 
													AND students.academic_year_id = '".$this->academic_id."'
													AND students.rte_provision = 'NO'
													AND invoices.discount_amount > 0
													GROUP BY invoices.student_id" )->result_array ();
		$this->load->view ( "reports/discount_reports", $data);
	}
	
	
	public function receivable_reports() {
	
		$data ["standard_data"] = $this->db->get_where( "standards", array (
				"academic_year_id" => $this->academic_id
		) )->result_array ();
		$this->load->view ( "reports/receivable_reports", $data);
	}
	
	public function get_receivable_reports () {
		$standard_id = $this->input->post ( "standard_id" );
		$standard_instalment_id = $this->input->post ( "instalment_id" );
		
		
		if($standard_id == 'all' && $standard_instalment_id == 'all'){
			$data = $this->db->query("SELECT standard_prefix, instalment_prefix, students.student_id, 
									admission_no, student_firstname, student_lastname, due_date,late_fee, instalment_amount, staff_discount 
									FROM students, standards, divisions, invoices, standard_instalments 
									WHERE standard_instalments.standard_instalment_id = invoices.standard_instalment_id 
									AND invoices.student_id = students.student_id 
									AND students.division_id = divisions.division_id 
									AND divisions.standard_id = standards.standard_id
									AND students.status = 'ACTIVE'")->result_array();

		}else if($standard_id == 'all' && $standard_instalment_id != 'all'){
			$data = $this->db->query("SELECT standard_prefix, instalment_prefix, students.student_id, 
									admission_no, student_firstname, student_lastname, due_date,late_fee, 
									instalment_amount, staff_discount 
									FROM students, standards, divisions, invoices, standard_instalments 
									WHERE invoices.standard_instalment_id 
									IN (SELECT standard_instalment_id FROM standard_instalments 
										WHERE instalment_name IN 
											(SELECT instalment_name FROM standard_instalments 
											WHERE standard_instalment_id = '$standard_instalment_id')) 
									AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
									AND invoices.student_id = students.student_id 
									AND students.division_id = divisions.division_id 
									AND divisions.standard_id = standards.standard_id
									AND students.status = 'ACTIVE'")->result_array();

		}else if($standard_id != 'all' && $standard_instalment_id == 'all'){
			$data = $this->db->query("SELECT standard_prefix, instalment_prefix, students.student_id, 
									admission_no, student_firstname, student_lastname, due_date,late_fee, 
									instalment_amount, staff_discount 
									FROM students, standards, divisions, invoices, standard_instalments 
									WHERE invoices.standard_instalment_id 
										IN (SELECT standard_instalment_id FROM standard_instalments 
										WHERE standard_id = '$standard_id') 
									AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
									AND invoices.student_id = students.student_id 
									AND students.division_id = divisions.division_id 
									AND divisions.standard_id = standards.standard_id
									AND students.status = 'ACTIVE'")->result_array();
		}else{
			$data = $this->db->query("SELECT standard_prefix, instalment_prefix, students.student_id, 
									admission_no, student_firstname, student_lastname, due_date,late_fee,
									instalment_amount, staff_discount 
									FROM students, standards, divisions, invoices, standard_instalments 
									WHERE standard_instalments.standard_instalment_id = '$standard_instalment_id' 
									AND standard_instalments.standard_instalment_id = invoices.standard_instalment_id 
									AND invoices.student_id = students.student_id 
									AND students.division_id = divisions.division_id 
									AND divisions.standard_id = standards.standard_id
									AND students.status = 'ACTIVE'")->result_array();
		}

		$i = 1;
		$total_amount = 0;
		$total_discount = 0;
		$total_late_fees = 0;
		$current_date = new DateTime ( date ( "Y-m-d" ) );
		if (! empty ( $data )) {
			foreach ( $data as $row ) {
		
				$due_date = new DateTime ( $row ['due_date'] );
				$interval = $current_date->diff ( $due_date );
				$late_days = $interval->format ( '%a' );
				
				if ($current_date > $due_date && $late_days > 0) {
					$total_late_fees = $late_days * $row ["late_fee"];
				}
				/*$discount_amount = ($row['instalment_amount'] * $row['staff_discount']) / 100;*/


				$total_amount = $total_late_fees + $row ['instalment_amount'] - round ( $row ['instalment_amount'] * $row ['staff_discount'] / 100 );
				
				echo "<tr><td>" . $i ++ . "</td>";
				echo "<td>" . $row ['admission_no'] . "</td>";
				echo "<td>" . $row ['student_firstname'] ." ". $row ['student_lastname'] . "</td>";
				echo "<td>" . $row ['standard_prefix'].$row['instalment_prefix']."-".$row['student_id'] . "</td>";
				echo "<td>Rs." . $total_amount . " (Rs.".$total_late_fees.")</td>";
				$total_fees += $total_amount;
			}
			echo "<tr> <td colspan='4' align='right'><strong><span>Total </span></strong></td>";
			echo "<td><strong>Rs." . $total_fees . "</strong></td>";
		} else {
			echo "<tr><td colspan='5' align='center'><span>No data to display</span></td></tr>";
		}
	}
	
	public function payment_received_reports() {

		$data['standards'] = $this->db->query("SELECT * FROM standards 
										WHERE academic_year_id = '$this->academic_id'")->result_array();
		/*$from = swap_date_format($this->input->post ( "from" ));
		
		$to = swap_date_format($this->input->post ( "to" ));*/
		
		$standard_id = $this->input->post('standard_id');
		
		$instalment_id = $this->input->post('instalment_id');

		/*$this->form_validation->set_rules ( 'from', 'From Date', 'required' );
		$this->form_validation->set_rules ( 'to', 'To Date', 'required' );*/
		$this->form_validation->set_rules ( 'standard_id', 'Standard', 'required' );
		if($standard_id != 'all'){
			$this->form_validation->set_rules ( 'instalment_id', 'Instalment', 'required' );
		}
		
		if ($this->form_validation->run () == FALSE) {
			$data['student_data'] = array();
			$this->load->view ( "reports/payment_received_reports", $data);
		} else {
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				if($standard_id == 'all' && $instalment_id == 'all'){
					$data['student_data'] = $this->db->query("SELECT CONCAT(standard_name, '-', division_name) 
										AS division, instalment_name, admission_no, 
										CONCAT(student_firstname,' ',student_lastname) AS student_name,
										payment_date,total_paid_amount, payment_mode, narration 
										FROM students, standards, divisions, student_academic_years,
										payments, standard_instalments, invoices
										WHERE student_academic_years.academic_year_id = '$this->academic_id' 
										AND student_academic_years.student_id = students.student_id 
										AND students.division_id = divisions.division_id 
										AND divisions.standard_id = standards.standard_id 
										AND students.student_id = payments.student_id 
										AND payments.status = 'PAYMENT-RECEIVED' 
										AND payments.invoice_id = invoices.invoice_id 
										AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
										AND students.status = 'ACTIVE'
										ORDER BY standards.standard_id")->result_array();

				}else if($standard_id == 'all' && $instalment_id != 'all'){

					$data['student_data'] = $this->db->query("SELECT CONCAT(standard_name, '-', division_name) 
											AS division, instalment_name, admission_no, 
											CONCAT(student_firstname,' ',student_lastname) 
											AS student_name, payment_date,total_paid_amount, 
											payment_mode, narration 
											FROM students, standards, divisions, student_academic_years, 
											payments, standard_instalments, invoices 
											WHERE invoices.standard_instalment_id IN 
												(SELECT standard_instalment_id FROM standard_instalments 
												WHERE instalment_name IN (SELECT instalment_name 
												FROM standard_instalments 
												WHERE standard_instalment_id = '$instalment_id')) 
											AND invoices.invoice_id = payments.invoice_id 
											AND payments.status = 'PAYMENT-RECEIVED' 
											AND payments.student_id = student_academic_years.student_id 
											AND student_academic_years.student_id = students.student_id 
											AND students.division_id = divisions.division_id 
											AND divisions.standard_id = standards.standard_id 
											AND students.status = 'ACTIVE'
											AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id")->result_array();

				}else if($standard_id != 'all' && $instalment_id == 'all'){
					$data['student_data'] = $this->db->query("SELECT CONCAT(standard_name, '-', division_name) AS 
									division, instalment_name, admission_no, 
									CONCAT(student_firstname,' ',student_lastname) AS student_name, 
									payment_date,total_paid_amount, payment_mode, narration 
									FROM students, standards, divisions, student_academic_years, payments, standard_instalments, invoices
									WHERE invoices.standard_instalment_id in 
										(SELECT standard_instalment_id FROM standard_instalments 
											WHERE standard_instalments.standard_id = '$standard_id') 
									AND invoices.invoice_id = payments.invoice_id 
									AND payments.status = 'PAYMENT-RECEIVED' 
									AND payments.student_id = student_academic_years.student_id 
									AND student_academic_years.student_id = students.student_id 
									AND students.division_id = divisions.division_id 
									AND divisions.standard_id = standards.standard_id 
									AND students.status = 'ACTIVE'
									AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id")->result_array();

				}else{
					$data['student_data'] = $this->db->query("SELECT CONCAT(standard_name, '-', division_name) 
										AS division, instalment_name, admission_no, 
										CONCAT(student_firstname,' ',student_lastname) AS student_name,
										payment_date,total_paid_amount, payment_mode, narration 
										FROM students, standards, divisions, student_academic_years, 
										payments, standard_instalments, invoices
										WHERE standard_instalments.standard_instalment_id = '$instalment_id' 
										AND standard_instalments.standard_instalment_id = invoices.standard_instalment_id 
										AND invoices.invoice_id = payments.invoice_id 
										AND payments.status = 'PAYMENT-RECEIVED' 
										AND payments.student_id = student_academic_years.student_id 
										AND student_academic_years.student_id = students.student_id 
										AND students.division_id = divisions.division_id 
										AND students.status = 'ACTIVE'
										AND divisions.standard_id = standards.standard_id")->result_array();

				}
				
				if($_POST['btn'] == 'download_report'){
					$i=0;
					$reports_data = array();
					foreach ($data['student_data'] as $row){
						$i++;
						$reports_data[$i]['admission_no'] = $row['admission_no'];
						$reports_data[$i]['division'] = $row['division'];
						$reports_data[$i]['instalment_name'] = $row['instalment_name'];
						$reports_data[$i]['student_name'] = $row['student_name'];
						$reports_data[$i]['payment_date'] = swap_date_format($row['payment_date']);
						$reports_data[$i]['payment_mode'] = $row['payment_mode'];
						$reports_data[$i]['narration'] = $row['narration'];
						$reports_data[$i]['total_paid_amount'] = $row['total_paid_amount'];
					}
			
					$columns=array('Admission No.','Division', 'Instalment Name', 'Student Name', 'Payment Date', 'Mode', 'Narration',  'Amount' );
					export_to_csv("payments-received-report.csv",$columns,$reports_data);
				}
				else{
					$this->load->view ( "reports/payment_received_reports", $data);
				}
			}else{
				$data['student_data'] = array();
				$data['standards'] = $this->db->query("SELECT * FROM standards 
										WHERE academic_year_id = '$this->academic_id'")->result_array();

				$this->load->view ( "reports/payment_received_reports", $data);
			}
		}
		
	}
	
	public function download_staff_discount_report(){
	
		
		
			$reports_data = $this->db->query ( "SELECT  admission_no, CONCAT(student_firstname,' ',student_lastname) AS student_name, parent_name, parent_email_id, parent_mobile_no,
													secondary_email_id, secondary_mobile_no, SUM(invoice_amount) AS invoice_amount, SUM(discount_amount) AS discount_amount
													FROM students, divisions, invoices 
													WHERE divisions.division_id = students.division_id
													AND students.student_id = invoices.student_id 
													AND students.academic_year_id = '".$this->academic_id."'
													AND students.rte_provision = 'NO'
													AND invoices.discount_amount > 0
													GROUP BY invoices.student_id" )->result_array ();
		
			$columns=array('Admission No.', 'Student Name', 'Parent Name', 'Parent Email Id', 'Parent Mobile No.', 'Secondary Email Id', 'Secondary Mobile No.', 'Total Receivable Fees', 'Total Discount Given');
			export_to_csv("staff-discount-report.csv",$columns,$reports_data);
		
	}
	
	public function download_receivable_report(){
	
		$standard_id = $this->input->post ( "standard_id" );
		$standard_instalment_id = $this->input->post ( "instalment_id" );
	
		$this->form_validation->set_rules('standard_id', 'Standard', 'required',
				array('required'=>"Please select the Standard to download the report"));
		
		$this->form_validation->set_rules('instalment_id', 'Instalment', 'required',
				array('required'=>"Please select the Instalment to download the report"));
	
		if($this->form_validation->run() == false){
				
			$this->receivable_reports();
		}else{
			
			if($standard_id == 'all' && $standard_instalment_id == 'all'){
				$data = $this->db->query("SELECT admission_no, 
										CONCAT(student_firstname,' ',student_lastname) AS student_name, 
										CONCAT(standard_prefix, instalment_prefix,'-',students.student_id) 
										AS challan_no, due_date,late_fee, instalment_amount, staff_discount 
										FROM students, standards, divisions, invoices, standard_instalments 
										WHERE standard_instalments.standard_instalment_id = invoices.standard_instalment_id 
										AND invoices.student_id = students.student_id 
										AND students.division_id = divisions.division_id 
										AND divisions.standard_id = standards.standard_id
										AND students.status = 'ACTIVE'")->result_array();

			}else if($standard_id == 'all' && $standard_instalment_id != 'all'){
				$data = $this->db->query("SELECT admission_no, 
										CONCAT(student_firstname,' ',student_lastname) AS student_name, 
										CONCAT(standard_prefix, instalment_prefix,'-',students.student_id) 
										AS challan_no, due_date,late_fee, instalment_amount, staff_discount 
										FROM students, standards, divisions, invoices, standard_instalments 
										WHERE invoices.standard_instalment_id 
										IN (SELECT standard_instalment_id FROM standard_instalments 
											WHERE instalment_name IN 
												(SELECT instalment_name FROM standard_instalments 
												WHERE standard_instalment_id = '$standard_instalment_id')) 
										AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
										AND invoices.student_id = students.student_id 
										AND students.division_id = divisions.division_id 
										AND divisions.standard_id = standards.standard_id
										AND students.status = 'ACTIVE'")->result_array();

			}else if($standard_id != 'all' && $standard_instalment_id == 'all'){
				$data = $this->db->query("SELECT admission_no, 
										CONCAT(student_firstname,' ',student_lastname) AS student_name, 
										CONCAT(standard_prefix, instalment_prefix,'-',students.student_id) 
										AS challan_no, due_date,late_fee, instalment_amount, staff_discount 
										FROM students, standards, divisions, invoices, standard_instalments 
										WHERE invoices.standard_instalment_id 
											IN (SELECT standard_instalment_id FROM standard_instalments 
											WHERE standard_id = '$standard_id') 
										AND invoices.standard_instalment_id = standard_instalments.standard_instalment_id 
										AND invoices.student_id = students.student_id 
										AND students.division_id = divisions.division_id 
										AND divisions.standard_id = standards.standard_id
										AND students.status = 'ACTIVE'")->result_array();
			}else{
				$data = $this->db->query("SELECT admission_no, 
										CONCAT(student_firstname,' ',student_lastname) AS student_name, 
										CONCAT(standard_prefix, instalment_prefix,'-',students.student_id) 
										AS challan_no, due_date,late_fee, instalment_amount, staff_discount 
										FROM students, standards, divisions, invoices, standard_instalments 
										WHERE standard_instalments.standard_instalment_id = '$standard_instalment_id' 
										AND standard_instalments.standard_instalment_id = invoices.standard_instalment_id 
										AND invoices.student_id = students.student_id 
										AND students.division_id = divisions.division_id 
										AND divisions.standard_id = standards.standard_id
										AND students.status = 'ACTIVE'")->result_array();
			}
			$total_late_fees = 0;
			$i = 0;
			$current_date = new DateTime ( date ( "Y-m-d" ) );
			foreach ($data as $row){
				
				$due_date = new DateTime ( $row ['due_date'] );
				$interval = $current_date->diff ( $due_date );
				$late_days = $interval->format ( '%a' );
				
				if ($current_date > $due_date && $late_days > 0) {
					$total_late_fees = $late_days * $row ["late_fee"];
				}
				$total_amount = $total_late_fees + $row ['instalment_amount'] - round ( $row ['instalment_amount'] * $row ['staff_discount'] / 100 );
				
				$reports_data[$i]['admission_no'] = $row['admission_no'];
				$reports_data[$i]['student_name'] = $row['student_name'];
				$reports_data[$i]['challan_no'] = $row['challan_no'];
				$reports_data[$i]['receivable'] = $total_amount;
				$reports_data[$i]['late_fees'] = $total_late_fees;
				
				$i++;
			}
			

			$columns=array('Admission No.', 'Student Name', 'Challan No.', 'Challan Amount', 'Late Fees');
			export_to_csv("receivable-payment-report.csv",$columns,$reports_data);
		}
	}

	public function get_students(){

		$data['academic_year_data'] = $this->db->query("SELECT * 
										FROM academic_years")->result_array();

		$this->load->view('reports/get_all_students', $data);
	}

	public function download_student_data(){
		$academic_year_id = $this->input->post('academic_year_id');
		$standard_id = $this->input->post('standard_id');
		$division_id = $this->input->post('division_id');
		$status = $this->input->post("status");
		$rte_provision = $this->input->post("rte_provision");

		$this->form_validation->set_rules ( 'academic_year_id', 'Academic Year', 'required' );
		$this->form_validation->set_rules ( 'standard_id', 'Standard', 'required' );
		if($standard_id != 'all'){
			$this->form_validation->set_rules ( 'division_id', 'Division', 'required' );
		}
		
		if ($this->form_validation->run () == FALSE) {
			$this->get_students();
		} else {
			
			

			if($standard_id == 'all' && $division_id == 'all'){
				
				$student_data = $this->db->query("SELECT divisions.division_name, 
						standards.standard_name, academic_years.from_year,
						academic_years.to_year, students.* 
						FROM students, standards, divisions, academic_years
						WHERE students.academic_year_id = '$academic_year_id' 
						AND students.division_id = divisions.division_id 
						AND divisions.standard_id = standards.standard_id
						AND students.academic_year_id = academic_years.academic_year_id
						AND students.status = '$status'
						AND students.rte_provision = '$rte_provision'")->result_array();

			}else if($standard_id != 'all' && $division_id == 'all'){

				$student_data = $this->db->query("SELECT divisions.division_name, 
						standards.standard_name, academic_years.from_year,
						academic_years.to_year, students.* 
						FROM students, standards, divisions, academic_years
						WHERE divisions.standard_id = '$standard_id' 
						AND divisions.division_id = students.division_id
						AND divisions.standard_id = standards.standard_id
						AND students.academic_year_id = academic_years.academic_year_id
						AND students.status = '$status'
						AND students.rte_provision = '$rte_provision'")->result_array();

			}else if($standard_id != 'all' && $division_id != 'all'){

				$student_data = $this->db->query("SELECT divisions.division_name, 
							standards.standard_name, academic_years.from_year,
							academic_years.to_year, students.* 
							FROM students, standards, divisions, academic_years
							WHERE students.division_id = '$division_id' 
							AND students.division_id = divisions.division_id 
							AND divisions.standard_id = standards.standard_id
							AND students.academic_year_id = academic_years.academic_year_id
							AND students.status = '$status'
							AND students.rte_provision = '$rte_provision'")->result_array();

			}

			$i = 0;
			foreach ($student_data as $row) {
				$report_data[$i]['admission_no'] = $row['admission_no'];
				$report_data[$i]['academic_year'] = $row['from_year'].'-'.$row['to_year'];
				$report_data[$i]['admission_year'] = $row['admission_year'];
				$report_data[$i]['standard_name'] = $row['standard_name'];
				$report_data[$i]['division_name'] = $row['division_name'];
				
				$report_data[$i]['student_name'] = $row['student_firstname'].' '.$row['student_lastname'];
				$report_data[$i]['date_of_birth'] = $row['date_of_birth'];
				$report_data[$i]['gender'] = $row['gender'];
				$report_data[$i]['blood_group'] = $row['blood_group'];
				
				$report_data[$i]['parent_name'] = $row['parent_name'];
				$report_data[$i]['parent_email_id'] = $row['parent_email_id'];
				$report_data[$i]['secondary_email_id'] = $row['secondary_email_id'];
				$report_data[$i]['parent_mobile_no'] = $row['parent_mobile_no'];
				$report_data[$i]['secondary_mobile_no'] = $row['secondary_mobile_no'];
				
				$report_data[$i]['staff_discount'] = $row['staff_discount'];
				$report_data[$i]['notification'] = $row['notification'];
				$report_data[$i]['rte_provision'] = $row['rte_provision'];
				$report_data[$i]['address'] = $row['address'];
				$report_data[$i]['city'] = $row['city'];
				$report_data[$i]['state'] = $row['state'];
				$report_data[$i]['pincode'] = $row['pincode'];
			$i++;}

			$columns=array('Admission No.', 'Academic Year', 'Admissin Year', 'Standard',
				'Division', 'Student Name', 'Date of Birth', 'Gender', 'Blood Group',
				'Parent Name', 'Parent Email', 'Secondary Email', 'Parent Mobile','Secondary Mobile', 'Staff Discount', 'Notification Preference', 'RTE Provision',
				'Address', 'City', 'State', 'Pincode');
			export_to_csv("student-data.csv",$columns,$report_data);
		}

	}
	
	
	/**
	 * ** ajax function *****
	 */
	
	public function get_instalments() {
		$standard_id = $this->input->get ( 'standard_id' );
	
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

	public function get_standards(){
		$academic_year_id = $this->input->get ( 'academic_year_id' );
	
		$standards = $this->db->get_where ( 'standards', array (
								'academic_year_id' => $academic_year_id ))->result_array ();
	
		echo '<option value="">Select</option>';
		echo '<option value="all">All</option>';
		foreach ( $standards as $row ) {
			echo '<option value="' . $row ['standard_id'] . '">' . $row ['standard_name'] . '</option>';
		}	
	}

	public function get_divisions(){
		$standard_id = $this->input->get ( 'standard_id' );
	
		
		$divisions = $this->db->get_where ( 'divisions', array (
								'standard_id' => $standard_id ))->result_array ();
	
		echo '<option value="">Select</option>';
		echo '<option value="all">All</option>';
		foreach ( $divisions as $row ) {
			echo '<option value="' . $row ['division_id'] . '">' . $row ['division_name'] . '</option>';
		}	
	}
}