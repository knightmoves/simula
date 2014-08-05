<?php
class Pages extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('category_model');
		$this->load->model('video_model');
		$this->load->helper('url');
	}

	public function view($page = 'home')
	{
		if ( ! file_exists('application/views/pages/'.$page.'.php'))
		{
			show_404();
		}

		$data['categories'] = $this->category_model->get_categories();
		$data['videos'] = $this->video_model->get_videos();
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);

	}
}
