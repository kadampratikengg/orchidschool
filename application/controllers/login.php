<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
			$this->load->view('login/default');
	}
	
	public function checklogin()
	{
		$username=$this->input->post('email_id');
		$password=$this->input->post('password');
		
		$conditions = array("email_id"=>$username,
							"password"=>md5($password),
							"status"=>'ACTIVE');
					
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($conditions); 
		$data=$this->db->get()->row_array();
	
		if(count($data)==0)
		{
			$this->session->set_flashdata('error_message','Enter correct email and password');
			redirect(base_url('login'));
		}
		else
		{
			 if($data['account_type'] =="STUDENT"){
			 	/* $student_data = $this->db->query("select * from students where student_id = '".$data['student_id']."'")->row_array();
			 	
			 	$this->session->set_userdata('user_id',$data['user_id']);
			 	$this->session->set_userdata('student_id',$data['student_id']);
			 	$this->session->set_userdata('email_id',$data['email_id']);
			 	$this->session->set_userdata('first_name',$student_data['student_firstname']);
			 	$this->session->set_userdata('last_name',$student_data['student_lastname']);
			 	$this->session->set_userdata('current_academic_year_id',$student_data['academic_year_id']);
			 	$this->session->set_userdata('account_type',"STUDENT");
			 	$this->session->set_userdata('my_secure_code',md5($data['user_id'].my_secret_key.$data['email_id'])); */
			 	
			 	$this->session->set_flashdata('error_message','Unauthorized user');
			 	redirect(base_url('login_parent'));
			 	
			 }
			 else{
			 	//staff login
			 	$staff_data = $this->db->query("select * from staff where staff_id = '".$data['staff_id']."'")->row_array();
			 	$academic_year_data = $this->db->query("select * from academic_years where current_academic_year = 'YES' ")->row_array();
			 	
			 	$this->session->set_userdata('user_id',$data['user_id']);
			 	$this->session->set_userdata('student_id',"");
			 	$this->session->set_userdata('mobile',"");
			 	$this->session->set_userdata('staff_id',$data['staff_id']);
			 	$this->session->set_userdata('email_id',$data['email_id']);
			 	$this->session->set_userdata('first_name',$staff_data['first_name']);
			 	$this->session->set_userdata('last_name',$staff_data['last_name']);
			 	$this->session->set_userdata('current_academic_year_id',$academic_year_data['academic_year_id']);
			 	$this->session->set_userdata('account_type',"STAFF");
			 	$this->session->set_userdata('my_secure_code',md5($data['user_id'].my_secret_key.$data['email_id']));
			 	
			 	//write log
			 	$this->log_model->write_log("Admin Login");
			 	redirect(base_url('dashboard'));
			 }
			 
			 //redirect(base_url().'dashboard');
		}
	}
	
	function change_password()
	{
		$response['title']="Change Password";
		$response['body']=$this->load->view('login/change_password','',true);
		echo json_encode($response);
	}
	
	public function update_password()
	{
		extract($_POST);
		
		$array_validate=array(
			 array(
                     'field'   => 'current_password',
                     'label'   => 'Current Password',
                     'rules'   => 'required|callback_check_password[$password]'
                  ),
			array(
                     'field'   => 'new_password',
                     'label'   => 'New Password',
                     'rules'   => 'required|min_length[6]|matches[confirm_password]'
                  ),	  
			
			array(
                     'field'   => 'confirm_password',
                     'label'   => 'Confirm Password',
                     'rules'   => 'required|min_length[6]'
                  )
			
		);
		
		$this->form_validation->set_rules($array_validate); 
		if ($this->form_validation->run() == FALSE)
		{
			$result["status"]="error";
			$result["message"]=validation_errors();
		}
		else
		{
			$user_id=$this->session->userdata('user_id');
			$this->db->update("users", array("password"=>md5($new_password)),array("user_id"=>$user_id));
			$result["status"]="success";
			$result["message"]="Record updated successfully.";	
			//redirect(base_url('student_dashboard'));
		}
				
		echo json_encode($result);
	}
	
	
	public function logout()
	{
		$this->log_model->write_log($this->session->userdata('account_type')." Logged Out");
		
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('student_id');
		$this->session->unset_userdata('email_id');
		$this->session->unset_userdata('first_name');
		$this->session->unset_userdata('last_name');
		$this->session->unset_userdata('my_secure_code');
		$this->session->unset_userdata('otp');
		$this->session->unset_userdata('authenticated_student_ids');
		
		$this->session->set_flashdata('success_message','You are logged out successfully.');
		
		if($this->session->userdata('account_type') == "STUDENT"){
			$this->session->sess_destroy();
			redirect(base_url('login_parent?action=logout'));
		}else{
			$this->session->sess_destroy();
			redirect(base_url('login?action=logout'));
		}
	}
	
	public function forgot_password()
	{
		$this->load->view('login/forgot_password');
	}
	
    public function send_reset_link()
	{
		
		$this->form_validation->set_rules("email_id","Email","required|valid_email");
		if($this->form_validation->run()==false)
		{
			$this->forgot_password();
		}
		else
		{
			$email_id = $this->input->post('email_id');
			
			$user=$this->db->get_where("users", array("email_id"=>$email_id,"status"=>"ACTIVE"))->row_array();
			if(count($user)==0)
			{
				$this->session->set_flashdata("error_message","There is no account associated with entered email Id, contact administrator for more details.");
				redirect(base_url('login/forgot_password'));
			}
			else
			{
				$link=base_url().'login/validate_email/'.md5(my_secret_key.$user['email_id']).'/'.urlencode($user['email_id']).'';
				
				$data["reset_link"]=$link;				
				
				if($user['account_type']=="STAFF"){
					$account_data = $this->db->query("select concat(first_name, ' ', last_name) as name from staff where staff_id = '".$user['staff_id']."'")->row_array();
				}else{
					$account_data = $this->db->query("select concat(student_firstname, ' ', student_lastname) as name from students where student_id = '".$user['student_id']."'")->row_array();
				}
				$data["name"] = $account_data['name'];
				$email_message=$this->load->view('_mail_templates/reset_password',$data, true);
				$subject= get_config_value("website_name")." Account Reset Password Instructins"; 
				
				my_send_email($email_id,$subject,$email_message);
				
				$this->session->set_flashdata("success_message","Email with reset password instructions has been sent to your email Id.");
				redirect(base_url("login"));
			}
		}
	}
	
	function validate_email($code="",$email=NULL)
	{
		$email=urldecode($email);
		$result=$this->db->get_where("users", array("md5(CONCAT('".my_secret_key."', email_id)) ="=>$code,'email_id'=>$email));
		
		if($result->num_rows()==0)
		{
			$this->session->set_flashdata("error_message","Link is Invalid");
			redirect(base_url());
		}
		else
		{
			$data["email_id"]=$email;
			$data["code"]=$code;
			$this->load->view('login/reset_password',$data);
		}
	}
	
	function reset_password($code="",$email=NULL)
	{
		$email=urldecode($email);
		$result=$this->db->get_where("users", array("md5(CONCAT('".my_secret_key."', email_id)) ="=>$code,'email_id'=>$email));
		if($result->num_rows()==0)
		{
			$this->session->set_flashdata("error_message","Link is Invalid");
			redirect(base_url());
		}
		else
		{
			$this->form_validation->set_rules("password","Password","required|min_length[6]");
			$this->form_validation->set_rules("confirm_password","Confirm Password","required|matches[password]");
			if($this->form_validation->run()==false)
			{
				$this->validate_email($code,$email);
			}
			else
			{
		
				$password=$this->input->post('password');
				$this->db->update("users", array("password"=>md5($password)), array("email_id"=>$email));
				
				$this->session->set_flashdata("success_message","Your password has been changed successfully.");
				redirect(base_url("login"));
			}
		}
	}
    
    function change_current_academic_year(){
        
        if($this->input->post('workspace_academic_id')!=''){
            $this->session->set_userdata('current_academic_year_id',$this->input->post('workspace_academic_id'));
            
        }
        if($this->session->userdata("account_type")=="STAFF")
			 redirect(base_url('dashboard'));	
            else
             redirect(base_url('student_dashboard'));	
    }
    
    /**
     * *** Call back functions ***
     */
    
    function check_password($password)
    {
    	$user_id=$this->session->userdata('user_id');
    	$password=md5($this->input->post('current_password'));
    	$query=$this->db->query("SELECT password FROM users WHERE user_id='".$user_id."'")->row_array();
    	if ($password != $query['password'])
    	{
    		$this->form_validation->set_message('check_password', 'Current password is incorrect');
    		return FALSE;
    	}
    	else
    	{
    		return TRUE;
    	}
    }
	
	
}