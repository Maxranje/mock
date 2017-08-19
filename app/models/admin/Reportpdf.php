<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportpdf extends CI_Model {
	
	public function __construct () {
		parent::__construct ();	
		$this->load->database();
		$this->load->library('mpdf/mpdf');
		$this->data = array('state'=>'success', 'reson'=>'Mission Complete');
	}

	public function report (){
		$smid = $this->input->get('id');
		if(!$smid){
			throw new Exception("参数不正确");
		}
		$query = "select i.*, t.* from mock_student_info i, mock_student_tpo t where t.sid = i.sid and t.smid = ?";
		$res = $this->db->query ($query, array($smid));
		if($res->num_rows () == 0){
			throw new Exception("无法获取学生数据");
		}
		$student = $res->row_array();
		$this->data['student'][] = array();
		$this->data['student']['sid'] 		= str_pad($student['sid'], 14, "0", STR_PAD_LEFT) ;
		$this->data['student']['id']	 	= $student['smid'];
		$this->data['student']['name'] 		= $student['student_name'];
		$this->data['student']['time'] 		= date('r', $student['createtime']);
		$this->data['student']['read'] 		= $student['readscore'];
		$this->data['student']['listen'] 	= $student['listenscore'];
		$this->data['student']['speak'] 	= $student['speakscore'];
		$this->data['student']['write'] 	= $student['writescore'];	
		$this->data['student']['canvas'] 	= $student['canvas'];			
		$this->data['item'] = array();

		$query = "select a.*,i.* from mock_tpo_item i left join mock_student_answer a on a.qid = i.qid and a.smid = ? where i.is_question = '1' and type = 'r' order by i.qid";
		$res = $this->db->query ($query, array($smid));
		$result = $res->result_array();
		foreach ($result as $row) {
			$array = array();
			$array['id'] 				= $row['id'];
			$array['type'] 				= $row['type'];
			$array['question'] 			= $row['question_json'];
			$array['student_answer']	= $row['student_answer'] == "" ? "/" : $row['student_answer'];
			$array['student_score'] 	= $row['student_score'];
			$array['student_comments'] 	= $row['student_comments'];
			$array['right_answer'] 		= $row['right_answer'];
			$array['student_time'] 		= $row['mock_starttime'] - $row['mock_endtime'];
			if($student['statment'] == "0"){
				$this->data['student']['read'] += $row['student_score'];
			}		
			$this->data['item'][] = $array;
		}


		$query = "select a.*,i.* from mock_student_answer a left join mock_tpo_item i on i.qid = a.qid and type != 'r' where a.smid = ?";
		$res = $this->db->query ($query, array($smid));
		$result = $res->result_array();
		foreach ($result as $row) {
			$array = array();
			$array['id'] 				= $row['id'];
			$array['type'] 				= $row['type'];
			$array['question'] 			= $row['question_json'];
			$array['student_answer']	= $row['student_answer'];
			$array['student_score'] 	= intval($row['student_score']);
			$array['student_comments'] 	= $row['student_comments'];
			$array['right_answer'] 		= $row['right_answer'];
			$array['student_time'] 		= $row['mock_starttime'] - $row['mock_endtime'];
			if($student['statment'] == "0"){
				if($row['type'] == 'l'){
					$this->data['student']['listen'] += $row['student_score'];
				}										
			}		
			$this->data['item'][] = $array;
		}		

		$this->load->view('adc/pdf',$this->data);
		$html = $this->output->get_output();
		$this->mpdf->autoScriptToLang = true;
		$this->mpdf->autoLangToFont = true;
		$this->mpdf->SetDisplayMode('fullpage');
		$this->mpdf->SetHTMLHeader('<div style="text-align: right;"><img src="/res/images/logo_a.png" style="width: 47px; height: 20px; display: inline-block;"></div>');
		$this->mpdf->WriteHTML($html); 
		$this->mpdf->Output(); 
	}
}