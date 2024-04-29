<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function get_config_value($config_name)
	{
		$CI =& get_instance();
		$config=$CI->db->get_where("config", array("config_name"=>$config_name))->row_array();
	
		if(count($config)>0)
		{
			return $config["config_value"];
		}
		else
		{
			return "";
		}
	}
	
	function clean_url($string) {
		$string = str_replace('_', '-', $string); // Replaces all underscores with hyphens.
	
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}


	function my_send_email($email_to, $subject, $message, $replace_variables = NULL) {
    
    	$CI = & get_instance ();
    	
    	$email_config ['mailtype'] = 'html';
    	$email_config ['charset'] = 'utf-8';
    	$CI->email->clear ();
    	$CI->email->initialize ( $email_config );
    	$CI->email->from(get_config_value("system_from_email_id"),get_config_value("system_from_email_name"));
    	$CI->email->to ( $email_to );
    	$CI->email->subject ( $subject );
    	$CI->email->message ( $message );
//    	$CI->email->send (); 
    
    	$text = "To Email:" . $email_to . ' | Time:' . date ( "d m,Y h:i: A" ) . ' | Subject:' . $subject;
    	$text .= "<br>" . $message;
    	$text .= "<br>----------------------------------------------------------------------------<br>";
    	$text .= read_file ( "site_data/email.html" );
    
    	write_file ( "site_data/email.html", $text);
    	// echo $CI->email->print_debugger(); exit;
    }
	
   function send_sms($mobile,$msg,$replace_variables=NULL)
    {
    	
    		if(is_array($replace_variables)) {
    			foreach($replace_variables as $key=>$value){
	    			$msg=str_replace("[".$key."]",$value,$msg);
	    		}
    		}
    			
    	 	$CI = & get_instance();
    		$CI->load->library('curl');
    		//$ch = curl_init();
    			
    		
    		$apiKey="AgNf4cyHvjg-qFWlmGF2JG7p6Jm8pTAnAvNOuQyOwR";
    		$from="ORCHID";
    		$msg = rawurlencode($msg);	
    		
    		$api_url="http://sms.prakrut.com/api/sendhttp.php?authkey=106293Aaj6UJ3O56d89a8b&mobiles=$mobile&message=$msg&sender=ORCHID&route=4";
    		
            //$api_url="http://sms.fastsms.co.in/submitsms.jsp?user=orchidtr&key=a04f89bd5eXX&mobile=$mobile&message=$msg&senderid=FSTSMS&accusage=1";
            
            //old sms gateway
			//$api_url="https://api.textlocal.in/send/?username=virendra@angularminds.com&hash=879fc5b6469bd77c1961ec1fcaa7177cd705682abc40e54b9cd175395ab20639&sender=ORCHID&numbers=$mobile&message=$msg"; 
			$ch= curl_init();
			curl_setopt($ch, CURLOPT_URL,$api_url);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			  

			$response = curl_exec($ch);
			$err_status = curl_error($ch);
			
			curl_close($ch);

 		   $text="Mobile No:".$mobile.' | Time:'.date("d m,Y h:i: A");
    		$text.="<br>".$msg;
    		$text.="<br>----------------------------------------------------------------------------<br>";
    		$text.=read_file("site_data/sms.html");
    			
    		write_file("site_data/sms.html", $text);
    }
    
/*
    function send_sms($mobile,$msg,$replace_variables=NULL)
    {
    	   $CI = & get_instance();
    		$CI->load->library('curl');
      	// Account details
			$apiKey = urlencode('AgNf4cyHvjg-qFWlmGF2JG7p6Jm8pTAnAvNOuQyOwR');
			
			// Message details
			$numbers = array(9923195945);
			$sender = urlencode('ORCHID');
			$message = rawurlencode('Dear Parent, Text3445-
The Orchid School');
		 
			$numbers = implode(',', $numbers);
		 
			// Prepare data for POST request
			$data = array('username'=>'virendra@angularminds.com','hash'=>'316f8524f76eb88b9512927ae5e0c9d05e21b63c63591f6217987f0bed50eaf4', 'numbers' => $numbers, "sender" => $sender, "message" => $message);
		 
			// Send the POST request with cURL
			$ch = curl_init('https://api.textlocal.in/send/');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			
			// Process your response here
			echo $response;
			exit;
    }*/

    function swap_date_format($arr)
    {
    	if($arr==NULL)
    		return false;
    		
    	$found=strpos($arr,'/');
    	if($found===false)
    	{
    		$char='-';
    	}
    	else
    	{
    		$char='/';
    	}
    	$dte=explode($char,$arr);
    	$newdte[0]=$dte[2];
    	$newdte[1]=$dte[1];
    	$newdte[2]=$dte[0];
    	$arr=implode('-',$newdte);
    	
    	return $arr;
    }
    
	function generate_pdf($html,$file_name="pdf_document.pdf",$orientation="portrait"){
	
		// Check if magic_quotes_runtime is active
		require_once ("dompdf/dompdf_config.inc.php");
	
		ini_set ( "memory_limit", "50M" );
		$dompdf = new DOMPDF ();
		
		$dompdf->set_paper("a4", $orientation);
		 
		$dompdf->load_html ( $html );
		$dompdf->render ();
		$dompdf->stream ( $file_name );
		exit ( 0 );
	}
	
	
	/* convert amount to words in rupees */
	function number_to_rupees($no)
	{
		if(strpos($no, '.'))
		{
			$no_array=explode('.',$no);
			//	 print_r($no_array);
			$rupees=convert_to_words($no_array[0]);
			if((int)$no_array[1]!=0)
			{
	
				$paise=convert_to_words($no_array[1]);
				return ucwords($rupees.' Rupees and '.$paise.' Paise Only');
			}
			else
				return ucwords($rupees.' Rupees Only');
	
		}
		else
		{
			$rupees=convert_to_words($no);
			return ucwords($rupees.' Rupees Only');
		}
	}
	
	/* function used by above function */
	function convert_to_words($no)
	{
	
		$words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
			
		if($no == 0)
			return ' ';
		else {
			$novalue='';
			$highno=$no;
			$remainno=0;
			$value=100;
			$value1=1000;
			while($no>=100)    {
				if(($value <= $no) &&($no  < $value1))    {
					$novalue=$words["$value"];
					$highno = (int)($no/$value);
					$remainno = $no % $value;
					break;
				}
				$value= $value1;
				$value1 = $value * 100;
			}
			if(array_key_exists("$highno",$words))
				return ucwords($words["$highno"]." ".$novalue." ".convert_to_words($remainno));
			else {
				$unit=$highno%10;
				$ten =(int)($highno/10)*10;
				return ucwords($words["$ten"]." ".$words["$unit"]." ".$novalue." ".convert_to_words($remainno));
			}
		}
	
	}
	
	function export_to_csv($file_name,$colums,$data_array)
	{
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$file_name);
	
		$output = fopen('php://output', 'w');
	
		fputcsv($output, $colums);
		fputcsv($output, array('','','','','','',''));
		foreach($data_array as $row)
		{
			fputcsv($output, $row);
		}
	}
?>