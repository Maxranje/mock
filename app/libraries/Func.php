<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Func {

	public function __construct (){
		$this->ci = &get_instance ();
		$this->db = $this->ci->db;
	}

	public function update_student_progress ($sn = 0) {
		if($sn == 46){
			$sql = "update mock_student_tpo set serialnumber = ?, progress = 42 where smid = ? and state = 2 ";	
		}else{
			$sql = "update mock_student_tpo set serialnumber = ?, progress = progress+1 where smid = ? and state = 2 ";
		}
		$res = $this->db->query ($sql, array($sn, $_SESSION['smid']));
	}
}