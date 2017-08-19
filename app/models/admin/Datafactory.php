<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datafactory extends CI_Model {
	
	public function __construct () {
		parent::__construct ();	
		$this->load->database();
		$this->data = array('state'=>'success', 'reson'=>'Mission Complete');
	}

	public function getchartsdata () {
		try{
			$res = $this->db->query ("select * from mock order by createtime");
			$result = $res->result_array ();
			$this->data['exam'] = array();
			foreach ($result as $value) {
				$array = array();
				$array['time'] = date('Y-m-d', $value['createtime']);
				$array['value'] = $value['mock_stun_count'];
				$this->data['exam'][] = $array;
			}

			$res = $this->db->query ('select * from mock_tpo order by tpo_usedcount') ;
			$result = $res->result_array ();
			$this->data['tpo'] = array();
			foreach ($result as $value) {
				$array = array();
				$array['name'] = $value['tpo_name'];
				$array['value'] = $value['tpo_usedcount'];
				$this->data['tpo'][] = $array;
			}

			$res = $this->db->query ('select mock_location,count(*) count from mock group by mock_location');
			$result = $res->result_array ();
			$this->data['location'] = array();
			foreach ($result as $value) {
				$array = array();
				$array['name'] = $value['mock_location'];
				$array['value'] = $value['count'];
				$this->data['location'][] = $array;
			}
		}
		catch (Exception $ec) {
			$this->data['state'] = 'failed';
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();
	}
	

	/**
	 * exam manage start or stop page
	 */
	//获取历史学生列表
	public function gethistorystudent () {
		try{
			$page = $this->input->post('page');
			$rows = $this->input->post('rows');
			$sc = $this->input->post('sc');
			$sid = $this->input->post('id');
			if(!$page || !$rows){
				throw new Exception("Error Processing Request");
			}
			$page = intval($page);
			$rows = intval($rows);
			$page = ($page - 1) * $rows;
			if($sc){
				$sql = "select * from mock_student_info where student_name like ? and valid = '0' order by createtime desc limit ?, ?";
				$res = $this->db->query ($sql, array('%'.$sc.'%', $page, $rows));
			}else if($sid){
				$query = "select * from mock_student_info where sid = ?";
				$res = $this->db->query ($query, $sid);
				$query = "select smid from mock_student_tpo t, mock_student_info i where t.sid = ? and t.sid = i.sid and t.mid = 0";
				$tt = $this->db->query ($query, array($sid));
				if($tt->num_rows() == 0){
					$query = "insert into mock_student_tpo (sid, state, mid) value (?, ?, ?)";
					$this->db->query ($query, array($sid, '0', '0'));					
				}
			} else {
				$sql = "select * from mock_student_info where valid = '0' order by createtime desc limit ?, ?";
				$res = $this->db->query ($sql, array($page, $rows));				
			}
			$result = $res->result_array ();
			$this->data['rows'] = array();
			foreach ($result as $row) {
				$array =array();
				$array['id'] 		= $row['sid'];
				$array['sex'] 		= $row['student_sex'];
				$array['name'] 		= $row['student_name'];
				$array['age'] 		= $row['student_age'];
				$array['phone'] 	= $row['student_phone'];
				$array['school']	= $row['student_school'];
				$array['major'] 	= $row['student_major'];
				$array['class'] 	= $row['student_class'];
				$array['email'] 	= $row['student_email'];
				$this->data['rows'][] = $array;
			}
			$this->data['total'] = $res->num_rows();
		}
		catch(Exception $ec) {
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();			
	}

	public function getunmockstudent (){
		try{
			$page = $this->input->post('page');
			$rows = $this->input->post('rows');
			if(!$page || !$rows){
				throw new Exception("Error Processing Request", 1);
			}
			$page = intval($page);
			$rows = intval($rows);
			$page = ($page - 1) * $rows;
			
			$sql = "select i.* from mock_student_info i, mock_student_tpo t where i.valid = '0' and t.mid = 0 and i.sid = t.sid 
				order by createtime desc limit ?, ?";
			$res = $this->db->query ($sql, array($page, $rows));				
			$result = $res->result_array ();
			$this->data['rows'] = array();
			foreach ($result as $row) {
				$array =array();
				$array['id'] 		= $row['sid'];
				$array['sex'] 		= $row['student_sex'];
				$array['name'] 		= $row['student_name'];
				$array['age'] 		= $row['student_age'];
				$array['phone'] 	= $row['student_phone'];
				$array['school']	= $row['student_school'];
				$array['major'] 	= $row['student_major'];
				$array['class'] 	= $row['student_class'];
				$array['email'] 	= $row['student_email'];
				$this->data['rows'][] = $array;
			}
			$this->data['total'] = $res->num_rows();
		}
		catch(Exception $ec) {
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();				
	}

	public function changestudent (){
		try{
			$name = $this->input->post('name');
			$age = $this->input->post('age');
			$sex = $this->input->post('sex');
			$phone = $this->input->post('phone');
			$school = $this->input->post('school');
			$major = $this->input->post('major');
			$class = $this->input->post('class');
			$email = $this->input->post('email');
			$id = $this->input->post('id');

			if(!$name || !$phone){
				throw new Exception("请求失败， 学生姓名或手机号未填写，请确认");
			}

			$this->db->trans_start();
			if (!$id) {
				$query = "select sid from mock_student_info where student_name = ? and student_phone = ?";
				$res = $this->db->query ($query, array($name, $phone));
				if(!$res || $res->num_rows() > 0){
					throw new Exception("学生姓名和手机号已经存在, 系统判断应为同一人, 请确认");
				}
				$query = "insert into mock_student_info (student_name,student_age,student_sex,student_phone,student_school,
					student_major, student_class,student_email,createtime, valid) values (?,?,?,?,?,?,?,?,?,?)";
				$res = $this->db->query ($query, array($name, $age, $sex,$phone, $school, $major, $class, $email, time(), '0'));
				if(!$res || $this->db->affected_rows() == 0){
					throw new Exception("系统错误, 请联系管理员");
				}
				$id = $this->db->insert_id();			
			}else {
				$sql = "update examination_student set student_name=?,student_age=?,student_sex=?,student_phone=?,
					student_school=?,student_major=?,student_class=?,student_email=? where sid = ?";
				$res = $this->db->query ($sql, array($name, $age, $sex, $phone, $school, $major,$class, $email, $id));
			}
			$query = "insert into mock_student_tpo (sid, mid, state) value (?, ?, ?)";
			$this->db->query ($query, array($id, '0', '0'));				
			$this->data['id'] = $id;
			$this->db->trans_commit();
		}
		catch(Exception $ec) {
			$this->db->trans_rollback();
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();				
	}
	
	public function removestudent (){
		try{
			$id = $this->input->post('id');
			if(!$id){
				throw new Exception("请选中一条考生记录后进行操作");
			}
			$this->db->trans_start();
			$query = "select * from mock_student_tpo where sid = ? and mid != 0";
			$res = $this->db->query ($query, array($id));
			if($res->num_rows () == 0){
				$res = $this->db->query ("delete from mock_student_info where sid = ?", array($id));
				if(!$res || $this->db->affected_rows() == 0){
					throw new Exception("删除学生模考记录信息失败");
				}				
			}
			$res = $this->db->query ("delete from mock_student_tpo where sid = ? and mid = 0", array($id));
			if(!$res || $this->db->affected_rows() == 0){
				throw new Exception("删除学生本次考试信息失败, 信息可能已被删除, 请刷新确认， 如没删除请联系管理员");
			}			
			$this->db->trans_commit();
			$this->data['reson'] = "删除成功";
		}
		catch(Exception $ec) {
			$this->db->trans_rollback();
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();		
	}
	
	public function startexam (){
		try{
			$tid = $this->input->post('id');
			$str = $this->input->post('idstr');
			$place = $this->input->post('place');
			$teacher = $this->input->post('teacher');
			if(!$tid || !$str) {
				throw new Exception("系统告警提示： 模考试题未选择或未添加本次模考考生");
			}
			$idarray = explode(",", $str);
			if(empty($idarray)){
				throw new Exception("考生数据未上报，或未添加考生信息");	
			}
			$place = !$place ? "北京" : $place;
			$teacher = !$teacher ? "admin" : $teacher;
			
			$this->db->trans_start();
			$query = "insert into mock (tid,mock_location,mock_teacher, createtime, mock_stun_count, state) values (?,?,?,?,?, ?)";
			$res = $this->db->query ($query, array($tid, $place,$teacher,time(),count($idarray),'1'));
			if(!$res || $this->db->affected_rows() == 0){
				throw new Exception("考试信息未保存成功， 请重试");
			}					
			$_SESSION['mid'] = $this->db->insert_id();
			$res = $this->db->query ("update mock_tpo set tpo_usedcount = tpo_usedcount+1  where tid = ?", array($tid));
			if(!$res || $this->db->affected_rows() == 0){
				throw new Exception("考题信息未配置成功, 请重试");
			}
			$query = "update mock_student_info set valid='1' where sid in (".$str.")";
			$res = $this->db->query ($query);
			if(!$res || $this->db->affected_rows() == 0){
				throw new Exception("考试考生信息未配置成功, 或无学生进行考试");
			}
			$query = "update mock_student_tpo set state='1', mid=? where sid in (".$str.") and mid = 0";
			$res = $this->db->query ($query, array($_SESSION['mid']));
			if(!$res || $this->db->affected_rows() == 0){
				throw new Exception("考试考生信息未配置成功");
			}
			$this->db->trans_commit();
		}
		catch(Exception $ec) {
			$this->db->trans_rollback();
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();			
	}
	
	# stop
	
	public function getexamingstudent (){
		try{
			$page = $this->input->post('page');
			$rows = $this->input->post('rows');
			if(!$page || !$rows){
				throw new Exception("Error Processing Request", 1);
			}
			$page = intval($page);
			$rows = intval($rows);
			$page = ($page - 1) * $rows;
			$sql = "select i.*, t.state from mock_student_info i, mock_student_tpo t where i.sid = t.sid and i.valid = '1' and t.mid = ? limit ?, ?";
			$res = $this->db->query ($sql, array($_SESSION['mid'],$page, $rows));				
			$result = $res->result_array ();
			$this->data['rows'] = array();
			foreach ($result as $row) {
				$array =array();
				$array['id'] 		= $row['sid'];
				$array['sex'] 		= $row['student_sex'];
				$array['name'] 		= $row['student_name'];
				$array['age'] 		= $row['student_age'];
				$array['phone'] 	= $row['student_phone'];
				$array['school']	= $row['student_school'];
				$array['major'] 	= $row['student_major'];
				$array['class'] 	= $row['student_class'];
				$array['email'] 	= $row['student_email'];
				$array['state'] 	= $row['state'];
				$this->data['rows'][] = $array;
			}
			$this->data['total'] = $res->num_rows();
		}
		catch(Exception $ec) {
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();					
	}

	public function shutdown (){
		try{
			$id = $this->input->post('id');
			$state = $this->input->post('state');
			
			if(!$id || !$state){
				throw new Exception("禁止学生考试失败, 未选择具体学生，请确认");
			}
			$state = $state =="shutdown"?'0':'1';
			$sql = "update mock_student_tpo set state = ? where sid = ? and mid = ?";
			$res = $this->db->query ($sql, array($state, $id, $_SESSION['mid']));
			if($this->db->affected_rows() == 0){
				throw new Exception("禁止学生考试失败， 更新状态失败, 请重新尝试");
			}
		}
		catch(Exception $ec) {
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();			
	}

	public function shutdownall (){
		try{
			if(!isset($_SESSION['mid'])){
				throw new Exception("系统发生异常, 请重新尝试");
			}
			$this->db->trans_start();
			$this->db->query("update mock_student_info set valid='0' where valid = '1'");
			$this->db->query("update mock_student_tpo set state='0' where mid = ?", array($_SESSION['mid']));
			
			$res = $this->db->query("update mock set state = '0' where mid=?", array($_SESSION['mid']));
			if($this->db->affected_rows() == 0){
				throw new Exception("更新考场状态失败, 请重新尝试");
			}
			unset($_SESSION['mid']);
			$this->db->trans_commit();
		}
		catch(Exception $ec) {
			$this->db->trans_rollback();
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();			
	}

	public function getstudentmanage () {
		try{
			$page = $this->input->post('page');
			$rows = $this->input->post('rows');
			$sc = $this->input->post('sc');
			$sid = $this->input->post('id');
			if(!$page || !$rows){
				throw new Exception("Error Processing Request", 1);
			}
			$page = intval($page);
			$rows = intval($rows);
			$page = ($page - 1) * $rows;
			if(!$sid){
				if($sc){
					$sql = 'select sid, student_name name, "closed" as state from mock_student_info where student_name like ? order by createtime desc limit ?, ?';
					$res = $this->db->query ($sql, array('%'.$sc.'%', $page, $rows));
				} else {
					$sql = 'select sid, student_name name, "closed" as state from mock_student_info order by createtime desc limit ?, ?';
					$res = $this->db->query ($sql, array($page, $rows));			
				}
				$result = $res->result_array ();
				$this->data['rows'] = $result;
				$this->data['total'] = $res->num_rows();

			} else {
				$query = 'select t.statment, t.score, t.smid, m.mock_location, m.createtime, tp.tpo_name 
					from mock_student_tpo t, mock m, mock_tpo tp where tp.tid = m.tid and m.mid = t.mid and t.sid =?';
				$res = $this->db->query ($query, array( $sid ) );
				$result = $res->result_array();
				$this->data['rows'] = array();
				foreach ($result as $row) {
					$array =array();
					$array['smid'] 		= $row['smid'];
					$array['sid'] 		= $row['smid'];
					$array['name'] 		= $row['smid'];
					$array['statment']	= $row['statment'];
					if($row['statment'] == '0'){
						$array['score']		= "<a class='font-bold text-danger'>未评分</a>";
					}else{
						$array['score']		= $row['score'];
					}
					$array['options'] 	= '<a href="/mkadc/result?id='.$row['smid'].'" title="详细信息"><i class="fa fa-file-word-o fa-lg text-info"></i></a>';
					$array['tponame'] 	= $row['tpo_name'];
					$array['state'] 	= 'open';
					$array['location'] 	= $row['mock_location'];
					$array['time'] 		= date('Y-m-d', $row['createtime']);
					$this->data['rows'][] = $array;
				}
				echo json_encode($this->data['rows']);
				exit();		
			}
		}
		catch(Exception $ec) {
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();			
	}	

	// 获取未评分的学生列表
	public function getstudentunscorelist () {
		try{
			$page = $this->input->post('page');
			$rows = $this->input->post('rows');
			$sc = $this->input->post('sc');
			if(!$page || !$rows){
				throw new Exception("Error Processing Request", 1);
			}
			$page = intval($page);
			$rows = intval($rows);
			$page = ($page - 1) * $rows;
			if($sc){
				$query = "select si.student_name, st.smid, m.mock_location, m.createtime, t.tpo_name
					from mock m, mock_tpo t, mock_student_tpo st, mock_student_info si
					where st.statment = '0' and m.mid = st.mid and m.tid = t.tid and st.sid = si.sid and si.student_name like ? order by m.createtime desc limit ?,?";
				$res = $this->db->query ($query, array('%'.$sc.'%', $page, $rows));
			} else {
				$query = "select si.student_name, st.smid, m.mock_location, m.createtime, t.tpo_name
					from mock m, mock_tpo t, mock_student_tpo st, mock_student_info si
					where st.statment = '0' and m.mid = st.mid and m.tid = t.tid and st.sid = si.sid order by m.createtime desc limit ?,?";
				$res = $this->db->query ($query, array($page, $rows));			
			}
			$result = $res->result_array ();
			$this->data['total'] = $res->num_rows();
			$this->data['rows'] = array();
			foreach ($result as $row) {
				$array =array();
				$array['smid'] 		= $row['smid'];
				$array['name'] 		= $row['student_name'];
				$array['location']	= $row['mock_location'];
				$array['time']		= date('r', $row['createtime']);
				$array['options'] 	= '<a href="/mkadc/result?id='.$row['smid'].'" title="详细信息"><i class="fa fa-file-word-o fa-lg text-info"></i></a>';
				$array['tponame'] 	= $row['tpo_name'];
				$array['statement'] 	= '<a title="未评分"><i class="fa fa-info-circle fa-lg text-danger" aria-hidden="true"></i></a>';
				$this->data['rows'][] = $array;
			}
		}
		catch(Exception $ec) {
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();			
	}

	// 获取最近一次考试得学生列表
	public function getstudentlastmocklist () {
		try{
			$page = $this->input->post('page');
			$rows = $this->input->post('rows');
			$sc = $this->input->post('sc');
			if(!$page || !$rows){
				throw new Exception("Error Processing Request", 1);
			}
			$page = intval($page);
			$rows = intval($rows);
			$page = ($page - 1) * $rows;

			$res = $this->db->query("select mid from mock order by createtime limit 1");
			$mock = $res->row_array();
			$mid = $mock['mid'];
			if($sc){
				$query = "select si.student_name, st.smid, st.statment, m.mock_location, m.createtime, t.tpo_name
					from mock m , mock_tpo t, mock_student_tpo st, mock_student_info si
					where m.mid = ? and m.mid = st.mid and m.tid = t.tid and st.sid = si.sid and si.student_name like ? order by m.createtime desc limit ?,?";
				$res = $this->db->query ($query, array($mid, '%'.$sc.'%', $page, $rows));
			} else {
				$query = "select si.student_name, st.smid, st.statment, m.mock_location, m.createtime, t.tpo_name
					from mock m, mock_tpo t, mock_student_tpo st, mock_student_info si
					where m.mid = ? and m.mid = st.mid and m.tid = t.tid and st.sid = si.sid order by m.createtime desc limit ?,?";
				$res = $this->db->query ($query, array($mid, $page, $rows));			
			}
			$result = $res->result_array ();
			$this->data['total'] = $res->num_rows();
			$this->data['rows'] = array();
			foreach ($result as $row) {
				$array =array();
				$array['smid'] 		= $row['smid'];
				$array['name'] 		= $row['student_name'];
				$array['location']	= $row['mock_location'];
				$array['time']		= date('r', $row['createtime']);
				$array['options'] 	= '<a href="/mkadc/result?id='.$row['smid'].'" title="详细信息"><i class="fa fa-file-word-o fa-lg text-info"></i></a>';
				$array['tponame'] 	= $row['tpo_name'];
				if($row['statment'] == '0'){
					$array['statement'] = '<a title="未评分"><i class="fa fa-info-circle fa-lg text-danger" aria-hidden="true"></i></a>';
				}else{
					$array['statement'] = '<a><i class="fa fa-check-circle-o fa-lg text-success" aria-hidden="true"></i></a>';
				}
				$this->data['rows'][] = $array;
			}
		}
		catch(Exception $ec) {
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();			
	}


	// mock location filter
	public function getmockbylocation () {
		try{
			$page = $this->input->post('page');
			$rows = $this->input->post('rows');
			$sc = $this->input->post('sc');
			$location = $this->input->post('id');
			if(!$page || !$rows){
				throw new Exception("Error Processing Request", 1);
			}
			$page = intval($page);
			$rows = intval($rows);
			$page = ($page - 1) * $rows;
			if(!$location){
				if($sc){
					$sql = 'select mock_location location, mock_location id, "closed" as state from mock where mock_location like ? group by mock_location limit ?, ?';
					$res = $this->db->query ($sql, array('%'.$sc.'%', $page, $rows));
				} else {
					$sql = 'select mock_location location,mock_location id, "closed" as state from mock group by mock_location limit ?, ?';
					$res = $this->db->query ($sql, array($page, $rows));			
				}
				$result = $res->result_array ();
				$this->data['rows'] = array();
				foreach ($result as $row) {
					$query = 'select avg(readscore) rs, avg(listenscore) ls, avg(speakscore) ss, avg(writescore) ws 
						from mock_student_tpo where mid in (select mid from mock where mock_location = ?)';
					$rt = $this->db->query ($query, array( $row['location'] ));
					$avg = $rt->row_array();
					$row['location'] .= ' 阅读平均分 '.intval($avg['rs']).' 听力平均分 '.intval($avg['ls']).
						' 口语平均分 '.intval($avg['ss']).' 写作平均分 '.intval($avg['ws']);
					$this->data['rows'][] = $row;
				}
				$this->data['total'] = $res->num_rows();

			} else {
				$query = 'select m.mid, m.mock_teacher, m.createtime, m.mock_stun_count ,t.tpo_name
					from mock m, mock_tpo t where m.tid = t.tid and m.mock_location = ?';
				$res = $this->db->query ($query, array( $location ) );
				$result = $res->result_array();
				$this->data['rows'] = array();
				foreach ($result as $row) {
					$array =array();
					$array['id'] 		= $row['mid'];
					$array['mid'] 		= $row['mid'];
					$array['teacher']	= $row['mock_teacher'];
					$array['location']	= $location.$row['mid'];
					$array['count']	= $row['mock_stun_count'];
					$array['options'] 	= '<a href="javascript:;" onclick="charts('.$row['mid'].')" title="详细信息"><i class="fa fa-line-chart text-info"></i></a>';
					$array['tponame'] 	= $row['tpo_name'];
					$array['state'] 	= 'open';
					$array['time'] 		= date('Y-m-d', $row['createtime']);
					$array['score']		= '<a href="javascript:;" onclick="scorelist('.$row['mid'].')" title="平均分"><i class="fa fa-list text-info"></i></a>';
					$this->data['rows'][] = $array;
				}
				echo json_encode($this->data['rows']);
				exit();		
			}
		}
		catch(Exception $ec) {
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();			
	}	

	public function getmockbytpo () {
		try{
			$page = $this->input->post('page');
			$rows = $this->input->post('rows');
			$sc = $this->input->post('sc');
			$tid = $this->input->post('id');
			if(!$page || !$rows){
				throw new Exception("Error Processing Request", 1);
			}
			$page = intval($page);
			$rows = intval($rows);
			$page = ($page - 1) * $rows;
			if(!$tid){
				if($sc){
					$sql = 'select tid, tpo_name tponame, "closed" as state from mock_tpo where tpo_name like ? limit ?, ?';
					$res = $this->db->query ($sql, array('%'.$sc.'%', $page, $rows));
				} else {
					$sql = 'select tid, tpo_name tponame, "closed" as state from mock_tpo limit ?, ?';
					$res = $this->db->query ($sql, array($page, $rows));			
				}
				$result = $res->result_array ();
				$this->data['rows'] = array();
				foreach ($result as $row) {
					$query = 'select avg(readscore) rs, avg(listenscore) ls, avg(speakscore) ss, avg(writescore) ws 
						from mock_student_tpo where mid in (select mid from mock where tid = ?)';
					$rt = $this->db->query ($query, array($row['tid']));
					$avg = $rt->row_array();
					$row['tponame'] .= ' 阅读平均分 '.intval($avg['rs']).' 听力平均分 '.intval($avg['ls']).
						' 口语平均分 '.intval($avg['ss']).' 写作平均分 '.intval($avg['ws']);
					$this->data['rows'][] = $row;
				}
				$this->data['total'] = $res->num_rows();

			} else {
				$query = 'select m.mid, m.mock_teacher, m.createtime, m.mock_stun_count ,t.tpo_name, m.mock_location
					from mock m, mock_tpo t where m.tid = t.tid and t.tid = ?';
				$res = $this->db->query ($query, array( $tid ) );
				$result = $res->result_array();
				$this->data['rows'] = array();
				foreach ($result as $row) {
					$array =array();
					$array['tid'] 		= $row['mid'];
					$array['mid'] 		= $row['mid'];
					$array['teacher']	= $row['mock_teacher'];
					$array['location']	= $row['mock_location'];
					$array['count']	= $row['mock_stun_count'];
					$array['options'] 	= '<a href="javascript:;" onclick="charts('.$row['mid'].')" title="详细信息"><i class="fa fa-line-chart text-info"></i></a>';
					$array['score']		= '<a href="javascript:;" onclick="scorelist('.$row['mid'].')" title="平均分"><i class="fa fa-list text-info"></i></a>';
					$array['tponame'] 	= $row['tpo_name'];
					$array['state'] 	= 'open';
					$array['time'] 		= date('Y-m-d', $row['createtime']);
					$this->data['rows'][] = $array;
				}
				echo json_encode($this->data['rows']);
				exit();		
			}
		}
		catch(Exception $ec) {
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();			
	}

	public function getstudentavgscore () {
		try{
			$mid = $this->input->post('mid');
			if(!$mid ){
				throw new Exception("Error Processing Request", 1);
			}
			$query = 'select avg(readscore) rs, avg(listenscore) ls, avg(speakscore) ss, avg(writescore) ws
				from mock_student_tpo where mid = ?';
			$res = $this->db->query ($query, array($mid));
			$result = $res->row_array ();
			$this->data['ls'] = intval($result['ls']);
			$this->data['ws'] = intval($result['ws']);
			$this->data['ss'] = intval($result['ss']);
			$this->data['rs'] = intval($result['rs']);

			$query = "select mock_location from mock where mid = ?";
			$res = $this->db->query ($query, array($mid));
			$result = $res->row_array ();
			$this->data['location'] = $result['mock_location'];			
		}
		catch(Exception $ec) {
			$this->data['state'] = "failed";
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();			
	}	

	public function getstudentscore (){
		try{
			$id = $this->input->post('id');
			if(!$id){
				throw new Exception("Error Processing Request");
			}
			$query = "select i.student_name as name, t.score from mock_student_info i, mock_student_tpo t
				where t.sid = i.sid and t.mid=?";
			$res = $this->db->query ($query, array($id));
			$this->data['student'] = $res->result_array ();
		}
		catch (Exception $ec) {
			$this->data['state'] = 'failed';
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();		
	}

	public function markstudent (){
		try{
			$id = $this->input->post('id');
			$score = $this->input->post('score');
			$comments = $this->input->post("comments");
			if(!$id){
				throw new Exception("Error Processing Request");
			}
			$score = !$score ? 0 : $score;
			$query = "update mock_student_answer set student_score = ?, student_comments=? where id =?";
			$this->db->query ($query, array($score, $comments, $id));
		}
		catch (Exception $ec) {
			$this->data['state'] = 'failed';
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();		
	}

	public function studentscore (){
		try{
			$id = $this->input->post('id');
			if(!$id){
				throw new Exception("Error Processing Request");
			}
			$query = "select a.*,i.* from mock_student_answer a left join mock_tpo_item i 
				on i.qid = a.qid where a.smid = ?";
			$res = $this->db->query ($query, array($id));
			$result = $res->result_array();
			$student = array('read'=>0, 'listen'=>0, 'speak'=>0, 'write'=>0);
			foreach ($result as $row) {
				if($row['type'] == 'r'){
					$student['read'] += intval($row['student_score']);
				}
				if($row['type'] == 'l'){
					$student['listen'] += intval($row['student_score']);
				}
				if($row['type'] == 's'){
					$student['speak'] += intval($row['student_score']);
				}
				if($row['type'] == 'w'){
					$student['write'] += intval($row['student_score']);
				}
			}

			$student['read'] = round($student['read'] / 3 ) * 2;
			$student['listen'] = $student['listen'] - 4 >= 0 ? $student['listen'] - 4 : 0;			
			$score = $student['read'] + $student['listen'] +$student['speak'] +$student['write'] ;
			$query = "update mock_student_tpo set readscore =?, listenscore=?,speakscore=?,writescore=?, score=?, statment=? where smid =?";
			$this->db->query ($query, array($student['read'],$student['listen'],$student['speak'],$student['write'],$score, '1', $id)); 
		}
		catch (Exception $ec) {
			$this->data['state'] = 'failed';
			$this->data['reson'] = $ec->getMessage();
		}
		echo json_encode($this->data);
		exit();		
	}

	public function uploadcanvas (){
		try{
			$smid = $this->input->post('id');
			if(!$smid){
				throw new Exception("传输失败, 数据不完整, 错误码:1045");
			}
			$config['upload_path']      = FCPATH."./res/canvas";
			$config['allowed_types']    = 'jpg|jpeg|png|gif';
			$config['file_name']    = $smid."_".time();

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('upload')){
				throw new Exception($this->upload->display_errors());
			}
			$file_name = $this->upload->data('file_name');
			$query = "update mock_student_tpo set canvas = ? where smid = ?";
			$res = $this->db->query ($query, array( $file_name, $smid ));
			if(!$res || $this->db->affected_rows() == 0){
				throw new Exception("传输失败, 更新CANVAS失败");
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
}
