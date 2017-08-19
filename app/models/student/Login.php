<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Model {
	
	public function __construct () {
		parent::__construct ();	
		$this->load->database();
		$this->load->library ('func');
		$this->data = array('state'=>'success', 'reson'=>'Mission Complete');
	}

	public function login(){ 
		$token = $this->input->post('token');
		$action = $this->input->post('action');
		try{
			if( $token && $action ) {
				if ($token != $_SESSION['token'] || $action != 'login'){
					throw new Exception("考试验证信息不正确，请通知教师");
				}
				$res = $this->db->query ("select * from mock where state = '1'");
				if(!$res || $res->num_rows() == 0){
					throw new Exception("暂无考场信息，请通知教师保证考场信息正确");
				}
				$mock = $res->row_array();
				$_SESSION['mid'] = $mock['mid'];
				$_SESSION['tid'] = $mock['tid'];
				$_SESSION['state']	= '2';
				
				$student_path = FCPATH.'./job/'.$_SESSION['student']['student_name'];
				$_SESSION['student']['path'] = $student_path;
				if(! file_exists($student_path)){
					mkdir($student_path, 0777, true) or die('学生目录创建失败');
				}

				if($_SESSION['student']['serialnumber'] != '0'){
					$_SESSION['sn'] = $_SESSION['student']['serialnumber'];
					if($_SESSION['sn'] < 105 ){	
						$query = "update mock_student_tpo set state='2' where smid = ?";
						$res = $this->db->query ($query, array($_SESSION['smid']));				
						if($_SESSION['sn'] <= 46){
							$_SESSION['sequence'] = 'listening';
							$_SESSION['sn'] = 46;
							redirect('/mock/prelistening');
						}else if($_SESSION['sn'] >46 && $_SESSION['sn'] <= 90){
							$_SESSION['sequence'] = 'speaking';
							$_SESSION['sn'] = 90;
							redirect('/mock/prespeaking');
						}else if($_SESSION['sn'] >90 && $_SESSION['sn'] <= 98){
							$_SESSION['sequence'] = 'writing';
							$_SESSION['sn'] = 98;
							redirect('/mock/prewriting');
						}else if($_SESSION['sn'] >98){
							$_SESSION['sn'] == 105;
							redirect('/mock/end');
						}
					}	
				}

				$_SESSION['sn'] = 0;
				$_SESSION['sequence'] = '';

				redirect('/mock/prereading');
			}
			$query = "select t.*, i.* from mock_student_tpo t, mock_student_info i where t.sid = i.sid and  i.valid = '1' and t.state='1' ";
			$res = $this->db->query ($query);
			if(!$res || $res->num_rows() == 0){
				throw new Exception("所有学生已经就绪, 暂无空闲位置, 请联系监考教师");
			}
			$student = $res->row_array();

			$query = "update mock_student_tpo set state = ? where smid = ?";
			$this->db->query($query, array('2', $student['smid']));
			$_SESSION['sid'] 	 	= $student['sid'];
			$_SESSION['smid']		= $student['smid'];
			$_SESSION['student'] 	= $student;
			$this->data['student'] 	= $student;
			
			$token = $this->gettoken ();
			$_SESSION['state'] = '1';
			$_SESSION['token'] = $token;
			$this->data['token'] = $token;
			$this->load_view ('student/login', $this->data);			
		}
		catch (Exception $ec) {
			$this->data['state'] = 'failed';
			$this->data['reson'] = $ec->getMessage ();
		}
		$this->load_view ('student/end', $this->data);
	}


	private function gettoken (){
		return  strtoupper( md5(mt_rand(11111, 99999)) );
	}
}
