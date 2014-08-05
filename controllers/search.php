<?php
class Search extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('video_model');
		$this->load->library('session');
		$this->load->helper('url');
	}

	public function show ($page=1)
	{
		
        $config = array();
        $config["base_url"] = base_url() . "/home/show/" . $page;
        $config["total_rows"] = $this->video_model->record_count();
        $config["per_page"] = 8;
        $config["uri_segment"] = 3;
		
		$vid_tags = strtolower($this->input->post('keyword_search'));
		$data['videos'] = $this->video_model->fetch_videos($config["per_page"], $page, $where = "vid_tags "); 
		$this->load->view('templates/header', $data);
		$this->load->view('category/left', $data);
		$this->load->view('category/view', $data);
		$this->load->view('category/left_end');
		$this->load->view('templates/footer');
	}		
}
