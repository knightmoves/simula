<?php
class Member extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
        $this->load->helper('url');	
		$this->load->library('session');
        $this->load->library('form_validation');
	//	$this->load->model('category_model');
	}

	public function index()
	{
		$this->load->model('user_model');
		$this->load->model('feeds_model');
		$logged = $this->session->userdata('is_logged_in');
		if($logged === TRUE)
		{
			$data = array(
				'id'	=> $this->session->userdata('id'), 
				'login' => $this->session->userdata('login'),
				'name' => $this->session->userdata('name'),
				'is_logged_in' => true
			);
		
			$this->load->view('templates/header');
			$this->load->view('login/dashboard',$data);
			$this->load->view('templates/comment');
			$this->load->view('templates/footer');
		}
		else
		{
			$this->load->view('templates/header');
			$this->load->view('login/view');
			$this->load->view('templates/footer');
		}	
	}	

	public function uploadvideos($error = array())
	{
		$this->load->view('templates/header');
		$username = $this->session->userdata('username');
		if (!empty($username) )
		{
			$data['title'] = array(
									"id" 		=> "title", 
									"name" 		=> "title", 
									"maxlength" => "50",
									"style"     => 'clear:left',
									"title"     => set_value('title'),								 
								 );
			$data['categories'] = $this->category_model->get_categoriesselect();
			$data["error"] = $error;
			$this->load->view('login/upload', $data);
		}	
		else
		{
			$this->load->view('login/view');
		}	
		$this->load->view('templates/footer');

	}

	public function do_upload()
	{
		var_dump($_POST);
		var_dump($_FILES);
//		die();
		$this->form_validation->set_rules('title', 'Video Title', 'required');
		$this->load->model('user_model');
		if($this->form_validation->run() == FALSE)
		{
			$this->uploadvideos();
		}
		else	
		{
			$error = array();
			$config['upload_path'] = './uploads/';
			$config['max_size']	= '110000';
			$config['max_width']  = '110240';
			$config['max_height']  = '17680';
			$config['allowed_types'] = 'x-flv|flv|3gpp|3gp|mpg';
			$userfile = $config['file_name'] = $this->session->userdata('id') . "_" . time() . "_" . $_FILES["userfile"]["name"];
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('userfile'))
			{
				$data = array('upload_data' => $this->upload->data('userfile'));
			}					
			else
			{
				$error[] = "flv file " . $this->upload->display_errors();
				$this->uploadvideos($error);
			}	
			if (empty($error) ) 
			{	
				$config['allowed_types'] = 'jpeg|jpg|png';
				$imagefile = $config['file_name'] = $this->session->userdata('id') . "_" . time() . "_" . $_FILES["imagefile"]["name"];
				$this->upload->initialize($config); 
				if ($this->upload->do_upload('imagefile'))
				{
					$data = array( 	'upload_data' => $this->upload->data('imagefile'));
				}					
				else
				{
					$error[] = "image  file " . $this->upload->display_errors();
					$this->uploadvideos($error);
				}	
			}	
			if (empty($error))
			{
				$this->load->model('video_model');
				$insertdata['vid_title'] = $this->input->post('title');
				$insertdata['vid_flv'] = $userfile;
				$insertdata['vid_flv_img'] = $imagefile;
				$insertdata['vid_category'] = $this->input->post('category');
				$insertdata['vid_userid'] = $this->session->userdata('id');
				$insertdata['vid_dateadded'] = date("Y-m-d, g:i:a");
				$this->video_model->create($insertdata); 
				$this->load->view('templates/header');
				$this->load->view('login/upload_success', $data);
				$this->load->view('templates/footer');
			}
			else
			{	
				$data['title'] = array(
										"id" 		=> "title", 
										"name" 		=> "title", 
										"maxlength" => "50",
										"style"     => 'clear:left',
										"title"     => set_value('title'),								 
									 );
				$data['categories'] = $this->category_model->get_categoriesselect();
				$data["error"] = array();
				$this->load->view('templates/header');
				$this->load->view('login/upload', $data);
				$this->load->view('templates/footer');
			}	
		}
	}
	
}
?>
