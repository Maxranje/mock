<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MkStudent extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->check_student_login();
	}

	public function login (){
		$this->load->model("student/login", "modal");
		$this->modal->login();		
	}

	/**
	 * reading
	 */
	public function prereading(){
		$this->load->model("student/mock", "modal");
		$this->modal->prereading();		
	}

	public function reading (){
		$this->load->model("student/mock", "modal");
		$this->modal->reading();		
	}

	public function review (){
		$this->load->model("student/mock", "modal");
		$this->modal->review();		
	}

	public function viewtext (){
		$this->load->model("student/mock", "modal");
		$this->modal->viewtext();		
	}

	/**
	 * listening
	 * @return [type] [description]
	 */
	public function prelistening (){
		$this->load->model("student/mock", "modal");
		$this->modal->prelistening();				
	}

	public function listensection (){
		$this->load->model("student/mock", "modal");
		$this->modal->listensection();	
	}
	
	public function listening (){
		$this->load->model("student/mock", "modal");
		$this->modal->listening();	
	}

	
	/**
	 * speaking
	 */
	public function prespeaking () {
		$this->load->model("student/mock", "modal");
		$this->modal->prespeaking();			
	}

	public function speakingdirections(){
		$this->load->model("student/mock", "modal");
		$this->modal->speakingdirections();	
	}

	public function speaking(){
		$this->load->model("student/mock", "modal");
		$this->modal->speaking();	
	}

	public function upload(){
		$this->load->model("student/mock", "modal");
		$this->modal->upload();		
	}
	/**
	 *  writing 
	 */

	public function prewriting (){
		$this->load->model("student/mock", "modal");
		$this->modal->prewriting();			
	}

	public function writingdirections (){
		$this->load->model("student/mock", "modal");
		$this->modal->writingdirections();			
	}

	public function writing (){
		$this->load->model("student/mock", "modal");
		$this->modal->writing();			
	}


	public function end (){
		$this->load->model("student/mock", "modal");
		$this->modal->end();		
	}

	private function check_student_login (){
		if (count($this->uri->segment_array()) > 2 ){
			show_404("arguments to manay");
		}
		if ($this->uri->segment(2) == "login" ){
			return ;
		}
		if ($this->uri->segment(2) == "upload" ){
			return ;
		}		
		if (!isset($_SESSION['state']) || !isset($_SESSION['sid'])){
			redirect("/mock/login");
		}

		$this->load->model("student/mock", "modal");
		$this->modal->check_student_state();	
	}
}
