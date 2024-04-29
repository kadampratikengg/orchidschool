<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{

	var $user_id;
	var $academic_id;
	public function __construct()
        {
        	
                parent::__construct();
                // Your own constructor code
                $this->login_model->validate_user_login ( "STAFF" );
                    
                $this->user_id=$this->session->userdata('user_id');
                $this->academic_id=$this->session->userdata('current_academic_year_id');
        }
	
	public function index($instalment_prefix = null)
	{
		if ($instalment_prefix == null) {
			$instalment_prefix = $this->input->get ( 'instalment_prefix' );
		}
		
		if ($instalment_prefix == "") {
			
			$data['fees_data'] = $this->db->query("SELECT sum(invoice_amount) AS invoice_amount, sum(paid_amount)
													AS paid_amount, sum(outstanding_amount) AS outstanding_amount, sum(discount_amount) AS discount_amount   
													FROM invoices WHERE academic_year_id = '".$this->academic_id."' ")->row_array();
		} else {
			
			$data['fees_data'] = $this->db->query("SELECT SUM(invoice_amount) AS invoice_amount, SUM(discount_amount) AS discount_amount, 
													SUM(paid_amount) AS paid_amount, SUM(outstanding_amount) AS outstanding_amount 
													FROM invoices WHERE standard_instalment_id 
													IN (SELECT standard_instalment_id FROM standard_instalments 
													WHERE instalment_prefix = '{$instalment_prefix}')")->row_array();
		}
		
		$students = $this->db->query("SELECT count(student_id) as count FROM students
										WHERE academic_year_id = '{$this->academic_id}'
										AND status = 'ACTIVE'")->row_array();
		$data['total_students']=$students['count'];
		
		$students = $this->db->query("SELECT count(student_id) as count FROM students
										WHERE academic_year_id = '{$this->academic_id}' AND rte_provision ='YES'
										AND status = 'ACTIVE'")->row_array();
		$data['total_rte_students']=$students['count'];
		
		$data['divisions'] = $this->db->query("SELECT division_id, division_name, standard_name, 
												(select count(student_id) from students where status = 'ACTIVE' 
												AND division_id = d.division_id) as student_count
												FROM divisions d, standards s
												WHERE s.standard_id = d.standard_id AND
												d.academic_year_id = '{$this->academic_id}' ")->result_array();
		
		$data['instalments']  = $this->db->query("SELECT DISTINCT instalment_prefix FROM standard_instalments 
													WHERE academic_year_id = '{$this->academic_id}'")->result_array();
		
		$data['instalment_prefix'] = $instalment_prefix;
		
		$this->load->view('dashboard/default',$data);
		
		//writ log
		$this->log_model->write_log("Admin Dashboard Visited");
	}
	
	public function search_students_source(){
		
		$search_term =  $this->input->post("search_term");
		if($search_term!="")
			$condition = " AND concat(student_firstname, student_lastname, admission_no) like '%".$search_term."%'";
		else 	
			$condition="";
		
		$students= $this->db->query("select student_id, student_firstname, student_lastname, admission_no from students where
				academic_year_id = '".$this->academic_id."' AND status ='ACTIVE' ". $condition." LIMIT 0,10")->result_array();
		
		$search_result=array();
		foreach ($students as $student){
			$search_result[]=array(
					"name"=>$student["admission_no"]." - ".$student["student_firstname"]." ".$student["student_lastname"],
					"id"=>$student["student_id"]
			);
		}
		echo json_encode($search_result);
	}
	
	
	public function student_history(){
		redirect("students/view/".$this->input->post("search_student_id"));
	}
}