<?php
class Index extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('feeds_model');
		$this->load->helper('url');
		$this->load->helper('form');	
	}

	public function index ($webpage = 'home')
	{
		$data['feeds'] = $this->feeds_model->get_feeds();
		$this->load->view('templates/header', $data);
		$username = $this->session->userdata('username');
		if (!empty($username) )
		{
			$this->load->view('pages/home', $data);
		}
		else
		{
			$this->load->view('login/view', $data);
		}
		$this->load->view('templates/footer', $data);
	}


}
