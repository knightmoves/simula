<?php
class Home extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('feeds_model');
		$this->load->helper('url');
	}


	public function index()
	{
        $data['feeds'] = $this->feeds_model->get_feeds();
		$this->load->view('templates/header', $data);
		$this->load->view('pages/home', $data);
		$this->load->view('templates/footer', $data);
	}

	public function show ()
	{
        $data['feeds'] = $this->feeds_model->get_feeds();
		$this->load->view('templates/header', $data);
		$this->load->view('pages/home', $data);
		$this->load->view('templates/footer', $data);
	}

	 function logout()
	 {
	   $this->session->unset_userdata('logged_in');
	   session_destroy();
	   redirect('home', 'refresh');
	 }
}
