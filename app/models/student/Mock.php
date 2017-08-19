<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mock extends CI_Model {
	
	public function __construct () {
		parent::__construct ();	
		$this->load->database();
		$this->load->library ('func');
		$this->data = array('state'=>'success', 'reson'=>'Mission Complete');
	}

	public function prereading (){
		$sql = "select * from mock_tpo_item where serialnumber = 0 and tid = ?";
		$res = $this->db->query ($sql, array($_SESSION['tid']));
		$result = $res->row_array ();

		$_SESSION['time'] = 3600;
		$this->data['exam'] = $result ;
		$this->data['token'] = $_SESSION['token'];
		$this->data['time'] = $_SESSION['time'];
		$this->load_view ($result['page_tmp'], $this->data);
	}

	public function review (){
		$time = $this->input->post('time');
		if(!$time){
			throw new Exception("Error Processing Request");
		}
		$sql = "select i.*,a.* from mock_tpo_item i left join mock_student_answer a 
			on a.qid = i.qid and a.mid = ? and a.smid=? 
			where i.tid=? and i.is_question = '1' and i.type='r' order by i.qid";
		$res = $this->db->query ($sql, array($_SESSION['mid'], $_SESSION['smid'], $_SESSION['tid']));
		$result = $res->result_array();
		$this->data['question'] = array();
		foreach ($result as $row) {
			$row['question_json'] = json_decode($row['question_json'], true);
			$row['student_answer'] = empty($row['student_answer']) ? '--' : $row['student_answer'];
			$this->data['question'][] = $row;
		}
		$_SESSION['time'] = $time;
		$this->data['time'] = $time ;
		$this->data['token'] = $_SESSION['token'];
		$this->data['serialnumber'] = $_SESSION['sn'] - 1;
		$this->data['sequence'] = $_SESSION['sequence'];
		$this->load_view('student/reading/read_review', $this->data);
	}

	public function viewtext (){
		$time = $this->input->post('time');
		if(!$time){
			throw new Exception("Error Processing Request");
		}
		$sn = $_SESSION['sn'];
		if($sn < 16){
			$sql = "select read1 as article from mock_tpo where tid = ?";
		}else if($sn < 31){
			$sql = "select read2 as article from mock_tpo where tid = ?";
		}else {
			$sql = "select read3 as article from mock_tpo where tid = ?";
		}
		$res = $this->db->query ($sql, array($_SESSION['tid']));
		$config = $res->row_array();
		$this->data['article'] 	= $config['article'];	

		$_SESSION['time'] = $time;
		$this->data['time'] = $time ;
		$this->data['serialnumber'] = $sn - 1 ;
		$this->data['token'] = $_SESSION['token'];
		$this->data['sequence'] = $_SESSION['sequence'];
		$this->load_view('student/reading/read_textview', $this->data);
	}

	public function reading (){
		$sequence = $this->input->post('sequence');
		$starttime = $this->input->post('starttime');
		$endtime = $this->input->post('endtime');
		$beyound = $this->input->post('beyound');
		$token = $this->input->post('token');
		$isover = $this->input->post('isover');
		$answer = $this->input->post('answer');
		$qid = $this->input->post('qid');
		$sn = $this->input->post('sn');

		if(!$sequence || !$token || !$isover ){
			throw new Exception("Error Processing Request");
		}
		if ($_SESSION['token'] != $token){
			throw new Exception ('Request parameter token is error');
		}
		if ($sn < 0){
			throw new Exception ('Request parameter sncode is error');
		}

		$next_sn = $sn + 1;
		$_SESSION['sn'] = $next_sn;
		$_SESSION['sequence'] = $sequence;

		if($answer && $qid){
			$sql = "select * from mock_student_answer where qid = ? and smid =? and mid = ?";
			$res = $this->db->query($sql, array($qid, $_SESSION['smid'], $_SESSION['mid']));
			$sql = "select score, right_answer from mock_tpo_item where qid = ?";
			$item = $this->db->query($sql, array($qid));
			$result = $item->row_array();
			if(strlen($result['right_answer']) > 2){
				$score = $result['score'] - count(array_diff (explode(' ', $result['right_answer']), explode(' ', $answer)));
				$score = $score < 0 ? 0 : $score;
			}else {
				$score = $result['right_answer'] == $answer ? $result['score'] : 0;
			}
			if(!$res || $res->num_rows() == 0){
				$sql = "insert into mock_student_answer (smid, qid, mid, student_answer, mock_starttime, mock_endtime, student_score) values(?,?,?,?,?,?,?) ";
				$this->db->query($sql, array($_SESSION['smid'], $qid, $_SESSION['mid'], $answer, $starttime, $endtime, $score));	
				$this->func->update_student_progress ($next_sn);			
			}else{
				$counttime = $starttime-$endtime;
				$sql = "update mock_student_answer set student_answer = ?, mock_endtime = mock_endtime - ?, student_score = ? where smid = ? and qid =? and mid = ?";
				$this->db->query($sql, array($answer , $counttime, $score, $_SESSION['smid'], $qid, $_SESSION['mid']));
			}
		}

		if($next_sn == 46){
			unset($_SESSION['time']);
			redirect('/mock/prelistening');
		}
		if($isover == 'y' || $endtime == 0){
			$_SESSION['sn'] = 46;
			unset($_SESSION['time']);
			redirect('/mock/prelistening');
		}		

		if($beyound && $beyound == 'y'){
			if($sn==0||$sn==1||$sn==2||$sn==16||$sn==17||$sn==31||$sn==32) {
				throw new Exception("can not beyound: ".$sequence);
			}
			$next_sn = $sn - 1;
		}
		
		$sql = "select i.*, a.student_answer from mock_tpo_item i left join mock_student_answer a 
			on a.qid = i.qid and a.mid = ? and a.smid = ? where i.serialnumber = ? and i.tid = ? ";
		$res = $this->db->query ($sql, array($_SESSION['mid'], $_SESSION['smid'], $next_sn, $_SESSION['tid']));
		if(!$res || $res->num_rows() == 0){
			throw new Exception("can not search the data by sn: ".$next_sn);
		}
		$result = $res->row_array();
		$this->data['exam'] = $result;

		if($sn < 16){
			$sql = "select read1 as article from mock_tpo where tid = ?";
		}else if($sn < 31){
			$sql = "select read2 as article from mock_tpo where tid = ?";
		}else {
			$sql = "select read3 as article from mock_tpo where tid = ?";
		}
		$res = $this->db->query ($sql, array($_SESSION['tid']));
		$config = $res->row_array();
		$this->data['article'] 	= $config['article'];	

		$_SESSION['time'] = $endtime;
		$this->data['time']		= $_SESSION['time'];	
		$this->data['token']	= $_SESSION['token'];
		$this->load_view($result['page_tmp'], $this->data);	
	}


	# listening
	public function prelistening (){
		if(!isset($_SESSION['sequence']) || $_SESSION['sn'] != 46){
			throw new Exception ('Session parameter is error in prelistening');
		}
		$sql = "select * from mock_tpo_item where serialnumber = ? and tid = ?";
		$res = $this->db->query ($sql, array($_SESSION['sn'], $_SESSION['tid']));
		$result = $res->row_array ();
		$this->data['exam'] = $result;

		$this->data['token'] = $_SESSION['token'];
 		$this->load_view($result['page_tmp'], $this->data);
	}

	public function listensection (){
		$sequence = $this->input->post('sequence');
		$token = $this->input->post('token');
		$sn = $this->input->post('sn');
		if(!$sequence || !$token || !$sn){
			throw new Exception("Error Processing Request");
		}
		if ($token != $_SESSION['token']){
			throw new Exception("Error Processing Request", 1);
		}
		
		$next_sn = $sn + 1;
		$_SESSION['sn'] = $next_sn;
		$_SESSION['sequence'] = $sequence;

		$sql = "select * from mock_tpo_item where serialnumber = ? and tid = ?";
		$res = $this->db->query ($sql, array($next_sn, $_SESSION['tid']));
		$result = $res->row_array ();

		$this->data['exam'] = $result;
		$this->data['token'] = $_SESSION['token'];
 		$this->load_view($result['page_tmp'], $this->data);
	}

	public function listening(){
		$sequence = $this->input->post('sequence');
		$starttime = $this->input->post('starttime');
		$endtime = $this->input->post('endtime');
		$token = $this->input->post('token');
		$isover = $this->input->post('isover');
		$answer = $this->input->post('answer');
		$qid = $this->input->post('qid');
		$sn = $this->input->post('sn');

		if(!$sequence || !$token || !$isover || !$sn){
			throw new Exception("Error Processing Request");
		}
		if ($_SESSION['token'] != $token){
			throw new Exception ('Request parameter token is error');
		}

		$next_sn = $sn + 1;
		$_SESSION['sn'] = $next_sn;
		$_SESSION['sequence'] = $sequence;

		if($answer && $qid){
			$sql = "select score, right_answer from mock_tpo_item where qid = ?";
			$item = $this->db->query($sql, array($qid));
			$result = $item->row_array();
			$score = 0;
			if(strlen($result['right_answer']) > 2){
				$score = count(array_diff (explode(' ', $result['right_answer']), explode(' ', $answer))) == 0? 1 : 0;
			}else {
				$score = $result['right_answer'] == $answer ? $result['score'] : 0;
			}
			
			$sql = "insert into mock_student_answer (smid, qid, mid, student_answer, mock_starttime, mock_endtime, student_score) values(?,?,?,?,?,?,?) ";
			$this->db->query($sql, array($_SESSION['smid'], $qid, $_SESSION['mid'], $answer, $starttime, $endtime, $score));	
			$this->func->update_student_progress ($next_sn);								
		}

		if($next_sn == 90){
			unset($_SESSION['time']);
			redirect('/mock/prespeaking');
		}

		if($isover == 'y'){
			if($next_sn < 69){
				$next_sn = 69;
			}else{
				$_SESSION['sn'] = 90;
				redirect('/mock/prespeaking');
			}
		}		

		if (!isset($_SESSION['time']) || $next_sn == 69){
			$_SESSION['time'] = 600;
			$endtime = 600;
		}

		$sql = "select * from mock_tpo_item where serialnumber = ? and tid = ?";
		$res = $this->db->query ($sql, array($next_sn, $_SESSION['tid']));
		if(!$res || $res->num_rows() == 0){
			throw new Exception("can not search the data by sn: ".$next_sn);
		}
		$result = $res->row_array();
		$this->data['exam'] = $result;

		$_SESSION['time'] = $endtime;
		$this->data['time']		= $_SESSION['time'];	
		$this->data['token']	= $_SESSION['token'];

		$this->load_view($result['page_tmp'], $this->data);	
	}

	# speaking
	public function prespeaking (){
		if(!isset($_SESSION['sequence']) || $_SESSION['sn'] != 90){
			throw new Exception ('Session parameter is error in prespeaking');
		}
		$sql = "select * from mock_tpo_item where serialnumber = ? and tid = ?";
		$res = $this->db->query ($sql, array($_SESSION['sn'], $_SESSION['tid']));
		$result = $res->row_array ();
		$this->data['exam'] = $result ;
		$this->data['token'] = $_SESSION['token'];
 		$this->load_view($result['page_tmp'], $this->data);		
	}

	public function speakingdirections (){
		$sequence = $this->input->post('sequence');
		$token = $this->input->post('token');
		$sn = $this->input->post('sn');

		if(!$sequence || !$token || !$sn){
			throw new Exception("Error Processing Request");
		}
		if ($token != $_SESSION['token']){
			throw new Exception("Error Token Request");
		}
		
		$next_sn = $sn + 1;
		$_SESSION['sn'] = $next_sn;
		$_SESSION['sequence'] = $sequence;

		$sql = "select * from mock_tpo_item where serialnumber = ? and tid = ?";
		$res = $this->db->query ($sql, array($next_sn, $_SESSION['tid']));
		$result = $res->row_array ();
		$this->data['exam'] = $result ;
		$this->data['token'] = $_SESSION['token'];
 		$this->load_view($result['page_tmp'], $this->data);		
	}


	public function speaking (){
		$sequence = $this->input->post('sequence');
		$token = $this->input->post('token');
		$answer = $this->input->post('answer');
		$sn = $this->input->post('sn');

		if(!$sequence || !$token || !$sn){
			throw new Exception("Error Processing Request");
		}
		if ($_SESSION['token'] != $token){
			throw new Exception ('Request parameter token is error');
		}

		$next_sn = $sn + 1;
		$_SESSION['sn'] = $next_sn;
		$_SESSION['sequence'] = $sequence;

		if($next_sn == 98){
			unset($_SESSION['time']);
			redirect('/mock/prewriting');
		}

		$sql = "select * from mock_tpo_item where serialnumber = ? and tid = ?";
		$res = $this->db->query ($sql, array($next_sn, $_SESSION['tid']));
		if(!$res || $res->num_rows() == 0){
			throw new Exception("can not search the data by sn: ".$next_sn);
		}
		$result = $res->row_array();
		$this->data['exam'] = $result;
		$this->data['token']	= $_SESSION['token'];

		$this->load_view($result['page_tmp'], $this->data);			
	}

	public function upload(){
		try{
			$qid = $this->input->post('qid');
			$sn = $this->input->post('sn');
			$token = $this->input->post('token');
			$sessionid = $this->input->post('sessionid');
			if(!$qid || !$sn || !$token || !$sessionid){
				throw new Exception("传输失败, 数据不完整");
			}
			if(md5("TEA") != $token){
				throw new Exception("token 信息错误, 禁止上传");
			}
			if ($sn == 92){
				session_destroy();
				session_id($sessionid);
				session_start();
			}
			$student = $_SESSION['student'] ;
			$config['upload_path']      = $student['path'];
			$config['allowed_types']    = 'wav';
			$config['file_name']    = $student['student_name']."".time();

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('file')){
				throw new Exception($this->upload->display_errors());
			}
			$file_name = $this->upload->data('file_name');
			$query = "insert into mock_student_answer (smid, qid, mid, student_answer, mock_starttime, mock_endtime) value (?,?,?,?,?,?) ";
			$res = $this->db->query ($query, array($_SESSION['smid'], $qid, $_SESSION['mid'], $file_name, 0 ,0));
			$this->func->update_student_progress ($_SESSION['sn']);
			if(!$res || $this->db->affected_rows() == 0){
				throw new Exception("传输失败, 更新数据信息失败");
			}
			$this->data['reson'] = "上传成功";
		}
		catch (Exception $ec) {
			$this->data['state'] = 'failed';
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();
	}

	# writing 
	public function prewriting (){
		if(!isset($_SESSION['sequence']) || $_SESSION['sn'] != 98){
			throw new Exception ('Session parameter is error in prewriting');
		}
		$sql = "select * from mock_tpo_item where serialnumber = ? and tid = ?";
		$res = $this->db->query ($sql, array($_SESSION['sn'], $_SESSION['tid']));
		$result = $res->row_array ();
		$this->data['exam'] = $result ;
		$this->data['token'] = $_SESSION['token'];
 		$this->load_view($result['page_tmp'], $this->data);		
	}

	public function writing (){
		$sequence = $this->input->post('sequence');
		$token = $this->input->post('token');
		$starttime = $this->input->post('starttime');
		$endtime = $this->input->post('endtime');
		$qid = $this->input->post('qid');
		$answer = $this->input->post('answer');
		$sn = $this->input->post('sn');

		if(!$sequence || !$token || !$sn){
			throw new Exception("Error Processing Request");
		}
		if ($token != $_SESSION['token']){
			throw new Exception("Error Token Request");
		}
		
		$next_sn = $sn + 1;
		$_SESSION['sn'] = $next_sn;
		$_SESSION['sequence'] = $sequence;
		if($qid){
			$answer = !$answer ? "" : $answer;
			$sql = "insert into mock_student_answer (smid, qid, mid, student_answer, mock_starttime, mock_endtime) values(?,?,?,?,?,?) ";
			$this->db->query($sql, array($_SESSION['smid'], $qid, $_SESSION['mid'], $answer, $starttime, $endtime));	
			$this->func->update_student_progress ($next_sn);			
		}

		if($next_sn == 105){
			redirect('/mock/end');
		}

		$sql = "select * from mock_tpo_item where serialnumber = ? and tid = ?";
		$res = $this->db->query ($sql, array($next_sn, $_SESSION['tid']));
		$result = $res->row_array ();

		switch ($next_sn) {
			case 100:
				$time = 180;
				break;
			case 102:
				$time = 1200;
				break;	
			case 104:
				$time = 1800;
				break;										
			default:
				$time = 0;
				break;
		}
		$_SESSION['time'] = $time;
		$this->data['time'] = $time;

		$this->data['exam'] = $result ;
		$this->data['token'] = $_SESSION['token'];
 		$this->load_view($result['page_tmp'], $this->data);		
	}


	public function end (){
		if(isset($_SESSION['sn'])){
			if( $_SESSION['sn'] == 105 ){
				$this->db->trans_start();
				$query = "update mock_student_info set valid='0' where sid = ?";
				$res = $this->db->query ($query, array($_SESSION['sid']));
				$query = "update mock_student_tpo set state='0' where smid = ?";
				$res = $this->db->query ($query, array($_SESSION['smid']));				
				$this->db->trans_commit();
				
				$_SESSION['state'] = '0';
				$this->data['reson'] = "考试结束, 数据同步到教师端完成";
				$this->load_view('student/end', $this->data);
			}
			if($_SESSION['sn'] < 105 && $_SESSION['state'] == '0'){				
				$this->data['reson'] = "你已被请出考场, 请联系监考教师";
				$this->load_view('student/end', $this->data);
			}

			// if($_SESSION['sn'] < 105 && $_SESSION['state'] == '1'){	
			// 	$query = "update mock_student_tpo set state='2' where smid = ?";
			// 	$res = $this->db->query ($query, array($_SESSION['smid']));				
			// 	if($_SESSION['sn'] == 0){
			// 		redirect('/mock/prereading');
			// 	}else if($_SESSION['sn'] <= 46){
			// 		$_SESSION['sn'] = 46;
			// 		redirect('/mock/prelistening');
			// 	}else if($_SESSION['sn'] >46 && $_SESSION['sn'] <= 90){
			// 		$_SESSION['sn'] = 90;
			// 		redirect('/mock/prespeaking');
			// 	}else if($_SESSION['sn'] >90 && $_SESSION['sn'] <= 98){
			// 		$_SESSION['sn'] = 98;
			// 		redirect('/mock/prewriting');
			// 	}else if($_SESSION['sn'] >98){
			// 		$_SESSION['sn'] == 105;
			// 		redirect('/mock/end');
			// 	}
			// }

			if($_SESSION['sn'] < 105 && $_SESSION['state'] == '2'){
				$this->data['reson'] = "你怎么会来这里, 完了, 你已经无望考试, 沉寂吧年轻人";
				$this->load_view('student/end', $this->data);
			}						
		}
	}

	public function check_student_state(){
		$query = "select state from mock_student_tpo where smid = ?";
		$res = $this->db->query ($query, array($_SESSION['smid']));
		$result = $res->row_array();
		$_SESSION['state'] = $result['state'];
		if ($this->uri->segment(2)  == 'end' ){
			return ;
		}			
		if ($_SESSION['state'] == "1") {
			redirect("/mock/login");
		}		
		if ($_SESSION['state'] == '0'){
			redirect("/mock/end");
		}			
	}
}
