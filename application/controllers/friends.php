<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->user_model->loggedIn()){
			$this->session->set_flashdata('login_required', 'true');
			redirect('/');
		} 
		$this->load->model('friend_model');
	}

	public function index()
	{
		$data['name'] = $this->session->userdata('name');
		$data['friends'] = $this->friend_model->getFriendsRoutes();
		
		$data['content'] = 'friends/landing';
		$this->load->view('template/mobile_template', $data);
	}
}