<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MkAdmin extends CI_Controller {
	
	public function __construct () {
		parent::__construct ();	
		$this->check_admin_login();
	}
	
	public function dashboarts (){
		$this->load->model ('admin/examination','model');
		$this->model->index();
	}
	
	public function examination (){
		$this->load->model ('admin/examination','model');
		$this->model->examination();
	}
	
	public function monitor (){
		$this->load->model ('admin/examination','model');
		$this->model->monitor();
	}
	
	public function student (){
		$this->load->model ('admin/examination','model');
		$this->model->student();
	}	
	
	public function result(){
		$this->load->model ('admin/examination','model');
		$this->model->result();
	}

	public function mock (){
		$this->load->model ('admin/examination','model');
		$this->model->mock();
	}	


	# ajax data 
	public function datafactory ($param){
		$this->load->model ('admin/datafactory', 'model');
		$this->model->$param();
	}

	# report pdf 
	public function report ($param){
		$this->load->model ('admin/reportpdf', 'model');
		$this->model->$param();
	}
	

	private function check_admin_login() {
		if ($_SERVER["SERVER_ADDR"] != $_SERVER["REMOTE_ADDR"]) {
			show_error();
		}
	}
}
