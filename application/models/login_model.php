<?php
class Login_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function validate_user_login($account_type)
	{
		$generated_code=md5($this->session->userdata('user_id').my_secret_key.$this->session->userdata('email_id'));
        
		if($generated_code!=$this->session->userdata('my_secure_code'))
		{
			$this->session->set_flashdata('error_message','Login to access your account');
			redirect(base_url());
            
		}else if($this->session->userdata('account_type')!=$account_type){
            
            $this->session->set_flashdata('error_message',"You don't have previledges to access this page.");
			if($this->session->userdata("account_type")=="STAFF")
			 redirect(base_url('dashboard'));	
            else
             redirect(base_url('student_dashboard'));	
        }else
            return true;
		
	}
    
    function get_academic_years()
    {
        if($this->session->userdata('account_type')=='STUDENT'){
            
            $data["academic_years"] = $this->db->query("select * from academic_years, student_academic_years where
                                        academic_years.academic_year_id = student_academic_years.academic_year_id
                                        AND student_id = '".$this->session->userdata('student_id')."'")->result_array(); 
            
        }else{
            
            $data["academic_years"] = $this->db->query("SELECT * FROM academic_years")->result_array();    
        }
        return $data["academic_years"];
        
    }
	
	

}
?>