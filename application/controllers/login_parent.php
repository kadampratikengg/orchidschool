<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_parent extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
	}
	
	public function index()
	{


		$generated_code = md5($this->session->userdata('user_id').my_secret_key.$this->session->userdata('email_id'));
		if($generated_code == $this->session->userdata('my_secure_code'))
		{
            if($this->session->userdata("account_type")=="STAFF")
			 redirect(base_url('dashboard'));	
            else
             redirect(base_url('student_dashboard'));	
		}
		else
			$this->load->view('login_parent/default');
	}
	
	public function send_otp(){
		
		$this->form_validation->set_rules ( 'mobile_no', 'Mobile Number', 'required|numeric');
		
		if ($this->form_validation->run () == FALSE) {
			
			$this->index ();
		} else {
			
			$mobile_no = $this->input->post('mobile_no');
			
			$query = $this->db->query("SELECT * FROM students WHERE 
										status = 'ACTIVE' AND rte_provision = 'NO' AND 
										parent_mobile_no = '".$mobile_no."'");
			
			if($query->num_rows()>0){
				
				$otp = random_string ( 'numeric', 4 );
				$this->session->set_userdata('otp', $otp);
				$this->session->set_userdata('mobile_no', $mobile_no);
					
				$mobile_no = $mobile_no;
			
				//$msg = "Dear Parent, OTP for login is ".$otp." -The Orchid School";
				$msg ="Dear Parent, OTP for login is ".$otp."-
The Orchid School";

				send_sms( $mobile_no, $msg );

				$this->log_model->write_log("OTP Generated", "OTP ($otp) Sent to $mobile_no");
				
				$this->load->view('login_parent/otp_login');
			}else{
				
				$this->session->set_flashdata('error_message', "Entered mobile no. is either not registered or student is not active");
				redirect(base_url('login_parent'));
			}
			
		}
	}
	
	public function verify_otp(){
		
		$this->form_validation->set_rules ( 'otp', 'OTP', 'required');
		
		if ($this->form_validation->run () == FALSE) {
				
			$this->load->view('login_parent/otp_login');
		} else {
			
			if($this->session->userdata('otp') == $this->input->post('otp')){
				
				$mobile_no = $this->session->userdata('mobile_no');
				$student_query = $this->db->query("SELECT * FROM students WHERE 
						status = 'ACTIVE' AND rte_provision = 'NO' AND 
						parent_mobile_no = '".$mobile_no."'");
				
				if($student_query->num_rows()>1){
					
					
					$data['students']=$student_query->result_array();
					$authenticated_student_ids = array();
					foreach ($data['students'] as $row){
						$authenticated_student_ids[]=md5($row['student_id']);
						
						 
					}
					$this->session->set_userdata('authenticated_student_ids',$authenticated_student_ids);
					$this->load->view('login_parent/grant_access',$data);
					
				}else{
					$student_data = $student_query->row_array();
					
					//write log
					$this->log_model->write_log("OTP Verified - Fetch Student Data", "Session OTP (".$this->session->userdata('otp')."), input OTP (".$this->input->post('otp').")  Sent to $mobile_no verified and login success.");
					
					if($student_data['parent_email_id']=='' || $student_data['parent_email_id']=='0'){
					     $this->session->set_flashdata('error_message','Login Failed!, Email Id not found in records. Please contact school authority to update your email Id');
											redirect(base_url());
					}
					$this->db->select('*');
					$this->db->from('users');
					$this->db->where(array("email_id"=>$student_data['parent_email_id'], "status"=>'ACTIVE'));
					$data=$this->db->get()->row_array();
					
					//write log
					$this->log_model->write_log("OTP Verified - Fetch User Data ");
					
					if(count($data)==0)
					{
						
						$this->session->set_flashdata('error_message','Your login is inactive, please contact school authority');
						redirect(base_url());
					}
					else {
						
						$this->session->set_userdata('user_id',$data['user_id']);
						$this->session->set_userdata('student_id',$student_data['student_id']);
						$this->session->set_userdata('email_id',$data['email_id']);
						$this->session->set_userdata('mobile',$mobile_no);
						$this->session->set_userdata('first_name',$student_data['student_firstname']);
						$this->session->set_userdata('last_name',$student_data['student_lastname']);
						$this->session->set_userdata('current_academic_year_id',$student_data['academic_year_id']);
						$this->session->set_userdata('account_type',"STUDENT");
						$this->session->set_userdata('my_secure_code',md5($data['user_id'].my_secret_key.$data['email_id']));
						
						//write log
						$this->log_model->write_log("Login Success", "Session OTP (".$this->session->userdata('otp')."), input OTP (".$this->input->post('otp').")  Sent to $mobile_no verified and login success.");

						redirect(base_url('student_dashboard'));
					}

				}
				
				
			}else{
				$this->log_model->write_log("OTP Verification Failed", "Session OTP (".$this->session->userdata('otp')."), input OTP (".$this->input->post('otp').") Sent to ".$this->session->userdata('mobile_no')." not verified.");
				$this->session->set_flashdata('error_message', "Invalid OTP");
				$this->load->view('login_parent/otp_login');
			}
		}
	}
	
	public function grant_access($student_id){
		
		if (in_array($student_id, (array)$this->session->userdata('authenticated_student_ids'))) {
			
			$student_data = $this->db->query("SELECT * FROM students WHERE
						md5(student_id) = '".$student_id."'")->row_array();
			
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where(array("md5(student_id)"=>$student_id, "status"=>'ACTIVE'));
			$data=$this->db->get()->row_array();
			
			if(count($student_data)>0 & count($data)>0){
				$this->session->set_userdata('user_id',$data['user_id']);
				$this->session->set_userdata('student_id',$data['student_id']);
				$this->session->set_userdata('email_id',$data['email_id']);
				$this->session->set_userdata('mobile',$student_data['parent_mobile_no']);
				$this->session->set_userdata('first_name',$student_data['student_firstname']);
				$this->session->set_userdata('last_name',$student_data['student_lastname']);
				$this->session->set_userdata('current_academic_year_id',$student_data['academic_year_id']);
				$this->session->set_userdata('account_type',"STUDENT");
				$this->session->set_userdata('my_secure_code',md5($data['user_id'].my_secret_key.$data['email_id']));
					
				redirect(base_url('student_dashboard'));
			}else{
				$this->session->set_flashdata('error_message', "Invalid Link");
				redirect(base_url('login_parent'));
			}
			
		}else{
			$this->session->set_flashdata('error_message', "Invalid Link.");
			redirect(base_url('login_parent'));
		}

		
	}
}