<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Simpleexcel {
	protected $CI;
	public function __construct() {
		// Do something with $params
		$this->CI = & get_instance ();
	}
	public function read_excel($excel_file_path, $sheet_no = 1) {
		include 'third_party_classes/simplexlsx.class.php';
				
		$xlsx = new SimpleXLSX ( $excel_file_path );
		list ( $cols, $rows ) = $xlsx->dimension ();
		return $xlsx->rows ();
	}
}