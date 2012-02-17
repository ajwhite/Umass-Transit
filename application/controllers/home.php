<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		if ($this->user_model->loggedIn()){
			$this->search();
		} else {
			$this->login();
		}
	}
	
	function bookmark(){
		$this->load->view('template/mobile_header');
		$this->load->view('bookmark');
		$this->load->view('template/mobile_footer');
	}
	
	
	/* new locations:
	
Mall - 367 Russell St. Hadley, MA 42.356958,-72.547488
Amherst Center - 71 S Pleasant St, Amherst MA 42.374541,-72.519743
AmherstPO - 141 N Pleasant St, Amherst Ma 42.377747,-72.519733
Town Houses - 53 Meadow St, Amherst MA 42.409671,-72.533533
Van Meter (the stop is outside butterfield) - 180 Clark Hill Road 42.38879,-72.517474
Franklin - Thatcher Way (no number listed and umass site lists wrong address) 42.389253,-72.522597
library - 280 hicks way 42.389828,-72.528251
Morill 1 - 637 N Pleasant st 42.390949,-72.52396
Bartlett - 130 Hicks Way 42.387958,-72.528761


	*/
	
	function test(){
		$data['routes'] = array(
			array(
				'label' => 'Bartlett',
				'value' => 'Bartlett',
				'address' => '280 Hicks way, Amherst MA',
				'id' =>1
			),
			array(
				'label' => 'Morill',
				'value' => 'Morill',
				'address' => '544 N Pleasant Street, Amherst MA',
				'id' =>2
			)
		);
		$data['content'] = 'dev_mobile';
		$this->load->view('template/mobile_template', $data);
	}
	
	
	public function search(){
		/*
		$this->load->view('template/header');
		$this->load->view('dev');
		$this->load->view('template/footer');
		*/
		$this->test();
	}
	
	public function login($userID = null){
		if (!isset($userID))
			$userID = $this->input->post('user');
		$err = $this->session->flashdata('login_required');
		if (strlen($userID)>0){
			if ($this->user_model->login($userID)){
				redirect('/');
			}
			// handle an error when using auth
		}
		$data['login_required'] = (strlen($err)>0) ? true:false;
		$data['content'] = 'login';
		$this->load->view('template/mobile_template', $data);
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('/');
	}
}
