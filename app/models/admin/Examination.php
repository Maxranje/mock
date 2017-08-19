<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Examination extends CI_Model {
	
	public function __construct () {
		parent::__construct ();	
		$this->load->database();
		$this->load->library ('Func');
		$this->data = array('state'=>'success', 'reson'=>'Mission Complete');
	}

	public function index (){
		$query = 'select count(*) mockcount, sum(totaltime) totaltime, sum(mock_stun_count) countstun from mock';
		$res = $this->db->query ($query);
		$result = $res->row_array();
		$this->data['mockcount'] = intval($result['mockcount']);
		$this->data['totaltime'] = intval($result['totaltime']);
		$this->data['countstun'] = intval($result['countstun']);

		$sql = 'select count(*) as tponum from mock_tpo';
		$res = $this->db->query ($sql);
		$result = $res->row_array();
		$this->data['tponum'] = $result['tponum'];
		$this->load_view('adc/dashboarts', $this->data);
	}
	
	public function examination (){
		if(isset($_SESSION['mid']) && !empty($_SESSION['mid'])){
			$this->load_view('adc/stop', $this->data);	
		}
		$res = $this->db->query ("select * from mock where state = '1'");
		if($res && $res->num_rows() > 0){
			$result = $res->row_array();
			$_SESSION['mid'] = $result['mid'];
			$this->load_view('adc/stop');	
		}
		$res = $this->db->query ("select * from mock_tpo where state = '1'");
		$this->data['tpo']	= $res->result_array();
		$this->load_view('adc/start', $this->data);
	}

	
	public function monitor (){
		try{
			if(!isset($_SESSION['mid']) && empty($_SESSION['mid'])){
				show_error('mid does not exit');
			}
			$query = "select i.sid,i.student_name, t.* from mock_student_info i, mock_student_tpo t 
				where i.sid = t.sid and t.mid = ? and i.valid = '1' ";
			$res = $this->db->query ($query, array($_SESSION['mid']));
			if($res->num_rows () == 0){
				throw new Exception("暂无学生考试, 或已经全部考完");
			}
			$result = $res->result_array();
			$this->data['student'] = array();
			foreach ($result as $row ) {
				$array = array();
				$array ['sid'] = $row['sid'];
				$array ['smid'] = $row['smid'];
				$array ['name'] = $row['student_name'];
				$array ['progress'] = number_format($row['progress'] / 84, 2) * 100;
				$array['read'] = $row['progress'] <= 42 ? $row['progress'] : 42;
				$array['listen'] = ($row['progress'] > 42 && $row['progress'] <= 76)? $row['progress'] - 42 :($row['progress'] >76?34:0);
				$array['speak'] = ($row['progress'] > 76 && $row['progress'] <= 82)? $row['progress'] - 76 :($row['progress'] >82?6:0);
				$array['write'] = ($row['progress'] > 82 && $row['progress'] <= 84)? $row['progress'] -82:($row['progress'] >84?2:0);
				$this->data['student'][] = $array;
			}
		}
		catch (Exception $ec) {
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		$this->load_view('adc/monitor', $this->data);		
	}
	
	public function student (){
		$this->load_view('adc/student');
	}

	public function mock (){
		$this->load_view('adc/mock');
	}
	
	public function result (){
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
		$this->data['student']['id']	 	= $student['smid'];
		$this->data['student']['name'] 		= $student['student_name'];
		$this->data['student']['time'] 		= date('Y-m-d', $student['createtime']);
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
				if($row['type'] == 'w'){
					$this->data['student']['write'] += $row['student_score'];
				}	
				if($row['type'] == 's'){
					$this->data['student']['speak'] += $row['student_score'];
				}															
			}		
			$this->data['item'][] = $array;
		}		


		if($student['statment'] == "0"){
			$this->data['student']['read'] = round($this->data['student']['read'] / 3) * 2;
			$this->data['student']['listen'] = $this->data['student']['listen'] - 4 >= 0 ? $this->data['student']['listen'] - 4 : 0;			
			$this->load_view('adc/result_un',$this->data);
		} else {
			$this->load_view('adc/result',$this->data);
		}
	}
}
