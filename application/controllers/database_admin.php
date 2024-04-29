<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Database_admin extends CI_Controller{
 public function index(){
  echo '<pre>';
  //print_r(sys_getloadavg ( ));
 }
 
 public function download_logs(){
  
  $this->db->order_by("log_id","desc");
  $logs=$this->db->get("logs")->result_array();
  
  $columns=array('Log Id', 'Title', 'Description', 'Student Id', 'User Id', 'Staff Id', 'Mobile No', 'User Agent',    
  'Current Url','Session Data',"Session id", "Last Query","Entry On","Date Time");
  
  export_to_csv("logs.csv",$columns,$logs);
 }
 
 public function download_payments(){
  $this->db->order_by("payment_id","desc");
  $logs=$this->db->get("payments")->result_array();
  
  $columns=array('payment_id', 'invoice_id', 'student_id', 'academic_year_id', 'payment_type', 
    'payment_mode', 'online_payment_mode', 'online_payment_charges', 'narration', 'transaction_no',
     'payment_date', 'payment_amount', 'late_fee_amount', 'total_paid_amount', 'status', 'entry_on', 'entry_by');
  
  export_to_csv("payments.csv",$columns,$logs);
 }
 
 public function download_invoices(){
  $this->db->order_by("invoice_id","desc");
  $logs=$this->db->get("invoices")->result_array();
 
  $columns=array('invoice_id', 'student_id', 'academic_year_id', 'standard_instalment_id', 'other_fee_id', 'description',
     'invoice_type', 'invoice_date', 'invoice_amount', 'discount_amount', 'paid_amount', 'outstanding_amount',
     'status', 'entry_on', 'entry_by');
 
  export_to_csv("invoices.csv",$columns,$logs);
 }
 
 public function download_students(){
  
  $logs=$this->db->get("students")->result_array();
 
  $columns=array('student_id', 'division_id', 'academic_year_id', 'admission_no', 'student_firstname', 'student_lastname', 
    'gender', 'date_of_birth', 'blood_group', 'address', 'city', 'state', 'pincode', 'admission_year', 'parent_name',
     'parent_email_id', 'secondary_email_id', 'parent_mobile_no', 'secondary_mobile_no', 'staff_discount',
     'notification', 'withdraw_reason', 'withdraw_date', 'rte_provision', 'status', 'entry_on', 'entry_by');
 
  export_to_csv("students.csv",$columns,$logs);
 } 
 
 public function download_users(){
 
  $logs=$this->db->get("users")->result_array();
 
  $columns=array('user_id', 'student_id', 'staff_id', 'email_id', 'password', 'account_type', 'status', 'entry_on', 'entry_by');
 
  export_to_csv("users.csv",$columns,$logs);
 }
 
}